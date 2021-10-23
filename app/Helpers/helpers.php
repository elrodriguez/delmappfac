<?php

function ui_avatars_url($name,$size = 50,$background='random',$rounded=true){
    if($background == 'none'){
        $url = 'https://ui-avatars.com/api/?name='.$name.'&size='.$size.'&rounded='.$rounded;
    }else{
        $url = 'https://ui-avatars.com/api/?name='.$name.'&size='.$size.'&background='.$background.'&rounded='.$rounded;
    }

    return $url;
}
function string_sanitize($s) {
    $result = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($s, ENT_QUOTES));
    return $result;
}
function uuids() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),
        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,
        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,
        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
 }

 function myencrypt($string) {
    $key = str_replace('base64:','',env('APP_KEY'));  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    $hash = '';
    if (isset($string) && $string != '') {
        $key = sha1($key);
        $strLen = strlen($string);
        $keyLen = strlen($key);
        $j = 0;


        for ($i = 0; $i < $strLen; $i++) {
            $ordStr = ord(substr($string, $i, 1));
            if ($j == $keyLen) {
                $j = 0;
            }
            $ordKey = ord(substr($key, $j, 1));
            $j++;
            $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
        }
    }
    return $hash;
}

function mydecrypt($string) {
    $key = str_replace('base64:','',env('APP_KEY'));  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    $hash = '';
    if (isset($string) && $string != '') {
        $key = sha1($key);
        $strLen = strlen($string);
        $keyLen = strlen($key);
        $j = 0;


        for ($i = 0; $i < $strLen; $i+=2) {
            $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
            if ($j == $keyLen) {
                $j = 0;
            }
            $ordKey = ord(substr($key, $j, 1));
            $j++;
            $hash .= chr($ordStr - $ordKey);
        }
    }
    return $hash;
}

function codeStudents($string){
    return date('Y').'-'. str_pad($string, 5, "0", STR_PAD_LEFT);
}

function get_enum_values( $table, $field )
{
    $type = \Illuminate\Support\Facades\DB::select( \Illuminate\Support\Facades\DB::raw("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'") )[0]->Type;
    preg_match('/^enum\((.*)\)$/', $type, $matches);
    $enum = array();
    foreach( explode(',', $matches[1]) as $value )
    {
        $v = trim( $value, "'" );
        $enum = \Illuminate\Support\Arr::add($enum, $v, $v);
    }
    return $enum;
}

function isDevice($agent){
    $tablet_browser = 0;
    $mobile_browser = 0;
    $body_class = 'desktop';

    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($agent))) {
        $tablet_browser++;
        $body_class = "tablet";
    }

    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($agent))) {
        $mobile_browser++;
        $body_class = "mobile";
    }

    return $body_class;
}
function wspacelang($string){
    $subject = \Illuminate\Support\Facades\Lang::get('messages.'.$string);
    return str_replace(' ' ,'_' ,$subject);
}

function seo_url($cadena){
	$cadena= utf8_decode($cadena);
    $cadena = str_replace(' ', '-', $cadena);
	$cadena = str_replace('?', '', $cadena);
	$cadena = str_replace('+', '', $cadena);
	$cadena = str_replace(':', '', $cadena);
	$cadena = str_replace('??', '', $cadena);
	$cadena = str_replace('`', '', $cadena);
	$cadena = str_replace('!', '', $cadena);
	$cadena = str_replace('¿', '', $cadena);
    $cadena = str_replace('.', '', $cadena);
    $cadena = str_replace(',', '', $cadena);
    $cadena = str_replace('[', '', $cadena);
    $cadena = str_replace(']', '', $cadena);
    $cadena = str_replace('(', '', $cadena);
    $cadena = str_replace(')', '', $cadena);
    $cadena = str_replace('&', '', $cadena);
    $cadena = str_replace('%', '', $cadena);
    $cadena = str_replace('$', '', $cadena);
    $cadena = str_replace('#', '', $cadena);
    $cadena = str_replace('/', '', $cadena);
	$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ??';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
   
    return $cadena;
	
}
