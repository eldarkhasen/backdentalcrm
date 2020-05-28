<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 22.05.2020
 * Time: 23:38
 */

namespace App\Http\Controllers;


use App\Core\Interfaces\WithUser;

class WebBaseController extends Controller implements WithUser
{
    public function warning()
    {
        request()
            ->session()
            ->flash('warning', 'Ошибка!');

    }

    public function added()
    {
        request()
            ->session()
            ->flash('warning', 'Добавлено!');
    }

    public function inModeration()
    {
        request()
            ->session()
            ->flash('warning', "Отправлено на мoдерацию администратору сайта");
    }

    public function deleted()
    {
        request()
            ->session()
            ->flash('warning', 'Удалено!');
    }

    public function successOperation()
    {
        request()
            ->session()
            ->flash('success', 'Операция успешна!');
    }

    public function edited()
    {
        request()
            ->session()
            ->flash('success', 'Обновлено!');
    }

    public function notFound()
    {
        request()
            ->session()
            ->flash('warning', 'Не найдено!');
    }


    public function error()
    {
        request()
            ->session()
            ->flash('error', 'Ошибка!');
    }

    public function makeToast($type, $message)
    {
        request()
            ->session()
            ->flash($type, $message);
    }

    public function getCurrentUser()
    {
        return auth()->user();
    }

    public function getCurrentUserId()
    {
        return auth()->id();
    }
}
