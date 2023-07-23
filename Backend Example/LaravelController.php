<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Something;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class SomethingChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $showSomethingChartFromDate = $request->showSomethingChartFromDate ?? now()->subDays(31)->startOfDay()->toISOString();
        $showSomethingChartToDate = $request->showSomethingChartToDate ?? now()->startOfDay()->toISOString();

        $somethingChartDatesWithinRange = CarbonPeriod::create($showSomethingChartFromDate, $showSomethingChartToDate)->toArray();
        $somethingChartDatesWithinRange = array_map(function ($date) {
            return $date->format('Y-m-d');
        }, $somethingChartDatesWithinRange);

        $somethingCountDateByDateWithinDateRange = [];
        foreach ($somethingChartDatesWithinRange as $date) {
            $somethingCountDateByDateWithinDateRange[] = [
                'date' => $date->format('Y-m-d'),
                'count' => Something::withTrashed()->whereBetween('created_at', [$date->toISOString(), $date->copy()->addDay()->subSecond()->toISOString()])->count()
            ];
        }

        $somethingDeletedCountDateByDateWithinDateRange = [];
        foreach ($somethingChartDatesWithinRange as $date) {
            $somethingDeletedCountDateByDateWithinDateRange[] = [
                'date' => $date->format('Y-m-d'),
                'count' => Something::onlyTrashed()->whereBetween('deleted_at', [$date->toISOString(), $date->copy()->addDay()->subSecond()->toISOString()])->count()
            ];
        }

        return [
            'showSomethingChartFromDate' => $showSomethingChartFromDate,
            'showSomethingChartToDate' => $showSomethingChartToDate,
            'somethingChartDatesWithinRange' => $somethingChartDatesWithinRange,
            'somethingCountDateByDateWithinDateRange' => $somethingCountDateByDateWithinDateRange,
            'somethingDeletedCountDateByDateWithinDateRange' => $somethingDeletedCountDateByDateWithinDateRange,
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
