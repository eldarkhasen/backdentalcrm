<?php


namespace App\Services\v1;


use Illuminate\Http\Request;

interface TreatmentTemplatesService
{
    public function store(Request $request);
}
