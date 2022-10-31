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
    $sql = "SELECT * FROM tb_documentosassinados";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
?>
  
		  <div class="col-md-12 p-5">
      <center>  <h1 class="m-3"> Documentos assinados </h1></center>

			<!--Conteudo -->
			 <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Motivo</th>
                    <th>ICP?</th>
                    <th>Data de assinatura</th>
                    <th>Ações</th>

                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
                    {
                        $timestamp = strtotime($row["dtassinatura"]);
                        // Creating new date format from that timestamp
                         $new_date = date("d/m/Y", $timestamp);

                        $visualizar = ' <a href="#"><i style="color: #000;" class="fas fa-eye fa-md"></i></a>';
                        $mail = ' <a href="#"><i style="color: #000;" class="fas fa-envelope fa-md"></i></a>';

                    echo "<tr>" .
                          "<td>" . $row["iddocumento"] . "</td>" .
                          "<td>" . $row["desnome"] . "</td>" .
                          "<td>" . $row["desmotivo"] . "</td>" .
                          "<td>" . $row["boolicp"] . "</td>" .
                          "<td>" . $new_date . "</td>" .
                          "<td>" . $visualizar . $mail . "</td>" .
                          "</tr>";
                    }
                  ?>
                  </tbody>
                </table>
			<!-- Fim Conteudo -->
          </div>
 <?php
 include 'templates/footer.php';
 ?>