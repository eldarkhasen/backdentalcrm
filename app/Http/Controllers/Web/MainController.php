<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 22.05.2020
 * Time: 23:39
 */

namespace App\Http\Controllers\Web;


class MainController
{
    public function index()
    {
        return view('welcome');
    }
}