@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-900">Новый тип подписки</h1>
    </div>
    <div class="container-fluid">
        <div class="card shadow mb-4 text-gray-900">
            <div class="card-body">
                <form method = "POST" action = "{{ URL::to('subscriptiontypes') }}" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="inputName">Наименование</label>
                                <input type="text"
                                       class="form-control"
                                       id="inputName"
                                       name = "name"
                                       placeholder="Введите название типа подписки">

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="inputPrice">Цена</label>
                                <input type="number"
                                       class="form-control"
                                       id="inputPrice"
                                       placeholder="Введите цену подписки"
                                       name = "price">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="inputDays">Количество дней</label>
                                <input type="number"
                                       class="form-control"
                                       id="inputDays"
                                       placeholder="Введите Количество дней"
                                       name = "expiration_days">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="inputEmp">Количество сотрудников</label>
                                <input type="number"
                                       class="form-control"
                                       id="inputEmp"
                                       placeholder="Введите количество сотрудников"
                                       name = "employees_count">
                            </div>
                        </div>
                    </div>


                    <hr>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
