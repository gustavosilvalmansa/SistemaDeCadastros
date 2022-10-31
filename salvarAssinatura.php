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
$data = date("Y-m-d");

$stmt = $pdo->prepare("INSERT INTO tb_documentosassinados (desnome, desdescricao, desmotivo,boolicp,dtassinatura)
VALUES (:desnome, :desdescricao, :desmotivo, :boolicp, :dtassinatura)");
$insert = $stmt->execute(array(
    ':desnome' => $docNome,
    ':desdescricao' => $descNome,
    ':desmotivo' => $motivo,
    ':boolicp' => $icp,
    ':dtassinatura'=>$data
  ));
      if($insert){
          echo "<script>alert('Documento assinado!')</script>";
          header("location: meusAssinados.php");

      }

?>