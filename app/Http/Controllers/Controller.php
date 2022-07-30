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
}
