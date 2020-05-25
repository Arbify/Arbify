<?php

declare(strict_types=1);

namespace App\Arb\Exporter;

use App\Contracts\Arb\ArbExporter as ArbExporterContract;
use App\Contracts\Arb\ArbFormatter;
use App\Contracts\Repositories\MessageRepository;
use App\Contracts\Repositories\MessageValueRepository;
use App\Models\Language;
use App\Models\Project;
use Illuminate\Filesystem\FilesystemAdapter;
use InvalidArgumentException;
use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class ArbExporter implements ArbExporterContract
{
    private ArbFormatter $arbFormatter;
    private MessageRepository $messageRepository;
    private MessageValueRepository $messageValueRepository;
    private FilesystemAdapter $filesystemAdapter;

    public function __construct(
        ArbFormatter $arbFormatter,
        MessageRepository $messageRepository,
        MessageValueRepository $messageValueRepository
    ) {
        $this->arbFormatter = $arbFormatter;
        $this->messageRepository = $messageRepository;
        $this->messageValueRepository = $messageValueRepository;

        $this->filesystemAdapter = Storage::disk('exports');
    }

    public function exportLanguage(Project $project, Language $language): ExportedFile
    {
        return $this->createArbFile($project, $language);
    }

    public function exportLanguages(Project $project, iterable $languages, int $archiveFormat): ExportedFile
    {
        if (!in_array($archiveFormat, [self::ARCHIVE_ZIP])) {
            throw new InvalidArgumentException('Invalid archive format given.');
        }

        $files = [];
        foreach ($languages as $language) {
            $files[] = $this->createArbFile($project, $language);
        }

        return $this->createArchive($project, $files, $archiveFormat);
    }

    public function getDownloadResponse(ExportedFile $file): StreamedResponse
    {
        return $this->filesystemAdapter->download($file->getFilepath(), $file->getFilename());
    }

    private function createArbFile(Project $project, Language $language): ExportedFile
    {
        $messages = $this->messageRepository->byProject($project);
        $values = $this->messageValueRepository->allByProjectAndLanguage($project, $language);

        $lastModified = md5($this->arbFormatter->formatLastModified($values)['@@last_modified'] ?? '');
        $filepath = sprintf('%s/%s/%s.arb', $project->id, $language->code, $lastModified);

        if ($this->filesystemAdapter->missing($filepath)) {
            $result = $this->arbFormatter->format($language->code, $messages, $values);
            $this->filesystemAdapter->put($filepath, $result);
        }

        return new ExportedFile($filepath, "intl_$language->code.arb");
    }

    /**
     * @param Project $project
     * @param ExportedFile[] $files
     * @param int $archiveFormat
     *
     * @return ExportedFile
     */
    private function createArchive(Project $project, array $files, int $archiveFormat): ExportedFile
    {
        if ($archiveFormat == self::ARCHIVE_ZIP) {
            // Let's get temporary file path.
            $tmpFilename = tempnam(sys_get_temp_dir(), 'export');

            $zip = new ZipArchive();
            $zip->open($tmpFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            foreach ($files as $file) {
                $zip->addFromString($file->getFilename(), $this->filesystemAdapter->get($file->getFilepath()));
            }

            $zip->close();

            $filepath = $this->filesystemAdapter->putFileAs($project->id, $tmpFilename, 'l10n.zip');

            return new ExportedFile($filepath, 'l10n.zip');
        }

        throw new InvalidArgumentException('Not supported archive format.');
    }
}
