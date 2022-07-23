<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use App\Models\Job;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function cardsData()
    {

        $costumersToday = Job::whereDate('time', Carbon::today())->groupBy('costumer_id')->get()->count();
        $costumersInMonth = Job::whereMonth('time', date('m'))
            ->whereYear('time', date('Y'))
            ->groupBy('costumer_id')
            ->get()
            ->count();

        $jobsToday = Job::whereDate('time', Carbon::today())->get()->count();
        $jobsInMonth = Job::whereMonth('time', date('m'))
            ->whereYear('time', date('Y'))
            ->get()
            ->count();

        $allCostumers = Costumer::get()->count();
        $costumersRecordsInMonth = Costumer::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get()
            ->count();

        $cardsData = [
            'costumers' => [
                'today' => $costumersToday,
                'inMonth' => $costumersInMonth,
            ],
            'jobs' => [
                'today' => $jobsToday,
                'inMonth' => $jobsInMonth,
            ],
            'returns' => [
                'today' => 0,
                'inMonth' => 0,
            ],
            'records' => [
                'today' => $allCostumers,
                'inMonth' => $costumersRecordsInMonth,
            ],
        ];

        return response()->json($cardsData, 200);
    }
}
