<html>

<head>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>

<body class="body-wrapper">
    <div class="app-container">
        <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->
        <form action="{{ route('addCustomer') }}" method="post">
            @csrf
            <div class="credentials">
                <label for="cuit">CUITCliente</label>
                <br><!-- comment -->
                <input id="cuit" type="number" name="cuit" autocomplete="off" required>
                <br><!-- comment -->
                <label for="razonsocial">Razón Social</label>
                <br><!-- comment -->
                <input id="razonsocial" type="text" name="razonsocial" autocomplete="off" required >
                <br><!-- comment -->
                <label for="nro">Número de cliente</label>
                <br><!-- comment -->
                <input id="nro" type="number" name="nro" autocomplete="off" required>
                <br><!-- comment -->
            </div>
            <div class="file-container"> 
                <input type="submit" class="btn-submit btn" value="Submit" name="submit">
                <a class="btn" href="{{ url('/') }}">Back</a>
            </div>

        </form>
        @if(isset($_GET['msg']))
            <div class="alert alert-success">
                {{ urldecode($_GET['msg']) }}
            </div>
        @endif

    </div>
</body>

</html>