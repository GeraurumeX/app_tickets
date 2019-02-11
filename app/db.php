<?php

function db_connect(){
    $dsn = DB['dsn'];
    $user = DB['user'];
    $pass = DB['pass'];
    $options = array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' );

    try {
        $db = new PDO($dsn, $user, $pass, $options);
    } catch ( PDOException $e ) {
        echo '<p>¡Error!: <mark>'. $e->getMessage() . '</mark></p>';
        die();
    }
}

function db_query($sql, $data = array(), $is_search = false, $search_one = false){
    $db = db_connect();

    $mysql = $db->prepare( $sql );
    $mysql->execute( $data );

    if ( $is_search ){
        /* Para consultas tipo READ */
        if ( $search_one ) {
            /* Para buscar un registro */
            $result = $mysql->fetch(PDO::FETCH_ASSOC);
        } else {
            /* Para buscar todos los registros */
            $result = $mysql->fetchAll(PDO::FETCH_ASSOC);
        }
        $db = null;
        return $result;
        
    } else {
        /* Para consultas de tipo CREATE, UPDATE y DELETE */
        $db = null; /* Para cerrar la base de datos  */ 
        return true;
    }
}



?>