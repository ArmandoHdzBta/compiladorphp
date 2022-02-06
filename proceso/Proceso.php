<?php

namespace proceso;

include "./componentes/TipoDeDato.php";

use componentes\TipoDeDato;

class Proceso {
    private $url;
    private $palabras = [];

    public function __construct($url) {
        $this->url = $url;
        print_r($this->comprobar());
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

    private function comprobar(){
        $tipo = TipoDeDato::$TIPODATOS;

        for ($i=0; $i < sizeof($this->separarLinea()); $i++) { 
            if(in_array($this->separarLinea()[$i], $tipo)){
                return true;
            }else{
                return false;
            }
        }

        //print_r($TIPODATOS);
    }
}