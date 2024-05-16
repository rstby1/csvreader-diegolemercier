<html>

<head>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>

<body class="body-wrapper">
    <div class="app-container search-customer">

        <form action="{{ route('searchCustomer') }}" method="post">
            @csrf
            <div class="credentials">
                <!-- An unexamined life is not worth living. - Socrates -->
                <label for="cuit">Enter customer CUIT</label>
                <br><!-- comment -->
                <input type="text" name="cuit" id="cuit" autocomplete="off" required>

            </div>
            <div class="file-container">
                <input type="submit" class="btn-submit btn" value="Submit" name="submit">
                <a class="btn" href="{{ url('/') }}">Back</a>
            </div>
        </form>
    </div>
    </div>
</body>

</html>