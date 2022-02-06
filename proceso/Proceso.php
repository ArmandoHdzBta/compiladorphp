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
        // var_dump($this->comprobar());
        $this->compilar($this->comprobar());
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

    private function comprobarInicio($inicio){
        if(in_array($inicio, TipoDeDato::$TIPODATOS))
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

    private function comprobarValor($valor){
        if(in_array($valor, TipoDeDato::$NUMEROS))
            return true;
        else
            return false;
    }

    private function comprobar(){
        $cadena = $this->separarLinea();
        $i = 0;
        for ($i; $i < sizeof($cadena)-1; $i++) {
            /*echo $cadena[$i]. " correcto: ";
            var_dump($this->comprobarInicio($cadena[$i]));
            echo "<hr>";*/

            if($this->comprobarInicio($cadena[$i])){
                // echo $cadena[$i]. " correcto: ";
                if($this->comprobarVariable($cadena[$i+1])){
                    // echo $cadena[$i+1]. " correcto: ";
                    if($this->comprobarAsignacion($cadena[$i+2])){
                        if($this->comprobarValor($cadena[$i+3]))
                        echo $cadena[$i]." ".$cadena[$i+1]." ".$cadena[$i+2]." ".$cadena[$i+3]."<br>";
                        $i = $i + 4;
                        return true;
                    }
                }
            }


            /*if($this->comprobarInicio($cadena[$i])){
                return true;
            }else if($this->comprobarVariable($cadena[$i])){
                return false;
            }else if($this->comprobarAsignacion($cadena[$i])){
                return true;
            }else if(!$this->comprobarNoAsignacion($cadena[$i])){
                return false;  
            }*/
        }
    }

    private function compilar($compilarEstado){
        if($compilarEstado)
            echo "Compilado correctamente";
        else
            echo "Error de compilacion";
    }

    /*
    intento comprobacion 
    */
}