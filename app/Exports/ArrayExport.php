<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

/** Exports any report (headings + rows) to Excel or CSV. */
class ArrayExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function __construct(private array $headings, private array $rows)
    {
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function array(): array
    {
        return array_map(fn ($row) => array_map(function ($cell) {
            if (is_array($cell)) {
                return $cell['t'] ?? $cell['n'] ?? '';
            }

            return $cell;
        }, $row), $this->rows);
    }
}