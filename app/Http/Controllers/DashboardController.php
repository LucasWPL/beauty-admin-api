<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function allData()
    {
        $allData = [
            'cards' => $this->cardsData(),
            'procedures_today' => $this->proceduresToday()
        ];

        return response()->json($allData, 200);
    }

    private function proceduresToday()
    {
        return Job::leftJoin('job_procedures', 'jobs.id', '=', 'job_procedures.job_id')
            ->join('costumers', 'jobs.costumer_id', '=', 'costumers.id')
            ->select('jobs.*', 'costumers.name', 'costumers.phone')
            ->selectRaw('GROUP_CONCAT(job_procedures.description) as procedures_list')
            ->selectRaw('SUM(job_procedures.value) as procedures_value')
            ->whereDate('time', Carbon::today())
            ->where('status', Job::STATUS_PENDENTE)
            ->groupBy('jobs.id')
            ->orderBy('time')
            ->get();
    }

    private function cardsData()
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

        return $cardsData;
    }
}
