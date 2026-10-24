<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 8px; color: #222; }
        h2 { margin: 0 0 2px; font-size: 14px; }
        .meta { color: #555; margin-bottom: 8px; font-size: 9px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #999; padding: 2px 3px; text-align: center; }
        th { background: #eee; }
        td.name { text-align: left; white-space: nowrap; }
        .low { color: #c00; font-weight: bold; }
    </style>
</head>
<body>
@php
    $colors  = \App\Models\AttendanceLog::COLORS;
    $letters = \App\Models\AttendanceLog::LETTERS;
    $pct = fn ($v) => $v === null ? '-' : rtrim(rtrim(number_format($v, 1), '0'), '.') . '%';
    $t = $report['totals'];
@endphp
    <h2>King TAS College — Attendance Report</h2>
    <div class="meta">
        {{ \Carbon\Carbon::parse($report['from'])->format('d M Y') }} to {{ \Carbon\Carbon::parse($report['to'])->format('d M Y') }}
        · {{ $classLabel }} · {{ $sectionLabel }} · {{ $statusLabel }}
        · Overall {{ $pct($report['percent']) }}
        (P {{ $t['present'] }}, A {{ $t['absent'] }}, L {{ $t['late'] }}, E {{ $t['excused'] }}, H {{ $t['half_day'] }})
        · Generated {{ now()->timezone(config('attendance.timezone'))->format('d M Y, h:i A') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th><th>Roll No</th><th>Student</th><th>Class</th>
                @if ($report['show_grid'])
                    @foreach ($report['dates'] as $d) <th>{{ $d['day'] }}<br>{{ substr($d['dow'], 0, 2) }}</th> @endforeach
                @endif
                <th>P</th><th>A</th><th>L</th><th>E</th><th>H</th><th>Days</th><th>%</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($report['rows'] as $row)
            @php $s = $row['student']; $c = $row['counts']; @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $s->roll_number }}</td>
                <td class="name">{{ $s->full_name }}</td>
                <td class="name">{{ $s->schoolClass?->name }} / {{ $s->section?->name }}</td>
                @if ($report['show_grid'])
                    @foreach ($report['dates'] as $d)
                        @php $st = $row['cells'][$d['date']] ?? null; @endphp
                        @if ($st)
                            <td style="background: {{ $colors[$st] }}; color: #fff;">{{ $letters[$st] }}</td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                @endif
                <td>{{ $c['present'] }}</td><td>{{ $c['absent'] }}</td><td>{{ $c['late'] }}</td><td>{{ $c['excused'] }}</td><td>{{ $c['half_day'] }}</td>
                <td>{{ $row['marked'] }}</td>
                <td class="{{ $row['low'] ? 'low' : '' }}">{{ $pct($row['percent']) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p class="meta" style="margin-top:8px">
        P = Present, A = Absent, L = Late, E = Excused, H = Half day. Blank = not marked.
        Present and Late count as 1, Half day as 0.5; excused days are not counted. Weekends and holidays are excluded.
    </p>
</body>
</html>