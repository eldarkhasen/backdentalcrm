<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 22.05.2020
 * Time: 23:44
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\WebBaseController;
use App\Http\Requests\Web\ConfigWebRequest;
use Illuminate\Support\Facades\Artisan;

class ConfigController extends WebBaseController
{
    public function configure(ConfigWebRequest $request)
    {
        if ($request->get('token') == 'kasya') {
            return Artisan::call($request->get('command'));
        }
        return "fail";
    }

    public function apiDoc(){
        return view('apidoc.index');
    }
}