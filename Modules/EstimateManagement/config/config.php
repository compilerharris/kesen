<?php

return [
    'name' => 'EstimateManagement',
    /**
     * Minimum monetary total (same currency as line items) for Translation and Back Translation lines
     * after natural rate-card calculation. Set via ESTIMATE_MIN_LINE_TOTAL (default 500).
     * Falls back to ESTIMATE_BT_MIN_WORD_FLOOR for backward compatibility when ESTIMATE_MIN_LINE_TOTAL is unset.
     */
    'min_line_total' => (float) env('ESTIMATE_MIN_LINE_TOTAL', env('ESTIMATE_BT_MIN_WORD_FLOOR', 500)),
];
