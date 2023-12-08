<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index() {
        $date = Carbon::now();
        return view('DashboardView', [
            "heading" => "Dashboard",
            "currMonth" => $date->format("F"),
            "currYear" => $date->format("Y"),
            "data" => [
                "Jan" => 10,
                "Feb" => 15,
                "Mar" => 12,
                "Apr" => 20,
                "Mei" => 30,
            ]
        ]);
    }
}
