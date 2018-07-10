<?php

function conectaDB(){
    $db = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
    $db->query("SET NAMES 'utf8'");
    $_SESSION['db'] = $db;
    return $db;
}

function getArrArticulos($max=10){
    $db = $_SESSION['db'];
    $max = $db->escape_string(trim($max));
    $query = "SELECT * FROM artículos LIMIT $max";
    $rArticulos = $db->query($query);
    ($rArticulos)?NULL:die("***** ERROR SQL: ".$query."\n");
    $arrArticulos = array();
    while($rowArticulo = $rArticulos->fetch_assoc()){
        array_push($arrArticulos, $rowArticulo);
    }
    return $arrArticulos;
}

?>
