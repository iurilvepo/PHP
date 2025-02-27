<?php

$host = "186.202.152.67";
$user = "jadehotel";
$pass = "Vitlnx!@#2009";
$dbname = "jadehotel";
$port = 3306;

try{
    //conexão com a porta
    $pdo = new PDO("mysql:host=$host; port=$port; dbname=" . $dbname, $user, $pass);

    //Conexão sem a porta
    //$conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);
    //echo "Conexão com banco de dados realizado com sucesso!";
}catch (PDOException $err){
    //echo "Erro: Conexão com banco de dados não realizado com sucesso. Erro gerado " . $err->getMessage();

}




?>