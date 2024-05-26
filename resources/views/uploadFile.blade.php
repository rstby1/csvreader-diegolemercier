<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="body-wrapper">
    <div>
        @if(isset($_GET['msg']) && isset($_GET['type']))
            <div class="alert {{$_GET['type']}}">
                {{ urldecode($_GET['msg']) }}
            </div>
        @endif
    </div>
</body>

</html>