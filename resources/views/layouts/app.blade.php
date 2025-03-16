<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpdatedEAMS</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon CSS (e.g., Themify Icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/themify-icons/0.1.2/css/themify-icons.css" rel="stylesheet">
    <!-- Your Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    @yield('content')
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Your Custom JS -->
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>