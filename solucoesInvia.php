<?php
// Inicialize a sessão
session_start();
 
require_once "db/config.php";

// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
    include 'templates/header.php';

    $sql = "SELECT COUNT(*) AS total FROM tb_documentosassinados;    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="col-sm-12">
     <center><h1 class="m-3">Soluções Invia</h1></center>
</div><!-- /.col -->

<div class="container-fluid">
    
             
     <div class="card card-success" style="background-color: #f4f6f9;">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="card mb-2 bg-gradient-dark">
                  <img class="card-img-top max-400" src="dist/img/bannerwp.jpg"  alt="Dist Photo 1">
                  <div class="card-img-overlay d-flex flex-column justify-content-end">
                    <h5 class="card-title text-primary text-white"></h5>
                    <p class="card-text text-white pb-2 pt-1">A solução ideal para os protocolos de sua empresa.</p>
                    <a href="https://webpki.com.br/protocolador.html" target="_blank" class="text-white">Saiba mais</a>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="card mb-2">
                  <img class="card-img-top max-400" src="dist/img/google.png" alt="Dist Photo 2">
                  <div class="card-img-overlay d-flex flex-column justify-content-end">
                    <h5 class="card-title text-white mt-5 pt-2"></h5>
                    <p class="card-text pb-2 pt-1 text-primary"><br>
                    Implemente as ferramentas do Google Workspace em parceria com a INVIA.
                    </p>
                    <a target="_blank" href="https://invia.com.br/cert/googleworkspace.html" class="text-primary">Saiba mais</a>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="card mb-2">
                  <img class="card-img-top max-400" src="dist/img/notasimples.jpg" alt="Dist Photo 3">
                  <div class="card-img-overlay d-flex flex-column justify-content-end">
                    <h5 class="card-title text-primary"></h5>
                    <p class="card-text pb-1 pt-1 text-white">
                    </p>
                    <a href="#" class="button text-white">Saiba mais</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  </div>
 <?php
 include 'templates/footer.php';
 ?>