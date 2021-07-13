<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WEB BLOG | @yield('title')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>

    @include('layouts.navbar')

    <div class="container">
        @yield('content')
    </div>

    @section('page-script')
        <script src="{{ mix('js/app.js') }}"></script>
        <script type="text/javascript">
            window.addEventListener('DOMContentLoaded', (event) => {
                tinymce.init({
                    selector: 'textarea#frm-content',
                    content_css: false,
                    skin: false
                });
            });
        </script>
    @show
    
</body>
</html>