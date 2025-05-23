<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title", "E-Com")</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset("assets/css/bootstrap.min.css") }}" rel="stylesheet">
    @yield("style")
</head>
<body>
    @include("includes.hader")
    @yield("content")
    @include("includes.footer")
    <script src="{{ asset("assets/js/bootstrap.min.js") }}"></script>
    @yield('script');
</body>
</html>