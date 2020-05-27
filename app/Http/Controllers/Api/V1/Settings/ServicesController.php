<?php

namespace App\Http\Controllers\Api\V1\Settings;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Settings\StoreAndUpdateServiceApiRequest;
use App\Http\Requests\Api\V1\Settings\StoreAndUpdateServiceCategoryApiRequest;
use App\Models\Settings\Service;
use App\Models\Settings\ServiceCategory;
use App\Services\v1\ServicesService;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class ServicesController extends ApiBaseController
{
    protected $servicesService;

    /**
     * ServicesController constructor.
     * @param $servicesService
     */
    public function __construct(ServicesService $servicesService)
    {
        $this->servicesService = $servicesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->get('perPage',10);
        if($request->has('search') && !$request->has('category_id')){
            return $this->successResponse($this->servicesService->searchServices($request->get('organization_id'),$request->get('search'),$perPage));
        }else if($request->has('category_id') && !$request->has('search')){
            return $this->successResponse($this->servicesService->getAllServicesByCategory($request->get('organization_id'),$request->get('category_id'),$perPage));
        }else if($request->has('category_id') && $request->has('search')){
            return $this->successResponse($this->servicesService->searchByCategories($request->get('organization_id'),$request->get('category_id'),$request->get('search'),$perPage));
        }else{
            return $this->successResponse($this->servicesService->getAllServices($request->get('organization_id'),$perPage));
        }

    }

    public function getServiceCategories(Request $request){
        return$this->successResponse($this->servicesService->getServiceCategories($request->get('organization_id')));
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
    public function store(StoreAndUpdateServiceApiRequest $request)
    {
        return $this->successResponse(Service::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAndUpdateServiceApiRequest $request, $id)
    {
        $service = Service::findOrFail($id);
        return $this->successResponse($service->update($request->all()));
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

//    public function getAllServicesByCategory(Request $request,$category_id){
//        $perPage = $request->get('perPage',10);
//        return $this->successResponse($this->servicesService->getAllServicesByCategory($request->get('organization_id'),$category_id,$perPage));
//
//    }

    public function searchServices(){
        $search_key = Input::only('search');
    }

    public function getServiceById($id){
        return $this->successResponse($this->servicesService->getServiceById($id));
    }

    public function storeCategory(StoreAndUpdateServiceCategoryApiRequest $request){
        return $this->successResponse(ServiceCategory::create($request->all()));

    }

    public function updateCategory($id,StoreAndUpdateServiceCategoryApiRequest $request){
        $category = ServiceCategory::findOrFail($id);
        $category->update($request->all());
        return $this->successResponse($this->servicesService->getServiceCategories());

    }

    public function deleteCategory($id){
        return $this->successResponse($this->servicesService->deleteCategory($id));
    }
    public function getServicesArray(){
        return $this->successResponse(Service::with(['category','organization'])->all());
    }
}
