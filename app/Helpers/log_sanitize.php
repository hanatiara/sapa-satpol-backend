<?php

if (!function_exists('safe_log')) {
    /**
     * Logs only printable characters, removing binary junk.
     *
     * @param string|array|object $data
     * @param string $level log level (error, info, warning, etc.)
     */
    function safe_log($data, $level = 'error')
    {
        // Convert non-string to JSON
        if (!is_string($data)) {
            $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        // Remove control characters except newline & tab
        $clean = preg_replace('/[^\P{C}\n\t]+/u', '', $data);

        // Write to log
        \Log::$level($clean);
    }
}
