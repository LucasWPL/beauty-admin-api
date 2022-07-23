<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function cardsData()
    {
        $allCostumers = Costumer::get()->count();
        $costumersRecordsInMonth = Costumer::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get()
            ->count();

        $cardsData = [
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
                'today' => $allCostumers,
                'inMonth' => $costumersRecordsInMonth,
            ],
        ];

        return response()->json($cardsData, 200);
    }
}
