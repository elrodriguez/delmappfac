<?php

namespace App\Http\Controllers\Academic\Charges;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\CoreBilling\Billing;
use App\CoreBilling\Helpers\Storage\StorageDocument;
use App\Models\Master\Document;
use Exception;

class ChargesDownloadController extends Controller
{
    use StorageDocument;
    protected $route = 'academic/saledocument';

    public function downloadExternal($model, $type, $external_id, $format = null) {
        $model = "App\\Models\\Master\\".ucfirst($model);
        $document = $model::where('external_id', $external_id)->first();

        if (!$document) throw new Exception("El código {$external_id} es inválido, no se encontro documento relacionado");

        if ($format != null) $this->reloadPDF($document, 'invoice', $format, $this->route);

        return $this->download($type, $document);
    }

    public function download($type, $document) {
        switch ($type) {
            case 'pdf':
                $folder = 'pdf';
                break;
            case 'xml':
                $folder = 'signed';
                break;
            case 'cdr':
                $folder = 'cdr';
                break;
            case 'quotation':
                $folder = 'quotation';
                break;
            case 'sale_note':
                $folder = 'sale_note';
                break;

            default:
                throw new Exception('Tipo de archivo a descargar es inválido');
        }

        return $this->downloadStorage($document->filename, $folder);
    }
    public function toPrintInvoice($model,$external_id, $format = null) {

        $model = "App\\Models\\Master\\".ucfirst($model);
        $document = $model::where('external_id', $external_id)->first();

        if (!$document) throw new Exception("El código {$external_id} es inválido, no se encontro documento relacionado");

        if ($format != null) $this->reloadPDF($document, 'invoice', $format, $this->route);
        $temp = tempnam(sys_get_temp_dir(), 'pdf');
        file_put_contents($temp, $this->getStorage($document->filename, 'pdf',$this->route));

        return response()->file($temp);
    }

    private function reloadPDF($document, $type, $format, $route) {
        $billing = new Billing();
        $billing->createPdf($document,'invoice',$format, $route);
    }
}
