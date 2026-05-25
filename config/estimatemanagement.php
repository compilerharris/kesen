<?php

/**
 * Estimate module settings (loaded from the app config path so they are included in
 * `php artisan config:cache` and stay consistent on every machine after git pull).
 *
 * @see Modules\EstimateManagement\config\config.php (module merge; this file wins on duplicate keys)
 *
 * NOTE: After pulling this repo, run `php artisan migrate` to apply pending estimate_details
 * migrations (bt_flat_minimum, entered_unit columns) before using estimate management.
 */
return [
    'name' => 'EstimateManagement',

    /**
     * Minimum monetary total (same currency as line items) for Translation and Back Translation lines
     * after natural rate-card calculation. Set via ESTIMATE_MIN_LINE_TOTAL (default 500).
     * Falls back to ESTIMATE_BT_MIN_WORD_FLOOR for backward compatibility when ESTIMATE_MIN_LINE_TOTAL is unset.
     */
    'min_line_total' => (float) env('ESTIMATE_MIN_LINE_TOTAL', env('ESTIMATE_BT_MIN_WORD_FLOOR', 500)),
];
