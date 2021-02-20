<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/js/app.js" defer></script>
    {{-- tabler --}}
    <link href="/tabler/dist/css/tabler.css" rel="stylesheet" />
    <link href="/tabler/dist/css/tabler-flags.min.css" rel="stylesheet" />
    <link href="/tabler/dist/css/tabler-payments.min.css" rel="stylesheet" />
    <link href="/tabler/dist/css/tabler-vendors.min.css" rel="stylesheet" />
    <link href="/tabler/dist/css/demo.min.css" rel="stylesheet" />
    {{-- tabler end --}}
    <link rel="stylesheet" href="/css/app.css">
    <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet">
{{--    <script>--}}
{{--        window.user = @json(Auth::user()??[],JSON_FORCE_OBJECT);--}}
{{--    </script>--}}
</head>

<body>
    <div id="app"></div>
    {{-- tabler --}}
    <script src="/tabler/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/tabler/dist/js/tabler.min.js"></script>
    {{-- tabler end--}}
</body>

</html>
