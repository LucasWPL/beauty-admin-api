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
        $costumer->save();

        return response()->json([
            "message" => "Costumer record created"
        ], 201);
    }

    public function getAllCostumers()
    {
        $costumers = Costumer::get()->toJson(JSON_PRETTY_PRINT);
        return response($costumers, 200);
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
