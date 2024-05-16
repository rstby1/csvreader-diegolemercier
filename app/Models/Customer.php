<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    /*
      CUITCliente bigint UN PK
      RazonSocial varchar(30)
      NroCliente int UN
      YTD double(15,2)
      tier int
     */

    protected $primaryKey = 'CUITCliente';
    protected $table = "clientes";
    protected $fillable = ["CUITCliente", "RazonSocial", "NroCliente", "YTD", "tier",];

    //este metodo se llama cuando se inicializa el modelo
    protected static function boot() {
        parent::boot();

        // se ejecuta antes de que se guarde o actualice el modelo
        static::saving(function ($cliente) {
            // si el modelo tiene un campo YTD actualizado, úsalo, de lo contrario, déjalo como está
            $cliente->YTD = isset($cliente->YTD_updated) ? $cliente->YTD_updated : $cliente->YTD;
        });
    }

    // Desactivar timestamps
    public $timestamps = false;

}
