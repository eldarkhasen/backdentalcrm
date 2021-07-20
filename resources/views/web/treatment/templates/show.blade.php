@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Шаблоны протоколов : {{$template->name}}</h1>
            </div>
            <div class="row" style="clear: both;">
                <div class="col-12 text-right">
                    <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"  onclick="add()"><i class="fas fa-plus-square"></i> Добавить вопрос</a>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="template_type" width="100%">
            <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="35%">Название</th>
{{--                <th width="30%">Код</th>--}}
                <th width="15%"></th>
{{--                <th width="15%"></th>--}}
            </tr>
            </thead>
        </table>
    </div>
    <div class="modal fade" id="addNewTemplate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Новый вопрос</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="type_id" id="type_id">
                        <div class="form-group">
                            <label for="inputName">Наименование</label>
                            <input type="text"
                                   class="form-control"
                                   id="inputName"
                                   placeholder="Введите название"
                                   name = "inputName">
                        </div>
                        <div class="form-group" id="form-errors">
                            <div class="alert alert-danger">
                                <ul>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary" onclick="save()">Сохранить</button>
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
        function add() {
            $('#form-errors').html("");
            $('#staticBackdropLabel').text("Новый вопрос");
            $("#type_id").val('');
            $("#inputName").val('');
            $('#addNewTemplate').modal('show');
        }

        function editType (event) {
            $('#form-errors').html("");
            var id  = $(event).data("id");
            let _url = `/treatment/types/${id}/edit`;
            $.ajax({
                url: _url,
                type: "GET",
                success: function(response) {
                    if(response) {
                        console.log(response);
                        $('#staticBackdropLabel').text("Редактировать вопрос");
                        $("#type_id").val(response.id);
                        $("#inputName").val(response.name);
                        $('#addNewTemplate').modal('show');
                    }
                }
            });
        }

        function save() {
            var name = $('#inputName').val();
            var id = $('#type_id').val();
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('treatment.types.store') }}",
                type: "POST",
                data: {
                    id: id,
                    name: name,
                    template_id: '{{$template->id}}',
                    _token: _token
                },
                success: function(response) {
                    if(response.code == 200) {
                        $('#name').val('');
                        $('#code').val('');
                        $('#template_type').DataTable().ajax.reload();
                        $('#addNewTemplate').modal('hide');
                    } else{
                        var errors = response.errors;
                        errorsHtml = '<div class="alert alert-danger"><ul>';

                        $.each( errors, function( key, value ) {
                            errorsHtml += '<li>'+ value + '</li>'; //showing only the first error.
                        });
                        errorsHtml += '</ul></div>';

                        $( '#form-errors' ).html( errorsHtml ); //appending to a <div id="form-errors"></div> inside form

                    }
                },
                error: function(response) {
                    $('#nameError').text(response.responseJSON.errors.name);
                }
            });
        }

        $(document).ready(function() {

            $('#template_type').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('treatment.templates.show' , $template->id) }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    // {
                    //     data: 'code',
                    //     name: 'code'
                    // },
                    {
                        data: 'edit',
                        name: 'edit',
                        orderable: false
                    },
                    // {
                    //     data: 'more',
                    //     name: 'more',
                    //     orderable: false
                    // },
                ]
            });
        });
    </script>
@endsection
