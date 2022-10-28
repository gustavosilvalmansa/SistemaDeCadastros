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

?>

		  <div class="col-sm-12">
		    <center>  <h1 class="m-3"> Assinar Documento </h1></center>
			<!--Conteudo -->
			  <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <center> <h3 class="card-title ">Preencha os dados e envie seu documento para assinatura</h3></center>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="salvarAssinatura.php" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="seuemail@email.com" required>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputPassword1">Nome do documento</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="docNome" placeholder="Contrato" required>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputPassword1">Descrição do documento</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="descNome" placeholder="Contratação de funcionarios" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Motivo da assinatura</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="motivo" placeholder="Concordo com o conteudo do documento" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Arquivo</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="arquivo" class="custom-file-input" id="exampleInputFile" required>
                        <label class="custom-file-label" for="exampleInputFile">Selecione um PDF</label>
                      </div>
                      
                    </div>
                  </div>
				  <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="icp" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Assinatura ICP</label>
                  </div>
                </div>
                </div>
				
                <!-- /.card-body -->

                <div class="card-footer">
                 <center> <button type="submit" class="btn btn-primary">Enviar</button></center>
                </div>
              </form>
            </div>
            <!-- /.card -->
			<!-- Fim Conteudo -->
          </div>
 <?php
 include 'templates/footer.php';
 ?>