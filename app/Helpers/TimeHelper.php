<?php

namespace App\Helpers;

class TimeHelper {

    /**
     * Convertit une durée sous forme décimale (ex. 2.50) en format hh:mm.
     * 2.50 affiche 02:50
     * TimeHelper::formatDuration(2.50);
     * @param float $decimalTime
     * @return string
     */
    public static function formatDuration($decimalTime) {
        $hours = floor($decimalTime);
        $minutes = ($decimalTime - $hours) * 100;
        return sprintf("%02d:%02d", $hours, $minutes);
    }

    /**
     * Convertit une durée HH.MM en minutes totales.
     * // 2.30 Renvoie 150 minutes
     * TimeHelper::convertDureeToMinutes('2.30');
     * @param string $duree
     * @return int
     */
    public static function convertDureeToMinutes($duree) {
        list($hours, $minutes) = explode('.', $duree);
        $totalMinutes = ((int) $hours * 60) + (int) $minutes; // Convertir en entiers avant de faire l'addition
        return $totalMinutes;
    }

    /**
     * Convertit un nombre de minutes en heures et minutes au format h.mm.
     * TimeHelper::convertMinutesToDuration('150'); e, 2.30
     * @param int $totalMinutes
     * @return string
     */
    public static function convertMinutesToDuration($totalMinutes) {
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        return sprintf("%d.%02d", $hours, $minutes);
    }
}
