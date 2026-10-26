<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Fee Voucher</title>
<style>
    @page { size: A4 landscape; margin: 6mm; }
    * { box-sizing: border-box; }
    body { margin: 0; color: #111; font-family: "DejaVu Sans", sans-serif; font-size: 8.5pt; }
    .sheet { width: 100%; page-break-after: always; }
    .sheet.last { page-break-after: auto; }
    .copies { width: 100%; table-layout: fixed; border-collapse: separate; border-spacing: 0; }
    .copy-cell { width: 33.333%; vertical-align: top; padding: 0 3mm; }
    .copy-cell.cut { border-right: 1px dashed #777; }
    .copy-title { font-size: 9pt; font-weight: 700; text-align: center; padding: 0 0 3px; }
    .college-name { border: 1px solid #111; text-align: center; font-size: 9pt; font-weight: 700; text-transform: uppercase; line-height: 1.3; padding: 7px 4px; min-height: 39px; }
    .bank-line { min-height: 40px; padding: 5px 3px; font-size: 6.9pt; font-weight: 700; text-align: center; line-height: 1.5; }
    .fields { width: 100%; border-collapse: collapse; table-layout: fixed; }
    .fields td, .fields th { border: 1px solid #222; padding: 4px 5px; vertical-align: middle; line-height: 1.15; }
    .fields .key { width: 48%; }
    .fields .value { width: 52%; text-align: center; font-weight: 600; }
    .fields .installment td { font-size: 9pt; }
    .fields .fee-head th { text-align: center; font-weight: 700; font-size: 8.5pt; }
    .fields .money { text-align: center; width: 37%; white-space: nowrap; }
    .fields .total td { font-weight: 700; font-size: 9pt; }
    .fields .due td:first-child { background: #e5e5e5; text-align: center; font-weight: 700; }
    .fields .due td:last-child { text-align: center; font-weight: 700; }
    .fields .late td { font-size: 7.2pt; font-weight: 700; text-align: center; }
    .fields .late td:first-child { width: 55%; }
    .terms { border: 1px solid #222; border-top: 0; padding: 4px 5px; min-height: 84px; font-size: 6.6pt; line-height: 1.34; }
    .term { margin: 0 0 2px; }
    .copy-cell:last-child { padding-right: 0; }
    .copy-cell:first-child { padding-left: 0; }
</style>
</head>
<body>
@foreach ($items as $data)
    <div class="sheet {{ $loop->last ? 'last' : '' }}">
        <table class="copies"><tr>
            @foreach (['BANK COPY', 'COLLEGE COPY', 'STUDENT COPY'] as $label)
                <td class="copy-cell {{ ! $loop->last ? 'cut' : '' }}">
                    @include('backend.fees.pdf._copy', ['data' => $data, 'label' => $label])
                </td>
            @endforeach
        </tr></table>
    </div>
@endforeach
</body>
</html>
