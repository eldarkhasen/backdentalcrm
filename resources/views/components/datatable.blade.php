<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
                @if(count($actions)>0)
                    <th>Действие</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @foreach($items as $item)
                <tr>
                    @foreach($headers as $key => $header)
                        <td>{{ $item[$key] ?? 'not defined' }}</td>
                    @endforeach
                    @if(count($actions)>0)
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Действия
                                </button>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach($actions as $key => $action)
                                            <a class="dropdown-item" href="{{ $item[$key]  }}">{{ $action ?? '' }}</a>
                                        @endforeach
                                    </div>

                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
