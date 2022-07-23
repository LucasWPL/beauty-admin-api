<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use Illuminate\Http\Request;

class CostumerController extends Controller
{
    public function createCostumer(Request $request)
    {
        $costumer = new Costumer();
        $costumer->name = $request->name;
        $costumer->phone = $request->phone;
        $costumer->cpf = $request->cpf;
        $costumer->note = $request->note;
        $costumer->birth_date = $request->birth_date;
        $costumer->is_recommendation = $request->is_recommendation;

        $costumer->save();

        return response()->json([
            "message" => "Costumer record created"
        ], 201);
    }

    public function getAllCostumers(Request $request)
    {
        $costumers = Costumer::get();
        if ($request->maxInPage && $request->currentPage) {
            $allRecords = $costumers;
            $skip = ($request->maxInPage * $request->currentPage) - $request->maxInPage;
            $costumers = Costumer::skip($skip)->take($request->maxInPage)->get();

            $pages = intval(count($allRecords) / $request->maxInPage) + 1;

            $costumers = [
                'filtred' => $costumers,
                'allRecords' => $allRecords,
                'pages' => $pages,
            ];
        }

        return response()->json($costumers, 201);
    }

    public function getCostumer($id)
    {
        if (Costumer::where('id', $id)->exists()) {
            $costumer = Costumer::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($costumer, 200);
        } else {
            return response()->json([
                "message" => "Costumer not found"
            ], 404);
        }
    }

    public function updateCostumer(Request $request, $id)
    {
        if (Costumer::where('id', $id)->exists()) {
            $costumer = Costumer::find($id);
            $costumer->name = is_null($request->name) ? $costumer->name : $request->name;
            $costumer->phone = is_null($request->phone) ? $costumer->phone : $request->phone;
            $costumer->cpf = is_null($request->cpf) ? $costumer->cpf : $request->cpf;
            $costumer->note = is_null($request->note) ? $costumer->note : $request->note;
            $costumer->birth_date = is_null($request->birth_date) ? $costumer->birth_date : $request->birth_date;
            $costumer->is_recommendation = is_null($request->is_recommendation) ? $costumer->is_recommendation : $request->is_recommendation;

            $costumer->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Costumer not found"
            ], 404);
        }
    }

    public function deleteCostumer($id)
    {
        if (Costumer::where('id', $id)->exists()) {
            $costumer = Costumer::find($id);
            $costumer->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Costumer not found"
            ], 404);
        }
    }
}
