<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use App\Models\Job;
use App\Models\JobProcedures;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function createJob(Request $request)
    {
        $request->validate([
            'procedureList' => 'required',
        ]);

        if ($request->pre_registration == "true") {
            $costumer = new Costumer();
            $costumer->name = $request->costumer_name;
            $costumer->phone = $request->costumer_phone;
            $costumer->save();

            $request->costumer_id = $costumer->id;
        }

        $job = new Job();
        $job->time = $request->time;
        $job->costumer_id = $request->costumer_id;
        $job->save();

        foreach ($request->procedureList as $procedureValue) {
            $procedure = new JobProcedures();

            $procedure->job_id = $job->id;
            $procedure->procedure_id = $procedureValue['procedure_id'];

            $procedure->description = $procedureValue['description'];
            $procedure->dificulty = $procedureValue['dificulty'];
            $procedure->duration = $this->convertToMinsHours($procedureValue['duration']);
            $procedure->value = $this->cleanCoin($procedureValue['value']);

            $procedure->save();
        }

        return response()->json([
            "message" => "Job record created"
        ], 201);
    }

    public function getAllJobs(Request $request)
    {
        $jobs = Job::join('costumers', 'jobs.costumer_id', '=', 'costumers.id')
            ->select('jobs.*', 'costumers.name', 'costumers.phone')
            ->get();

        if ($request->maxInPage && $request->currentPage) {
            $jobs = $this->getAllJobsToGrid($request, $jobs);
        }

        return response()->json($jobs, 201);
    }

    private function getAllJobsToGrid(Request $request, Collection $allRecords)
    {
        $jobs = Job::skip($this->toSkipFromPageNumber($request->currentPage, $request->maxInPage))
            ->take($request->maxInPage)
            ->join('costumers', 'jobs.costumer_id', '=', 'costumers.id')
            ->leftJoin('job_procedures', 'jobs.id', '=', 'job_procedures.job_id')
            ->select('jobs.*', 'costumers.name', 'costumers.phone')
            ->selectRaw('GROUP_CONCAT(job_procedures.description) as procedures_list')
            ->selectRaw('SUM(job_procedures.duration) as duration')
            ->orderBy('jobs.id', 'DESC')
            ->orderBy('status', 'DESC')
            ->groupBy('jobs.id')
            ->get();

        return [
            'filtred' => $jobs,
            'allRecords' => $allRecords,
            'pages' => $this->getNumberOfPages(count($allRecords), $request->maxInPage),
        ];
    }

    public function getJob($id)
    {
        if (Job::where('id', $id)->exists()) {
            $job = Job::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($job, 200);
        } else {
            return response()->json([
                "message" => "Job not found"
            ], 404);
        }
    }

    public function finishJob(Request $request, $id)
    {
        if (Job::where('id', $id)->exists()) {
            $job = Job::find($id);
            $job->status = Job::STATUS_FINALIZADO;
            $job->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Job not found"
            ], 404);
        }
    }

    // public function updateJob(Request $request, $id)
    // {
    //     if (Job::where('id', $id)->exists()) {
    //         $job = Job::find($id);
    //         $job->time = $request->time ?? $job->time;
    //         $job->costumer_id = $request->costumer_id ?? $job->costumer_id;
    //         $job->save();

    //         return response()->json([
    //             "message" => "records updated successfully"
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             "message" => "Job not found"
    //         ], 404);
    //     }
    // }

    public function deleteJob($id)
    {
        if (Job::where('id', $id)->exists()) {
            $job = Job::find($id);
            $job->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Job not found"
            ], 404);
        }
    }
}
