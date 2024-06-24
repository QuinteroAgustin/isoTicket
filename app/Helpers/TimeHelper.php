<?php

namespace App\Helpers;

class TimeHelper {
    public static function formatDuration($decimalTime) {
        $hours = floor($decimalTime);
        $minutes = ($decimalTime - $hours) * 100;
        return sprintf("%02d:%02d", $hours, $minutes);
    }
}
