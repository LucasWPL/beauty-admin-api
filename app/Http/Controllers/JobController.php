<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function createJob(Request $request)
    {
        $job = new Job();
        $job->time = $request->time;
        $job->costumer_id = $request->costumer_id;
        $job->save();

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
            $allRecords = $jobs;
            $skip = ($request->maxInPage * $request->currentPage) - $request->maxInPage;
            $jobs = Job::skip($skip)
                ->take($request->maxInPage)
                ->join('costumers', 'jobs.costumer_id', '=', 'costumers.id')
                ->select('jobs.*', 'costumers.name', 'costumers.phone')
                ->get();

            $pages = $this->getNumberOfPages(count($allRecords), $request->maxInPage);

            $jobs = [
                'filtred' => $jobs,
                'allRecords' => $allRecords,
                'pages' => $pages,
            ];
        }

        return response()->json($jobs, 201);
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

    public function updateJob(Request $request, $id)
    {
        if (Job::where('id', $id)->exists()) {
            $job = Job::find($id);
            $job->time = is_null($request->time) ? $job->time : $request->time;
            $job->costumer_id = is_null($request->costumer_id) ? $job->costumer_id : $request->costumer_id;
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
