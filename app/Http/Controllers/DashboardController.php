<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function fakeData()
    {
        $costumer = ['teste' => true];

        return response()->json($costumer, 201);
    }
}
