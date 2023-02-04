<?php
$entrada = fopen('php://stdin', 'r');
while ($linea = trim(fgets($entrada)))
{
    $partes = explode(" ", $linea);
    $cantidadVacas = $partes[0];
    $capaciadCargaCamion = $partes[1];
    $pesosVacas = explode(",", $partes[2]);
    $produccionLechePorVaca = explode(",", $partes[3]);
    echo 'Resultado: '.produccionMaxima($pesosVacas, $produccionLechePorVaca, $cantidadVacas-1, $capaciadCargaCamion)." litros.\n";
}

function produccionMaxima($w, $v, $i, $aW)
{
    if ($i == 0)
    {
        if ($w[$i] <= $aW)
        {
            return $v[$i];
        }
        else
        {
            return 0;
        }
    }

    $produccionSinVaca_i = produccionMaxima($w, $v, $i-1, $aW);
    if ($w[$i] > $aW)
    {
        return $produccionSinVaca_i;
    } 
    else
    {
        $produccionConVaca_i = $v[$i] + produccionMaxima($w, $v, ($i-1), ($aW - $w[$i]));
        return max($produccionConVaca_i, $produccionSinVaca_i);
    }
}
?>