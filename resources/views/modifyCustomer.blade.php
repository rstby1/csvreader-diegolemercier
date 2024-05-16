<!DOCTYPE html>
<html>

<head>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>

<body class="body-wrapper">
    <div class="app-container search-customer">
        <!-- It is never too late to be what you might have been. - George Eliot -->

        <form action="{{ url('modifyCustomer/' . $Cliente->CUITCliente) }}" method="post">
            <!-- @csrf  Agrega esto para incluir el token de CSRF -->
            <div class="credentials">
                <h2 class="modify-customer-title">Complete</h2>
                <label for="cuit">CUITCliente:</label>
                <input id="cuit" type="number" name="cuit" value="{{ $Cliente->CUITCliente }}" readonly required>
                <br>

                <label for="razonsocial">Razón Social:</label>
                <input id="razonsocial" type="text" name="razonsocial" value="{{ $Cliente->RazonSocial }}" required>
                <br>

                <label for="nro">Número de cliente:</label>
                <input id="nro" type="number" name="nro" value="{{ $Cliente->NroCliente }}" required>
                <br>
            </div>
            <div class="file-container">
                <input type="submit" class="btn-submit btn" value="Submit" name="submit">
                <a class="btn" href="{{ url('/searchCustomer') }}">Back</a>
            </div>
        </form>
        @if(isset($_GET['msg']))
            <div class="alert alert-success">
                {{ urldecode($_GET['msg']) }}
        @endif

        </div>
    </div>
    <script src="..//resources/js/script.js"></script>
</body>

</html>