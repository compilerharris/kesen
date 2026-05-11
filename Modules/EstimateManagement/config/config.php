<?php

/**
 * Module defaults merged into config('estimatemanagement').
 * Override values in the application file: config/estimatemanagement.php (tracked in git).
 */
return [
    'name' => 'EstimateManagement',
    'min_line_total' => (float) env('ESTIMATE_MIN_LINE_TOTAL', env('ESTIMATE_BT_MIN_WORD_FLOOR', 500)),
];
