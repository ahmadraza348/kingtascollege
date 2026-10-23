<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;

/** Tells Laravel Excel that line 1 holds the column headings. */
class StudentsSheet implements WithHeadingRow
{
    public function headingRow(): int
    {
        return 1;
    }
}