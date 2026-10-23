<?php

namespace App\Exports;

use App\Services\Admin\StudentImportService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StudentsTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public function headings(): array
    {
        return StudentImportService::HEADINGS;
    }

    public function array(): array
    {
        return [];
    }

    public function columnFormats(): array
    {
        return array_fill_keys(StudentImportService::TEXT_COLUMNS, NumberFormat::FORMAT_TEXT);
    }
}