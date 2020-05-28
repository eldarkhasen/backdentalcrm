<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WebBaseController;
use App\Models\Management\SubscriptionType;
use App\Services\v1\SubscriptionLogic\SubscriptionTypeService;
use Illuminate\Http\Request;

class SubscriptionTypeController extends WebBaseController
{
    protected $subscriptionTypeService;
    /**
     * SubscriptionTypeController constructor.
     */
    public function __construct(SubscriptionTypeService $subscriptionTypeService )
    {
        $this->subscriptionTypeService = $subscriptionTypeService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptionTypes = $this->subscriptionTypeService->getSubscriptionTypes();
        return view('web.subscriptiontype.index',compact('subscriptionTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.subscriptiontype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->subscriptionTypeService->storeSubscriptionType($request);
        return redirect()->route('subscriptiontypes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subscriptiontype = SubscriptionType::findOrFail($id);
        return view('web.subscriptiontype.edit',compact('subscriptiontype'));
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
        $this->subscriptionTypeService->updateSubscriptionType($id,$request);
        return redirect()->route('subscriptiontypes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
