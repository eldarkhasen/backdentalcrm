<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\InitialInspectionTypeResource;
use App\Models\Business\InitInspectionType;
use Illuminate\Http\Request;

class InitialInspectionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = InitialInspectionTypeResource::collection(
            InitInspectionType::get()
        )->resolve();
        return view('web.initialInspectionTypes.index',compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        InitInspectionType::create($request->all());
        return redirect()->route('initialInspectionTypes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = InitInspectionType::findOrFail($id);
        return view('web.initialInspectionTypes.show',compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $initialInspectionType = InitInspectionType::findOrFail($id);
        return view('web.initialInspectionTypes.edit',compact('initialInspectionType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inspectionType = InitInspectionType::findOrFail($id);
        $inspectionType->update($request->all());
        return redirect()->route('initialInspectionTypes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        InitInspectionType::destroy($id);
        return redirect()->route('initialInspectionTypes.index');
    }
}
