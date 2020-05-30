@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Типы подписок и тарифы</h1>
            </div>
            <div class="col-sm-3 offset-lg-3">
                <a href="{{ route('subscriptiontypes.create') }}" role = "button" class = "btn btn-block btn-outline-primary btn-md"> Добавить тип подписки</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Типы подписок</h6>
            </div>
            <div class="card-body">
                    @include('components.datatable', [
                        'headers' => [
                            'id' => 'ID',
                            'name' => 'Название',
                            'price' => 'Цена (тг)',
                            'expiration_days' => 'Кол-во дней',
                            'employees_count'=>'Кол-во сотрудников',
                            'status' => 'Статус',],
                        'actions' => ['edit_form_link' => 'Редактировать'],
                        'items' => $subscriptionTypes
                    ])
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
