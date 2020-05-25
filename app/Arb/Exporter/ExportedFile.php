<?php

declare(strict_types=1);

namespace App\Arb\Exporter;

class ExportedFile
{
    private string $filepath;
    private string $filename;

    public function __construct(string $filepath, string $filename)
    {
        $this->filepath = $filepath;
        $this->filename = $filename;
    }

    public function getFilepath(): string
    {
        return $this->filepath;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
