@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="h3 mb-2 text-gray-900">Организация: {{$organization->name}}</h1>
                <h1 class="h5 mb-2 text-gray-800">Город: {{$organization->city->name}}</h1>
                <h1 class="h5 mb-2 text-gray-800">Адресс: {{$organization->address}}</h1>
                <h1 class="h5 mb-2 text-gray-800">Контактный телефон: {{$organization->phone}}</h1>
                <h1 class="h5 mb-2 text-gray-800">Контактный email: {{$organization->email}}</h1>
                <h1 class="h5 mb-2 text-gray-800">
                    Дата окончания подписки: {{ isset($organization->currentSubscription)
                        ? $organization->resolve()['currentSubscription']->resolve()['end_date']
                        : ""
                    }}
                </h1>
            </div>
            <div class="col-sm-3 offset-lg-3">
                <a href="#" role = "button" class = "btn btn-block btn-outline-primary btn-md mb-3" data-toggle="modal" data-target="#addSubscription">
                    Продлить подписку
                </a>
                <a href="#" role = "button" class = "btn btn-block btn-outline-info btn-md" data-toggle="modal" data-target="#addEmployee">
                    Добавить пользователя
                </a>
            </div>
        </div>
    </div>
    <hr>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Текущая подписка</div>
                                <div class="h5 mb-1 font-weight-bold text-gray-800">
                                    {{ $organization->currentSubscription->subscriptionType->name ?? "Отсутствует" }}
                                </div>
                                <div class="h6 mb-1 font-weight-bold text-gray-800">
                                    {{ $organization->resolve()['currentSubscription']->resolve()['subscriptionType']->resolve()['description'] ?? ''}}
                                </div>
                                <div class="h6 mb-1 font-weight-bold text-gray-800">
                                    @if(isset($organization->currentSubscription->subscriptionType))
                                        {{ "До " . $organization->currentSubscription->subscriptionType->employees_count . " врачей"}}
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-2">Ежемесячный платеж</div>
                                <div class="h5 mb-2 font-weight-bold text-gray-800">{{$organization->currentSubscription->actual_price ?? 0}}тг</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-2">Осталось дней</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$diff_in_days}}</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{$percentage}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">Общая выручка</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$sum}}тг</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
               <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="subscriptions-tab" data-toggle="pill" href="#subscriptions" role="tab" aria-controls="subscriptions" aria-selected="true">Список подписок</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="employees-tab" data-toggle="pill" href="#employees" role="tab" aria-controls="employees" aria-selected="false">Пользователи</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="subscriptions" role="tabpanel" aria-labelledby="subscriptions-tab">
                                @include('components.datatable', [
                                        'headers' => [
                                            'id' => 'ID',
                                            'subscriptionTypeName' => 'Название',
                                            'actual_price' => 'Цена',
                                            'start_date' => 'Дата старта',
                                            'end_date' => 'Дата окончания',
                                        ],
                                        'actions' => [],
                                        'items' => $organization->resolve()['subscriptions']->map(function ($item) {
                                            return $item->resolve();
                                        })
                                    ])
                            </div>
                            <div class="tab-pane fade" id="employees" role="tabpanel" aria-labelledby="employees-tab">
                                @include('components.datatable', [
                                     'headers' => [
                                         'id' => 'ID',
                                         'surname' => 'Фамилия',
                                         'name' => 'Имя',
                                         'email'=> 'Email',
                                         'role_id'=>'Роль'
                                     ],
                                     'actions' => [],
                                     'items' => $organization->resolve()['employees']->map(function ($item) {
                                            return $item->resolve();
                                        })
                                 ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addSubscription" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Продлить подписку</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ URL::to('addSubscription') }}" >
                    @csrf
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="inputSubscription">Подписка</label>
                                <select class="form-control" id="inputSubscription" name = "subscription_type_id">
                                    <option value="">Укажите подписку</option>
                                    @foreach($subscriptionTypes as $subscription)
                                        <option
                                                {{ isset($organization->currentSubscription->subscriptionType)
                                                    && $subscription->id == $organization->currentSubscription->subscription_type_id
                                                        ? 'selected="selected"' : ''
                                                }}
                                                value="{{$subscription->id}}">
                                            {{$subscription->name . ", " . $subscription->price
                                                . "тг., " . $subscription->expiration_days . " дней, "
                                                . $subscription->employees_count . " чел." }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Фактическая цена</label>
                                <input type="number"
                                       class="form-control"
                                       id="inputActualPrice"
                                       placeholder="Введите фактическую цену подписки"
                                       name = "actual_price"
                                       value="{{$organization->currentSubscription->actual_price ?? ""}}">


                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <input type="hidden" name = "organization_id" value="{{$organization->id}}">
                        <button type="submit" class="btn btn-primary">Продлить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id = "addEmployee">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить пользователя</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ URL::to('addEmployee') }}" >
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputEmail">Фамилия</label>
                                    <input type="text"
                                           class="form-control"
                                           placeholder="Введите фамилию"
                                           name = "surname">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputEmail">Имя</label>
                                    <input type="text"
                                           class="form-control"
                                           placeholder="Введите имя"
                                           name = "name">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputEmail">Отчество</label>
                                    <input type="text"
                                           class="form-control"
                                           placeholder="Введите отчество"
                                           name = "patronymic">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputEmail">Дата рождения</label>
                                    <input type="date"
                                           id = "birth_date"
                                           class="form-control"
                                           name = "birth_date"
                                           >
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Пол</label>
                                    <select
                                            class="form-control"
                                            name = "gender">
                                        <option value = "Не указано">Не указано</option>
                                        <option value = "Мужской" >Мужской</option>
                                        <option value = "Женский">Женский</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputEmail">Телефон</label>
                                    <input type="text"
                                           class="form-control"
                                           id="phone"
                                           name = "phone">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-2">
                            <div class="col-4">
                                <label>Роль</label>
                                <select class="form-control"
                                        name = "role_id">
                                    @foreach($roles as $role)
                                        <option value = "{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <label>Email</label>
                                <input type="email"
                                       class="form-control"
                                       placeholder="Введите email"
                                       name = "email">

                            </div>
                            <div class="col-4">
                                <label>Пароль</label>
                                <input type="password"
                                       class="form-control"
                                       placeholder="Введите пароль"
                                       name = "password">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <input type="hidden" name = "organization_id" value="{{$organization->id}}">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $('#birth_date').mask('99/99/9999',{placeholder:"ДД/ММ/ГГГГ"});
        $('#phone').mask("+7(999)999-99-99",{placeholder:"+7(___)___-__-__"});
    </script>
@endsection
