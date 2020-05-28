@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-900">Редактировать организацию</h1>
    </div>
    <div class="container-fluid">
        <div class="card shadow mb-4 text-gray-900">
            <div class="card-body">
                <form method = "POST" action = "{{route('organizations.update',$organization->id)}}" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="inputName">Наименование</label>
                        <input type="text"
                               class="form-control"
                               id="inputName"
                               name = "name"
                               required
                               placeholder="Введите название организации"
                               value="{{$organization->name}}">
                    </div>
                    <div class="form-group">
                        <label for="inputCity">Город</label>
                        <select class="form-control" id="inputCity" name = "city_id">
                            @foreach($cities as $city)
                                <option
                                    {{ $organization->city_id == $city->id ? 'selected="selected"' : ''}}"
                                    value="{{$city->id}}">
                                    {{$city->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Адрес</label>
                        <input type="text"
                               class="form-control"
                               id="inputAddress"
                               placeholder="Введите адрес организации"
                               name = "address"
                               required
                               value="{{$organization->address}}">
                    </div>
                    <div class="form-group">
                        <label for="inputPhone">Контактный телефон</label>
                        <input type="text"
                               class="form-control"
                               id="inputPhone"
                               placeholder="Введите номер организации"
                               name = "phone"
                               required
                               value="{{$organization->phone}}">
                    </div>
{{--                    <div class="form-group">--}}
{{--                        <label for="inputEmail">Контактный email</label>--}}
{{--                        <input type="email"--}}
{{--                               class="form-control"--}}
{{--                               id="inputEmail"--}}
{{--                               placeholder="Введите email организации"--}}
{{--                               name = "email">--}}
{{--                    </div>--}}
                    <hr>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                    {{ method_field('PATCH')  }}
                </form>
                @if($organization->deleted)
                    <form method="POST"
                          action="{{route('organizations.update', $organization->id)}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="deleted" value="0">
                        {{ method_field('PATCH') }}

                        <div class="form-group float-right">
                            <input type="submit" class="btn btn-warning" value="Восстановить">
                        </div>
                    </form>
                @else
                    <form method="POST"
                          action="{{ route('organizations.destroy', [
                                                'organization' => $organization->id
                                            ]) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group float-right">
                            <input type="submit" class="btn btn-danger" value="Удалить организацию">
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
