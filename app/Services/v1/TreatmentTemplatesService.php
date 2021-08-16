<?php


namespace App\Services\v1;


use Illuminate\Http\Request;

interface TreatmentTemplatesService
{
    public function store(Request $request);

    public function storeType(Request $request);

    public function storeOption(Request $request);
}
