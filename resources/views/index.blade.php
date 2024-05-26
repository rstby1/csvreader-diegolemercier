<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CSVREADER</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
</head>

<body class="body-wrapper">
    <div class="app-container">
        <header>
            <h1 class="title-page">CSVREADER</h1>
        </header>
        <div class="file-form">
            <p class="file-selected" id="fileSelected"></p>
            <form action="{{ route('process.csv') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="file-container">
                    <label for="fileCSV" class="btn btn-file" id="labelFile">
                        Search file
                        <input type="file" name="fileCSV" id="fileCSV" required style="display: none;">
                    </label>
                    <input type="submit" class="btn-submit btn" value="Submit" name="submit">
                </div>
            </form>
            <br>
            <div class="file-container">
                <a class="btn btn-file" href="{{ url('/searchCustomer') }}">Modify customer</a>
                <a class="btn btn-file" href="{{ url('/addCustomer') }}">Remove customer</a>
            </div>
            @if(isset($_GET['msg']) && isset($_GET['type']))
                <div class="alert {{$_GET['type']}}">
                    {{ urldecode($_GET['msg']) }}
                </div>
            @endif
        </div>
        <div>
            <p id="nombreArchivo"></p>
        </div>
    </div>
    <script src="{{ asset('assets/js/script.js') }}"></script>

</body>

</html>