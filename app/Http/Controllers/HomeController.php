<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $chartLabels = Booking::select(DB::raw('DATE(date) as date'))
                          ->groupBy('date')
                          ->orderBy('date', 'asc')
                          ->pluck('date');

        $chartData = Booking::select(DB::raw('COUNT(*) as count'))
                        ->groupBy('date')
                        ->orderBy('date', 'asc')
                        ->pluck('count');

        $chartLabels = $chartLabels->map(function($date) {
            return Carbon::parse($date)->format('d-m-Y');
        });

        $recentBookings = Booking::with(['vehicle', 'driver'])->orderBy('created_at', 'desc')->take(10)->get();

        return view('dashboard', compact('chartLabels', 'chartData', 'recentBookings'));
    }

    
}
