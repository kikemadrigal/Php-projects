<?php
class Util{


    public static function cortarCadena($cadena){
        //Strip_tags: retira las etiquetas HTML y PHP de un String
        //substr($cadena, corta inicio, corta final)
        //strlen: devuelve la longitud de la cadena
        $longitud = 20;
        $stringDisplay = substr(strip_tags($cadena), 0, $longitud);
        if (strlen(strip_tags($cadena)) > $longitud)
            $stringDisplay .= ' ...';
        return $stringDisplay;
    }

    public static function formatearCadena($cadena){
        //$arrayDeAsABuscar=array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä');
        //$arrayDeAsSustituidas('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A');
        $cadena=html_entity_decode($cadena);
        $cadena= str_replace(" ", "&nbsp;", $cadena);
        return $cadena;
    }
    public static function quitarEspaciosEnBlancoPrincipioYFinal($cadena){
        $cadenaLimpia=trim($cadena);
        //$cadenaLimpia=urlencode($cadenaLimpia);
        return $cadenaLimpia;
    }
    public static function url_exists($url)
    {
        $file_headers = @get_headers($url);
        if(strpos($file_headers[0],"200 OK")==false)
        {
            echo $file_headers[0];
            $exists = false;
            return false;
        }
        else
        {
            $exists = true;
            return true;
        }
    }
    public static function getStyleFormat($game){
        if ($game->getSystem()=="MSX"){
            if ($game->getFormat()=="Tape"){
                return "tape-MSX";
            }else if ($game->getFormat()=="Tape deluxe"){
                return "tape-deluxe-MSX";
            }else if ($game->getFormat()=="Tape carton"){
                return "tape-carton-MSX";
            }else if ($game->getFormat()=="Cardbridge"){
                return "cardbridge-MSX";
            }else if ($game->getFormat()=="Disk"){
                return "cartucho-PS4";
            }else{
                return " ";
            }
        }

    }
    /**
     * Esta funciín es utilizada en views/mwsia/insert.php
     */
    public static function formatearTexto($name) {
        $except = array('\\', '/', ':', '*', '?', '"', '<', '>', '|', '\'');
        //Le quitamos los espacios
        $except = str_replace(" ","-",$except);
        return str_replace($except, '', $name);
    }


}
?>