<?php

namespace proceso;

include "./componentes/TipoDeDato.php";
include "./componentes/SimbolosGenerales.php";
include "./componentes/Simbolos.php";

use componentes\TipoDeDato;
use componentes\SimbolosGenerales;
use componentes\Simbolos;

class Proceso {
    private $url;
    private $palabras = [];

    public function __construct($url) {
        $this->url = $url;
        var_dump($this->comprobar());
    }

    private function obtenerContenido(){
        $texto = '';
        $archivo = fopen($this->url, "r");

        while(!feof($archivo)){
            $texto .= fgets($archivo);
        }

        fclose($archivo);

        return $texto;
    }

    private function separarLinea(){
        $linea = explode(";", $this->obtenerContenido());
        for ($i=0; $i < sizeof($linea); $i++) { 
            $this->quitarEspacion($linea[$i]);
        }

        return $this->palabras;
    }

    private function quitarEspacion($linea){
        $palabra = explode(" ", $linea);
        for ($i=0; $i < sizeof($palabra); $i++) { 
            array_push($this->palabras, $palabra[$i]);
        }
    }

    private function conprobarInicio($inicio){
        if(in_array($inicio, TipoDeDato::$TIPODATOS) || in_array($inicio, SimbolosGenerales::$SIMBOLOSGENERALES))
            return true;
        else
            return false;
    }

    private function comprobarVariable($variable){
        if(!in_array($variable, TipoDeDato::$TIPODATOS) || !in_array($variable, SimbolosGenerales::$SIMBOLOSGENERALES))
            return true;
        else
            return false;
    }

    private function comprobarAsignacion($asignacion){
        if(in_array($asignacion, Simbolos::$SIMBOLOS))
            return true;
        else
            return false;
    }

    private function comprobarNoAsignacion($noAsignacion){
        if(!in_array($noAsignacion, Simbolos::$SIMBOLOS))
            return true;
        else
            return false;
    }

    private function comprobar(){
        $cadena = $this->separarLinea();
        for ($i=0; $i < sizeof($cadena); $i++) {
            echo $cadena[$i]. " ";
            var_dump($this->conprobarInicio($cadena[$i]));
            echo "<hr>";
            /*if(!$this->conprobarInicio($cadena[$i])){
                return false;
            }else if(!$this->comprobarVariable($cadena[$i])){
                return false;
            }else if($this->comprobarAsignacion($cadena[$i])){
                return false;
            }else if(!$this->comprobarNoAsignacion($cadena[$i])){
                return false;  
            }else{
                return true;
            }*/
        }

        //print_r($TIPODATOS);
    }
}