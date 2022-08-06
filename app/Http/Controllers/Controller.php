<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getNumberOfPages(int $total, int $max): int
    {
        $pages = intval($total / $max) + 1;
        if ($total % $max == 0) {
            $pages--;
        }

        return $pages;
    }

    protected function toSkipFromPageNumber(int $currentPage, int $maxInPage): int
    {
        return ($maxInPage * $currentPage) - $maxInPage;
    }

    protected function makeCoin(string $value): string
    {
        return number_format($value, 2, ',', '.');;
    }

    protected function cleanCoin(string $value): float
    {
        $source = array('.', ',');
        $replace = array('', '.');
        $value = str_replace($source, $replace, $value);

        return (float) $value;
    }

    protected function convertToHoursMins(string|int $time, string $format = '%02d:%02d'): string
    {
        if ($time < 1) {
            return sprintf($format, '00', '00');;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);

        return sprintf($format, $hours, $minutes);
    }

    protected function convertToMinsHours(string $time): int
    {
        $hoursInMinutes = 0;
        $minutes = intval($time);

        if (str_contains($time, ':')) {
            $time = explode(':', $time);
            $hoursInMinutes = intval($time[0]) * 60;
            $minutes = intval($time[1]);
        }

        return $hoursInMinutes + $minutes;
    }
}
