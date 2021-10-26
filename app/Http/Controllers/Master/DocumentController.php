<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
Use App\CoreBilling\Billing;
use App\CoreBilling\Helpers\Storage\StorageDocument;

class DocumentController extends Controller
{
    use StorageDocument;
    protected $route = 'academic/saledocument';

    public function downloadExternal($domain,$type,$filename,$format = null) {
        $extension = 'xml';
        switch ($type) {
            case 'pdf':
                $folder = 'pdf';
                $extension = 'pdf';
                break;
            case 'xml':
                $folder = 'signed';
                $extension = 'xml';
                break;
            case 'cdr':
                $folder = 'cdr';
                $extension = 'zip';
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

        $route = 'storage'.DIRECTORY_SEPARATOR.$domain.DIRECTORY_SEPARATOR.'saledocument'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$filename.'.'.$extension;
        
        return response()->download(public_path($route));
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
