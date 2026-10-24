<?php

return [
    // School days as ISO weekdays: 1 = Monday ... 7 = Sunday.
    // Mon-Sat by default. For a 5-day week use [1, 2, 3, 4, 5].
    'working_days' => [1, 2, 3, 4, 5, 6],

    // Students below this attendance % are flagged on the dashboard.
    'threshold' => 75,

    // A student needs at least this many marked days before being flagged.
    'alert_min_days' => 3,

    // "Today" for attendance purposes (the app itself stays on UTC).
    'timezone' => 'Asia/Karachi',
];