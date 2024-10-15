<?php

namespace App\Http\Controllers;

use App\Models\Historic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoricController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historic = Historic::all();

        return Inertia::render('Historic/Index', [
            'historic' => $historic,
        ]);
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
    public function show(Historic $historic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Historic $historic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Historic $historic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Historic $historic)
    {
        //
    }
}
