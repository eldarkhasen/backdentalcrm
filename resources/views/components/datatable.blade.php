<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tfoot>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </tfoot>
        <tbody>
            @foreach($data->items() as $item)
                <tr>
                    @foreach($headers as $key => $header)
                        <td>{{ $item[$key] }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
