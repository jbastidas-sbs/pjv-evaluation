<?php
$archivo = file_get_contents("tareas.txt");
$tareas = array();
$dependencias = array();

$tok = strtok($archivo, "\n\t\r");
if ($tok == "# Total de tareas")
{
    $n = strtok("\n\t\r");
}
$tok = strtok("\n\t\r");
if ($tok == "# Tiempo que toma cada tarea (tarea, tiempo)")
{
    for ($i = 0; $i < $n; $i++)
    {
        $tok = strtok("\n\t\r");
        $duracion = strstr($tok, ',');
        $tareas[$i] = substr($duracion, 1);
    }
}
$tok = strtok("\n\t\r");
if ($tok == "# Dependencias entre tareas (tarea, dependencias)")
{
    while ($tok !== false)
    {
        $tok = strtok("\n\t\r");
        $a = explode(",", $tok);
        $dependencias[$a[0]] = array_slice($a, 1);
    }
}

$entrada = fopen('php://stdin', 'r');
$entradaDepurada = preg_replace("[\n|\r|\n\r]", "", fgets($entrada));
$tareasPorCalcular = explode(",", $entradaDepurada);
foreach ($tareasPorCalcular as $tarea)
{
    echo $tarea." ".calcularDuracion($tarea)."\n";
}

function calcularDuracion($value)
{
    global $tareas;
    global $dependencias;
    $duracion = $tareas[$value];

    if (array_key_exists($value, $dependencias))
    {
        $dep = $dependencias[$value];
        if (count($dep) > 1)
        {
            $max = 0;
            foreach ($dep as $d)
            {
                if ( ($du = calcularDuracion($d)) > $max )
                {
                    $max = $du;
                }
            }
            $duracion = $duracion + $max;
        }
        else
        {
            $duracion = $duracion + calcularDuracion($dep[0]);
        }
    }
    return $duracion;
}

?>