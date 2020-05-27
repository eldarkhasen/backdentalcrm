<!DOCTYPE html>
<html lang="en">

<head>
    @include('parts.head')
    @include('parts.styles')
    @yield('styles')
</head>
<body class="bg-gradient-primary">
@yield('content')
@include('parts.scripts')
@yield('scripts')
</body>
</html>
