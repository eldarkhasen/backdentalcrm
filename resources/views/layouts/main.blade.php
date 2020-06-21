<!DOCTYPE html>
<html lang="en">

<head>
    @include('parts.head')
    @include('parts.styles')
    @yield('styles')
</head>
<body id="page-top">
<div id="wrapper">
    @include('parts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('parts.flash')
            @include('parts.topbar')
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="post" action="{{route('logout')}}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Готовы выйти?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Вы точно хотите выйти?.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary">Выйти</button>
            </div>
        </form>
    </div>
</div>
@include('parts.scripts')
@yield('scripts')
@yield('masks')
</body>
</html>


