@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-900">Редактировать тип первичного осмотра</h1>
    </div>
    <div class="container-fluid">
        <div class="card shadow mb-4 text-gray-900">
            <div class="card-body">
                <form method = "POST" action = "{{route('initialInspectionTypes.update',$initialInspectionType->id)}}" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="inputName">Наименование</label>
                                <input type="text"
                                       class="form-control"
                                       id="inputName"
                                       name = "name"
                                       placeholder="Введите название типа"
                                       value="{{$initialInspectionType->name}}">

                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Сохранить</button>

                        {{--@if($subscriptiontype->deleted)--}}
                            {{--<a href="" onclick="event.preventDefault();--}}
                                    {{--document.getElementById('recover_subcr_type').submit();" class="btn btn-warning">Восстановить</a>--}}
                        {{--@else--}}
                            <a href="" onclick="event.preventDefault();
                                    document.getElementById('delete_inspection_type').submit();" class="btn btn-danger">Удалить</a>


                    </div>

                    {{ method_field('PATCH')  }}
                </form>

                <form method="POST"
                      id = "recover_inspection_type"
                      action="{{route('initialInspectionTypes.update', $initialInspectionType->id)}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="deleted" value="0">
                    {{ method_field('PATCH') }}

                </form>

                <form method="POST"
                      id = "delete_inspection_type"
                      action="{{ route('initialInspectionTypes.destroy', [
                                                'initialInspectionType' => $initialInspectionType->id
                                            ]) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                </form>
            </div>
        </div>
    </div>
@endsection
