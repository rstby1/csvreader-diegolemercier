@if(isset($cliente))
    <form action="{{ route('updateCustomer', $cliente->id) }}" method="post">
        @method('PUT') <!-- Método necesario para indicar que es una solicitud de actualización -->

        <label for="cuit">CUIT del Cliente:</label>
        <input type="text" name="cuit" id="cuit" value="{{ $cliente->CUITCliente }}" required>

        <label for="razon_social">Razón Social:</label>
        <input type="text" name="razon_social" id="razon_social" value="{{ $cliente->RazonSocial }}" required>

        <label for="nro_cliente">Número de Cliente:</label>
        <input type="text" name="nro_cliente" id="nro_cliente" value="{{ $cliente->NroCliente }}" required>

        <button type="submit">Actualizar Cliente</button>
    </form>
@else
    <p>No se encontró ningún cliente con el CUIT proporcionado.</p>
@endif