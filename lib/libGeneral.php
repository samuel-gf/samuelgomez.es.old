<?php
    session_start();

    // Convierte la primera letra del nombre y apellido en mayúsculas
    function ucname($string) {
        mb_internal_encoding('UTF-8');
        $arrMayus = ["Á","É","Í","Ó","Ú","Ü","Ñ","Ç"];
        $arrMinus = ["á","é","í","ó","ú","ü","ñ","ç"];
        $arrPalabras = explode(" ", $string);
        $stringFinal = "";
        foreach ($arrPalabras as $k => $palabra) {
            $primera = mb_strtoupper(mb_substr($palabra, 0, 1));
            $resto = mb_substr($palabra, 1);
            $stringFinal .= $primera.mb_strtolower(str_replace($arrMayus,$arrMinus,$resto), 'UTF-8')." ";
        }
        $stringFinal = trim($stringFinal);
        return $stringFinal;
    }
    function getHoy(){
        date_default_timezone_set('Europe/Madrid');
        return date("Y-m-d");
    }

    function getFechaFromSQL($mysqldate, $formato){
        $phpdate = strtotime($mysqldate);
        return date($formato, $phpdate);

    }


    function mb_str_pad($str, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT, $encoding = NULL){
        $encoding = $encoding === NULL ? mb_internal_encoding() : $encoding;
        $padBefore = $dir === STR_PAD_BOTH || $dir === STR_PAD_LEFT;
        $padAfter = $dir === STR_PAD_BOTH || $dir === STR_PAD_RIGHT;
        $pad_len -= mb_strlen($str, $encoding);
        $targetLen = $padBefore && $padAfter ? $pad_len / 2 : $pad_len;
        $strToRepeatLen = mb_strlen($pad_str, $encoding);
        $repeatTimes = ceil($targetLen / $strToRepeatLen);
        $repeatedString = str_repeat($pad_str, max(0, $repeatTimes)); // safe if used with valid utf-8 strings
        $before = $padBefore ? mb_substr($repeatedString, 0, floor($targetLen), $encoding) : '';
        $after = $padAfter ? mb_substr($repeatedString, 0, ceil($targetLen), $encoding) : '';
        return $before . $str . $after;
    }
    // Corta la cadena y rellena con espacios u otro
    function width($str, $nChars, $fill = ' '){
        return mb_str_pad(mb_substr($str,0,$nChars),$nChars,$fill,STR_PAD_RIGHT, $encoding='utf-8');
    }

    function rDebug(&$arr){
        echo '<div class="preformatted">';
        print_r($arr);
        echo '</div>';
    }
?>
