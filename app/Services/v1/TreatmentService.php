<?php


namespace App\Services\v1;


use Illuminate\Http\Request;

interface TreatmentService
{
    public function store(Request $request);
}
