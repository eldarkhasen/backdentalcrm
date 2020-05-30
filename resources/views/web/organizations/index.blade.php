@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Организации</h1>
            </div>
            <div class="col-sm-3 offset-lg-3">
                <a href="{{ route('organizations.create') }}" role = "button" class = "btn btn-block btn-outline-primary btn-md"> Добавить организацию</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Организации</h6>
            </div>
            <div class="card-body">
                @include('components.datatable', [
                    'headers' => [
                        'id' => 'ID',
                        'name' => 'Название',
                        'city_name' => 'Город',
                        'address' => 'Адрес',
                        'status' => 'Статус',
                        'email' => 'Email'
                    ],
                    'actions' => ['show_item_link'=>'Профиль','edit_form_link' => 'Редактировать'],
                    'items' => $organizations
                ])
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
