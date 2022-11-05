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
        $procedure->dificulty = $request->dificulty;
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
        if (Procedure::where('id', $id)->exists()) {
            $procedure = Procedure::find($id);

            $procedure->description = $request->description ?? $procedure->description;
            $procedure->dificulty = $request->dificulty ?? $procedure->dificulty;
            $procedure->duration = $this->convertToMinsHours($request->duration) ?? $procedure->duration;
            $procedure->value = $this->cleanCoin($request->value) ?? $procedure->value;

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
