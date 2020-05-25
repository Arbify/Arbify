<?php

declare(strict_types=1);

namespace App\Contracts\Arb;

use App\Arb\Exporter\ExportedFile;
use App\Models\Language;
use App\Models\Project;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface ArbExporter
{
    public const ARCHIVE_ZIP = 0;

    public function exportLanguage(Project $project, Language $language): ExportedFile;

    /**
     * @param Project $project
     * @param Language[] $languages
     * @param int $archiveFormat
     *
     * @return ExportedFile
     */
    public function exportLanguages(Project $project, iterable $languages, int $archiveFormat): ExportedFile;

    public function getDownloadResponse(ExportedFile $file): StreamedResponse;
}
