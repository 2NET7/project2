<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Print')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #fff !important; color: #000; }
        .card, .table { box-shadow: none !important; }
        @media print {
            .btn, .no-print { display: none !important; }
            body { background: #fff !important; color: #000; }
        }
    </style>
</head>
<body>
    @yield('content')
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
