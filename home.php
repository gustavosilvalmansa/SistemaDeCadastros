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
     <center><h1 class="m-3">Estatisticas</h1></center>
</div><!-- /.col -->

<div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row shadows">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$row["total"];?></h3>
                <p>Meus assinados</p>
              </div>
              <div class="icon">
                <i class="fas fa-check-circle"></i>
              </div>
              <a href="meusAssinados.php" class="small-box-footer">Visualizar <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>0<sup style="font-size: 20px"></sup></h3>

                <p>Assinaturas para terceiros</p>
              </div>
              <div class="icon">
                <i class="fas fa-check-circle"></i>
              </div>
              <a href="#" class="small-box-footer">Visualizar <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>0</h3>

                <p>Minhas assinaturas pendentes</p>
              </div>
              <div class="icon">
                <i class="fas fa-exclamation-circle"></i>
              </div>
              <a href="#" class="small-box-footer">Visualizar <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>0</h3>

                <p>Assinaturas de terceiros pendentes</p>
              </div>
              <div class="icon">
                <i class="fas fa-clock"></i>
              </div>
              <a href="#" class="small-box-footer">Visualizar <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
        </div>
        <!-- /.row -->
      
  </div>
 <?php
 include 'templates/footer.php';
 ?>