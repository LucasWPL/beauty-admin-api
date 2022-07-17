<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function fakeData()
    {
        $fakeData = [
            'costumers' => [
                'today' => 10,
                'inMonth' => 100,
            ],
            'jobs' => [
                'today' => 20,
                'inMonth' => 200,
            ],
            'returns' => [
                'today' => 30,
                'inMonth' => 300,
            ],
            'records' => [
                'today' => 40,
                'inMonth' => 400,
            ],
        ];

        return response()->json($fakeData, 200);
    }
}
