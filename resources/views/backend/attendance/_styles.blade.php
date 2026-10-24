<style>
    .att-chip{display:inline-block;min-width:22px;padding:2px 6px;border-radius:4px;color:#fff;font-weight:600;font-size:12px;text-align:center;line-height:1.4}
    .att-chip.sm{font-size:11px;padding:1px 5px}
    .att-chip[data-status=present]{background:#28c76f}
    .att-chip[data-status=absent]{background:#ea5455}
    .att-chip[data-status=late]{background:#ff9f43}
    .att-chip[data-status=excused]{background:#00cfe8}
    .att-chip[data-status=half_day]{background:#7367f0}

    .att-select{min-width:98px;padding:3px 6px;border:1px solid #ddd;border-radius:4px;font-weight:600;font-size:13px;cursor:pointer}
    .att-select[data-status=present]{background:#e8f8f0;border-color:#28c76f;color:#1b8a4f}
    .att-select[data-status=absent]{background:#fdeaea;border-color:#ea5455;color:#c23a3b}
    .att-select[data-status=late]{background:#fff3e3;border-color:#ff9f43;color:#c97a1f}
    .att-select[data-status=excused]{background:#e2f9fc;border-color:#00cfe8;color:#0a8fa1}
    .att-select[data-status=half_day]{background:#efedfd;border-color:#7367f0;color:#5548d9}
    .att-select.changed{box-shadow:0 0 0 2px #ff9f43}

    .att-table th.day{min-width:124px;text-align:center;vertical-align:top;background:#f8f9fa}
    .att-table th.day.is-today{background:#fff7e6}
    .att-table .student-col{position:sticky;left:0;background:#fff;min-width:210px;z-index:1}
    .att-table th.student-col{background:#f8f9fa;z-index:2}
    .att-table td{vertical-align:middle}
    .att-legend .att-chip{margin-right:3px}
</style>