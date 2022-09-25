<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Costumer;
use App\Models\CostumerAddress;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CostumerController extends Controller
{
    public function createCostumer(Request $request)
    {
        $costumer = new Costumer();
        $costumer->parseValuesFromRequest($request)->save();

        $this->saveCostumerAddress($costumer, $request);

        return response()->json([
            "message" => "Costumer record created"
        ], 201);
    }

    private function saveCostumerAddress(Costumer $costumer, Request $request)
    {
        $address = new Address();
        $address->parseValuesFromRequest($request)->save();

        $costumerAddress = new CostumerAddress();
        $costumerAddress->costumer_id = $costumer->id;
        $costumerAddress->address_id = $address->id;
    }

    public function getAllCostumers(Request $request)
    {
        $costumers = Costumer::get();
        if ($request->maxInPage && $request->currentPage) {
            $costumers = $this->getAllCostumersToGrid($request, $costumers);
        }

        return response()->json($costumers, 201);
    }

    private function getAllCostumersToGrid(Request $request, Collection $allRecords)
    {
        $costumers = Costumer::skip($this->toSkipFromPageNumber($request->currentPage, $request->maxInPage))
            ->take($request->maxInPage)
            ->orderBy('id', 'DESC')
            ->get();

        return [
            'filtred' => $costumers,
            'allRecords' => $allRecords,
            'pages' => $this->getNumberOfPages(count($allRecords), $request->maxInPage),
        ];
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
            $costumer->parseValuesFromRequest($request)->save();

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
