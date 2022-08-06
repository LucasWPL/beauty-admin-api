<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    public function createProcedure(Request $request)
    {
        $procedure = new Procedure();
        $procedure->description = $request->description;
        $procedure->duration = $this->convertToMinsHours($request->duration);
        $procedure->value = $this->cleanCoin($request->value);
        $procedure->save();

        return response()->json([
            "message" => "Procedure record created"
        ], 201);
    }

    public function getAllProcedures(Request $request)
    {
        $procedures = Procedure::get();

        if ($request->maxInPage && $request->currentPage) {
            $procedures = $this->getAllProceduresToGrid($request, $procedures);
        }

        foreach ($procedures as $key => $procedure) {
            $procedures[$key]->value = $this->makeCoin($procedure->value);
            $procedures[$key]->duration = $this->convertToHoursMins($procedure->duration);
        }

        return response()->json($procedures, 201);
    }

    private function getAllProceduresToGrid(Request $request, Collection $allRecords)
    {
        $procedures = Procedure::skip($this->toSkipFromPageNumber($request->currentPage, $request->maxInPage))
            ->take($request->maxInPage)
            ->orderBy('id', 'DESC')
            ->get();

        return [
            'filtred' => $procedures,
            'allRecords' => $allRecords,
            'pages' => $this->getNumberOfPages(count($allRecords), $request->maxInPage),
        ];
    }

    public function getProcedure($id)
    {
        if (Procedure::where('id', $id)->exists()) {
            $procedure = Procedure::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($procedure, 200);
        } else {
            return response()->json([
                "message" => "Procedure not found"
            ], 404);
        }
    }

    public function updateProcedure(Request $request, $id)
    {
        // @todo
        return;

        if (Procedure::where('id', $id)->exists()) {
            $procedure = Procedure::find($id);
            $procedure->time = $request->time ?? $procedure->time;
            $procedure->costumer_id = $request->costumer_id ?? $procedure->costumer_id;
            $procedure->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Procedure not found"
            ], 404);
        }
    }

    public function deleteProcedure($id)
    {
        if (Procedure::where('id', $id)->exists()) {
            $procedure = Procedure::find($id);
            $procedure->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Procedure not found"
            ], 404);
        }
    }
}
