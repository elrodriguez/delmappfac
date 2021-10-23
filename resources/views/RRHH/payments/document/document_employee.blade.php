<!DOCTYPE html>
@php
    $fecha = \Carbon\Carbon::parse($data['date_of_issue']);
    $mes = $fecha->month;
    $dia = $fecha->day;
    $anio = $fecha->year;
@endphp
<html>
    <head>

    </head>
    <body style="font-size: 16px;font-family: Arial;">
        <div>
            <table width="100%" class="tabla1">
                <tr>
                    <td width="73%" align="center">
                        <!--img id="logo" src="" alt="" width="255" height="57"-->
                        {{ $data['company_name'] }}
                    </td>
                    <td width="27%" rowspan="3" align="center" style="padding-right:0">
                        <table width="100%">
                            <tr>
                                <td height="50" align="center" class="border"><span class="h2">RUC: {{ $data['company_ruc'] }}</span></td>
                            </tr>
                            <tr>
                                <td height="40" align="center" class="border fondo"><span class="h1">BOLETA DE PAGO</span></td>
                            </tr>
                            <tr>
                                <td height="50" align="center" class="border">Nº <span class="text">{{ $data['expense_number'] }}</span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center">{{ $data['establishment_address'] }}</td>
                </tr>
                <tr>
                    <td align="center">Telf.: {{ $data['establishment_phone'] }}</td>
                </tr>
            </table>
            <table width="100%" class="tabla2">
                <tr>
                    <td width="11%">Señor (es):</td>
                    <td width="37%" class="linea"><span class="text">{{ $data['person_name'] }}</span></td>
                    <td width="5%">&nbsp;</td>
                    <td width="13%">&nbsp;</td>
                    <td width="4%">&nbsp;</td>
                    <td width="7%" align="center" class="border fondo"><strong>DÍA</strong></td>
                    <td width="8%" align="center" class="border fondo"><strong>MES</strong></td>
                    <td width="7%" align="center" class="border fondo"><strong>AÑO</strong></td>
                </tr>
                <tr>
                    <td>Dirección:</td>
                    <td class="linea"><span class="text"></span></td>
                    <td>DNI:</td>
                    <td class="linea"><span class="text">{{ $data['person_number'] }}</span></td>
                    <td>&nbsp;</td>
                    <td align="center" class="border"><span class="text">{{ $dia }}</span></td>
                    <td align="center" class="border"><span class="text">{{ $mes }}</span></td>
                    <td align="center" class="border"><span class="text">{{ $anio }}</span></td>
                </tr>
            </table>
            <table width="100%" class="tabla3">
                <tr>
                    <td colspan="3" align="center" class="fondo"><strong>DESCRIPCIÓN</strong></td>
                    <td align="center" class="fondo"><strong>IMPORTE</strong></td>
                </tr>
                @foreach ($data['items'] as $k => $item)
                    <tr>
                        <td colspan="3" >{{ $item['description'] }}</td>
                        <td align="right">{{ $item['total'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" align="right"><strong>TOTAL S/.</strong></td>
                    <td align="right"><span class="text">{{ $data['total'] }}</span></td>
                </tr>
            </table>
            <br><br><br>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" class="linea"></td>
                    <td></td>
                    <td align="center" class="linea"></td>
                </tr>
                <tr>
                    <td align="center" class="cancelado">FIRMA TRABAJADOR</td>
                    <td></td>
                    <td align="center" class="cancelado">FIRMA EMPLEADOR</td>
                </tr>
            </table>
        </div>
    </body>
</html>
