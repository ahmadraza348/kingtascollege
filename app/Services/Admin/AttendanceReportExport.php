<?php

namespace App\Exports;

use App\Models\AttendanceLog;
use Carbon\CarbonImmutable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

/** Used for both .xlsx and .csv (the file extension decides). */
class AttendanceReportExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function __construct(private array $report)
    {
    }

    public function headings(): array
    {
        $headings = ['Roll No', 'Student', 'Class', 'Section'];

        if ($this->report['show_grid']) {
            foreach ($this->report['dates'] as $d) {
                $headings[] = CarbonImmutable::parse($d['date'])->format('d M') . ' ' . $d['dow'];
            }
        }

        return [...$headings, 'Present', 'Absent', 'Late', 'Excused', 'Half Day', 'Marked Days', 'Attendance %'];
    }

    public function array(): array
    {
        $out = [];

        foreach ($this->report['rows'] as $row) {
            $s    = $row['student'];
            $line = [$s->roll_number, $s->full_name, $s->schoolClass?->name, $s->section?->name];

            if ($this->report['show_grid']) {
                foreach ($this->report['dates'] as $d) {
                    $status = $row['cells'][$d['date']] ?? null;
                    $line[] = $status ? AttendanceLog::LETTERS[$status] : '';
                }
            }

            $c = $row['counts'];
            $out[] = [...$line, $c['present'], $c['absent'], $c['late'], $c['excused'], $c['half_day'], $row['marked'], $row['percent'] ?? ''];
        }

        $t = $this->report['totals'];
        $blank = array_fill(0, 4 + ($this->report['show_grid'] ? count($this->report['dates']) : 0) - 1, '');
        $out[] = [...$blank, 'TOTAL', $t['present'], $t['absent'], $t['late'], $t['excused'], $t['half_day'], array_sum($t), $this->report['percent'] ?? ''];

        return $out;
    }
}