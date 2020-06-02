@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Владельцы</h1>
            </div>
            <div class="col-sm-3 offset-lg-3">
                {{--<a href="{{ route('owner.create') }}" role="button"--}}
                   {{--class="btn btn-block btn-outline-primary btn-md">Добавить владельца</a>--}}
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Организации</h6>
            </div>
            <div class="card-body">
                <table class="table w-100">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Отчество</th>
                        <th>Номер телефона</th>
                        <th>Организация</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->employee->name}}</td>
                            <td>{{$user->employee->surname}}</td>
                            <td>{{$user->employee->patronymic}}</td>
                            <td>{{$user->employee->phone}}</td>
                            <td>{{$user->getOrganizationName()}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$users->links()}}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
