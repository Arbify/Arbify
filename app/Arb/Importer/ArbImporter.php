<?php

declare(strict_types=1);

namespace Arbify\Arb\Importer;

use Arbify\Contracts\Repositories\LanguageRepository;
use Arbify\Contracts\Repositories\MessageRepository;
use Arbify\Contracts\Repositories\MessageValueRepository;
use Arbify\Models\Message;
use Arbify\Models\Project;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Throwable;

class ArbImporter
{
    private LanguageRepository $languageRepository;
    private MessageRepository $messageRepository;
    private MessageValueRepository $messageValueRepository;

    public function __construct(
        LanguageRepository $languageRepository,
        MessageRepository $messageRepository,
        MessageValueRepository $messageValueRepository
    ) {
        $this->languageRepository = $languageRepository;
        $this->messageRepository = $messageRepository;
        $this->messageValueRepository = $messageValueRepository;
    }

    /**
     * @param Project $project
     * @param UploadedFile $file
     * @param bool $overrideMessageValues
     *
     * @throws ImportException
     */
    public function import(Project $project, UploadedFile $file, bool $overrideMessageValues): void
    {
        $contents = $this->getContents($file);
        $json = $this->parseJson($contents);

        $language = $this->determineLanguage($json, $file->getClientOriginalName());
        $messages = $this->processMessages($json);

        $this->importToDatabase($project, $language, $messages, $overrideMessageValues);
    }

    private function getContents(UploadedFile $file): string
    {
        $fileContents = file_get_contents($file->getRealPath());
        if ($fileContents === false) {
            throw new ImportException('Error reading file.');
        }

        return $fileContents;
    }


    private function parseJson(string $contents): array
    {
        $json = json_decode($contents, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ImportException('File is not a valid JSON file.');
        }

        return $json;
    }

    private function determineLanguage($json, string $originalFilename): string
    {
        if (isset($json['@@locale'])) {
            return $json['@@locale'];
        }

        if (1 === preg_match('/^intl_(.*)\.arb$/', $originalFilename, $matches)) {
            $language = $matches[1];

            // https://stackoverflow.com/a/24663196/3158312
            if (preg_match('/^[a-z]{2,3}(?:-[a-zA-Z]{4})?(?:-[A-Z]{2,3})?$/', $language)) {
                return $language;
            }
        }

        throw new ImportException(
            'Cannot determine language from file.',
            'You can fix it by adding <code>@@locale</code> to ARB file '
            . 'or renaming it to <code>intl_&lt;locale&gt;.arb</code>.'
        );
    }

    private function processMessages(array $json): array
    {
        $messages = [];

        foreach ($json as $key => $item) {
            if (0 === strpos($key, '@')) {
                continue;
            }

            // TODO: Distinguish different message types 1-level-deep (gender, plural).
            $messages[] = [
                'name' => $key,
                'value' => $item,
                'description' => $json["@$key"]['description'] ?? null,
            ];
        }

        return $messages;
    }

    private function importToDatabase(
        Project $project,
        string $languageCode,
        array $importedMessages,
        bool $overrideMessageValues
    ): void {
        try {
            $language = $this->languageRepository->byCode($languageCode);
        } catch (ModelNotFoundException $e) {
            throw new ImportException(
                "Invalid language \"$languageCode\".",
                'If you wish to use this language, create it in Languages first.'
            );
        }

        DB::beginTransaction();

        try {
            // Make sure language is present in a given project.
            $project->languages()->syncWithoutDetaching($language->id);

            $projectMessages = $this->messageRepository->byProject($project);

            foreach ($importedMessages as $importedMessage) {
                if (!$projectMessages->contains('name', $importedMessage['name'])) {
                    $message = Message::create([
                        'name' => $importedMessage['name'],
                        'description' => $importedMessage['description'],
                        'type' => Message::TYPE_MESSAGE,
                        'project_id' => $project->id,
                    ]);
                } else {
                    $message = $projectMessages->firstWhere('name', $importedMessage['name']);
                }

                $form = null;
                if ($message->isPlural()) {
                    $form = $language->plural_forms[0];
                } elseif ($message->isGender()) {
                    $form = $language->getGenderForms()[0];
                }

                $messageValue = $this->messageValueRepository->byMessageLanguageAndFormOrCreate(
                    $message,
                    $language,
                    $form
                );

                if ($messageValue->value === null || $overrideMessageValues) {
                    $messageValue->update([
                        'value' => $importedMessage['value'],
                    ]);
                }
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            throw new ImportException('Error while importing into database.', null, $e);
        }
    }
}
