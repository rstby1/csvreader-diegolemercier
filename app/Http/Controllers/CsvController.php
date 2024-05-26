<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportVenta;
use App\Models\Customer;
use App\Models\SaleImport;
use Carbon\Carbon;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class CsvController extends Controller
{

    public function processCSV(Request $request)
    {
        if ($request->hasFile('fileCSV')) {
            $file = $request->file('fileCSV'); // Get the uploaded file object

            if ($this->checkCSV($file)) {
                // Proceed with processing the CSV file
                $file->store('csv_files'); // Store the uploaded file in the 'csv_files' directory
                $this->impData($file); // Pass the stored file path to the impData function
            } else {
                // $this->redirectTo('Invalid file format. Only CSV files are allowed.', false);
                return redirect('/?msg=' . urlencode('Invalid file format. Only CSV files are allowed.') . '&type=alert-failed');
            }
        } else {
            //$this->redirectTo(, false);
            return redirect('/?msg=' . urlencode('Error: No file uploaded.') . '&type=alert-failed');
        }
    }

    private function impData($file)
    {
        $msg = 'Default Message';
        try {
            // if ($this->checkCSV($file)) {
            if (($handle = fopen($file, 'r')) !== false) {
                fgetcsv($handle, 1000, ';');
                while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                    if (count($data) === 8) {
                        try {
                            $dVenta = [
                                'Fecha' => strtolower($data[0]),
                                'TipoComprobante' => strtoupper($data[1]),
                                'PuntoVenta' => $data[2],
                                'NumeroComprobante' => $data[3],
                                'ImporteVenta' => $data[4],
                                'CUITCliente' => $data[5],
                            ];
                            $dCliente = [
                                'CUITCliente' => $data[5],
                                'RazonSocial' => $data[6],
                                'NroCliente' => $data[7],
                            ];
                            $x = Customer::where('CUITCliente', $data[5])->first();
                            $y = SaleImport::where('TipoComprobante', $data[1])
                                ->where('NumeroComprobante', $data[3])
                                ->first();
                            //intenté hacer una funcion aparte pero no llegaba con el tiempo
                            $this->processCSVData($x, $data, $y, $dVenta, $dCliente);

                            //$this->redirectTo('CSV file processed successfully.', true);
                        } catch (\Exception $e) {
                            DB::rollBack();
                            $msg = throw new \Exception('Error while processing CSV file. Details: ' . $e->getMessage());
                            // $this->redirectTo($msg, false);
                            return redirect('/?msg=' . urlencode($msg) . '&type=alert-failed');
                        }
                    } else {
                        $msg = 'Wrong number of columns in row. Expected 8, got ' . count($data) . '.';
                        return redirect('uploadFile/?msg=' . urlencode($msg) . '&type=alert-failed');
                    }
                }
            }
        } catch (\Exception $ex) {
            // return view('welcome', ['msg' => $ex->getMessage()]);
            $msg = throw new \Exception('Error while processing CSV file. Details: ' . $ex->getMessage());
            return redirect('uploadFile/?msg=' . urlencode($msg) . '&type=alert-failed');

        }
    }
    function processCSVData($x, $data, $y, $dVenta,$dCliente) {
        $msg = ''; // Initialize the message variable
        if ($x && $x->NroCliente != $data[7]) {
            $msg = 'Error: El CUIT ' . $data[5] . ' ya está registrado en otro cliente con NroCliente(' . $data[7] . ') diferente.' . $x->NroCliente;
        } elseif ($y) {
            $msg = 'Error: El comprobante ' . $data[1] . ' - ' . $data[3] . ' ya existe.';
        } elseif ($dVenta['ImporteVenta'] == 0) {
            $msg = 'Error: El importe de la venta no puede ser cero o nulo.';
        } elseif (Carbon::createFromFormat('d/m/Y', $dVenta['Fecha'])->isFuture()) {
            $msg = 'Error: La fecha del comprobante no puede ser futura.';
        } else {
            DB::beginTransaction();
            Customer::updateOrInsert($dCliente);
            SaleImport::create($dVenta);
            $this->updateStats();
            DB::commit();
            $msg = 'CSV file processed successfully.';
            // Redirect using a GET request after a successful POST
           // echo '<br>' . $msg . '<br>';
            return redirect('/?msg=' . urlencode($msg) . '&type=alert-success');
        }
    
        // Display the error message for failed validation
        echo '<br>' . $msg . '<br>';
    }
    public function redirectTo($msg, $n)
    {
        if ($n) {
            $type = 'alert-success';
        } else {
            $type = 'alert-failed';
        }
        return redirect('/?msg=' . urlencode($msg) . '&type=' . $type);
    }
    private function updateStats()
    {
        $anoPasado = date('d/m/Y', strtotime('-1 year'));

        $ventasAcumuladas = DB::table('import_ventas')
            ->select('CUITCliente', DB::raw('SUM(ImporteVenta) as ventas_acumuladas'))
            ->whereBetween(DB::raw('STR_TO_DATE(Fecha, "%d/%m/%Y")'), [
                Carbon::createFromFormat('d/m/Y', $anoPasado)->format('Y-m-d'),
                Carbon::now()->format('Y-m-d'),
            ])
            ->groupBy('CUITCliente')
            ->get();
        foreach ($ventasAcumuladas as $venta) {
            $cuitCliente = $venta->CUITCliente;
            $vAcumuladaas = $venta->ventas_acumuladas;
            $cliente = DB::table('clientes')->wheres('CUITCliente', $cuitCliente);
            if ($cliente) {
                DB::table('clientes')->where('CUITCliente', $cuitCliente)->update(['YTD' => $vAcumuladaas]);
            } else {
                DB::table('clientes')->insert([
                    'CUITCliente' => $cuitCliente,
                    'YTD' => $ventasAcumuladas,
                ]);
            }
            /* Tier 1: Ventas de hasta 1M, Tier 2: Ventas entre 1M y 3M y tier 3: Ventas de más de 3M */
        }
        $tierClientes = DB::table('clientes')->select('CUITCliente', 'YTD')->get();

        foreach ($tierClientes as $tier) {
            $cuitCliente = $tier->CUITCliente;
            $YTDcliente = $tier->YTD;

            // Aquí también hay un error en la consulta, deberías usar ->where en lugar de ->wheres
            $cliente = DB::table('clientes')->where('CUITCliente', $cuitCliente);

            if ($YTDcliente <= 1000) {
                $cliente->update(['tier' => 1]);
            } elseif ($YTDcliente <= 3000 && $YTDcliente > 1000) {
                $cliente->update(['tier' => 2]);
            } elseif ($YTDcliente > 3000) {
                $cliente->update(['tier' => 3]);
            } else {
                $cliente->update(['tier' => 0]);
            }
        }
    }

    public function checkCSV($file)
    {
        // Get the original file name
        $originalName = $file->getClientOriginalName();

        // Get the extension from the original file name
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);

        // Check if the extension is 'csv' (case-insensitive)
        if (strtolower($ext) === 'csv') {
            return true;
        } else {
            return false;
        }
    }

}
