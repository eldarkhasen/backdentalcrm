@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Тип первичного осмотра: {{$item->name}}</h1>
            </div>
            <div class="col-sm-3 offset-lg-3">
                <a href="" role = "button" class = "btn btn-block btn-outline-primary btn-md" data-toggle="modal" data-target="#addNewOption">Добавить новое поле</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                @include('components.datatable', [
                    'headers' => [
                        'id' => 'ID',
                        'value' => 'Название',
                      ],
                    'actions' => ['edit_form_link' => 'Редактировать'],
                    'items' => $type_options
                ])
            </div>
        </div>
    </div>
    <div class="modal fade" id="addNewOption" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Новый тип осмотра</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ URL::to('addInspectionOption') }}" >
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputName">Наименование</label>
                            <input type="text"
                                   class="form-control"
                                   id="inputName"
                                   placeholder="Введите название"
                                   name = "value">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <input type="hidden" name = "inspection_type_id" value="{{$item->id}}">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    {{--<!-- Page level custom scripts -->--}}
    {{--<script src="{{ asset('js/demo/datatables-demo.js') }}"></script>--}}
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "processing": true,
                "responsive": true,
                "language": {
                    "processing": "Подождите...",
                    "search": "Поиск:",
                    "lengthMenu": "Показать _MENU_ записей",
                    "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                    "infoEmpty": "Записи с 0 до 0 из 0 записей",
                    "infoFiltered": "(отфильтровано из _MAX_ записей)",
                    "infoPostFix": "",
                    "loadingRecords": "Загрузка записей...",
                    "zeroRecords": "Записи отсутствуют.",
                    "emptyTable": "В таблице отсутствуют данные",
                    "paginate": {
                        "first": "Первая",
                        "previous": "Предыдущая",
                        "next": "Следующая",
                        "last": "Последняя"
                    },
                    "aria": {
                        "sortAscending": ": активировать для сортировки столбца по возрастанию",
                        "sortDescending": ": активировать для сортировки столбца по убыванию"
                    }
                }
            });     //capital "D"
        });
    </script>
@endsection
