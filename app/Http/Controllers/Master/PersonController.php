<?php

namespace App\Http\Controllers\Master;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PersonController extends Controller
{
    protected $token;
    protected $service_ruc;
    protected $service_dni;

    public function __construct()
    {
        $this->token = env('API_APIS_NET_TOKEN');
        $this->service_ruc = env('API_APIS_NET_URL_RUC');
        $this->service_dni = env('API_APIS_NET_URL_DNI');
    }

    public function getDataRuc($ruc){

        $url = $this->service_ruc . $ruc;

        return $this->getData($url);

    }
    public function getDataDni($dni){

        $url = $this->service_dni . $dni;

        return $this->getData($url);

    }

    private function getData($url){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $this->token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $empresa = json_decode($response);

        return $empresa;
    }
}
