<?php
// Inicialize a sessão
session_start();
 
require_once "db/config.php";

// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$email = $_POST['email'];
$docNome = $_POST['docNome'];
$descNome = $_POST['descNome'];
$motivo = $_POST['motivo'];
//$arquivo = $_POST[''];
$icp = $_POST['icp'];


$stmt = $pdo->prepare("INSERT INTO tb_documentosassinados (desnome, desdescricao, desmotivo,boolicp)
VALUES (:desnome, :desdescricao, :desmotivo, :boolicp)");
$stmt->execute(array(
    ':desnome' => $docNome,
    ':desdescricao' => $descNome,
    ':desmotivo' => $motivo,
    ':boolicp' => $icp
  ));
header("location: assinarDocumento.php");


?>