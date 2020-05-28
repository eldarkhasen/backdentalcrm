{{--//@todo: Исправить баг с отображением объектов, которые должны выходить через relationsShips. Также продумать как переходить на Edit здесь--}}
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
                <th>Действие</th>
            </tr>
        </thead>
        {{--<tfoot>--}}
            {{--<tr>--}}
                {{--@foreach($headers as $header)--}}
                    {{--<th>{{ $header }}</th>--}}
                {{--@endforeach--}}
            {{--</tr>--}}
        {{--</tfoot>--}}
        <tbody>
            @foreach($data->items() as $item)
                <tr>
                    @foreach($headers as $key => $header)
                        <td>{{ $item[$key] }}</td>
                    @endforeach
                    <td>
                        <a href="#" class="btn btn-outline-primary btn-sm">Редактировать</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
