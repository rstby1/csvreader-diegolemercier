<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleImport extends Model {

    protected $table = 'import_ventas';
    protected $fillable = ['Fecha', 'TipoComprobante', 'PuntoVenta', 'NumeroComprobante', 'ImporteVenta', 'CUITCliente'];
    // Desactivar timestamps
    public $timestamps = false;

}

