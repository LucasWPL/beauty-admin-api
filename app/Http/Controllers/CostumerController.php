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
            "message" => "costumer record created"
        ], 201);
    }
}
