<?php
// Inicialize a sessão
session_start();
require_once "db/config.php";

include 'templates/header.php';

?>
  <div class="container">
		  <div class="col-sm-12">
		    <center>  <h1 class="m-3"> Upload do certificado</h1></center>
			<!--Conteudo -->
			  <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <center> <h3 class="card-title ">Enviei seu certificado digital para assinar</h3></center>
              </div>
              <!-- /.card-header -->

              <!-- form start -->
              <form id="login" name="certificado" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >

                <div class="card-body">
                  
				
                  <div class="form-group">
                    <label for="inputDoc" class="form-label">Certificado <span style="color:red; font-weight:bold" ></span></label>
                    <input type="file" class="form-control"  accept=".p12, .pfx" id="arquivo" name="arquivo" required>                    
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Senha</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" name="senhaCertificado"  required>
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
    </div>
 <?php
 include 'templates/footer.php';
 $cpf = $_SESSION["descpf"];

// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){


    $file = $_FILES['arquivo'];
	$senhaCert = $_POST["senhaCertificado"];
    
	if ($file["error"]){
        echo "<script type='text/javascript'>toastr.error('Erro no arquivo')</script>";
        die;
	}
    $dirUploads2 ="certificados/".$cpf."/".$file["name"];
	$dirUploads ="certificados/".$cpf;
    $filename ="certificados". DIRECTORY_SEPARATOR . $cpf . DIRECTORY_SEPARATOR .$file["name"];
    $cert_store = file_get_contents("certificados". DIRECTORY_SEPARATOR . $cpf . DIRECTORY_SEPARATOR .$file["name"]); //CERTIFICADO ICP PATH
    
	if(move_uploaded_file($file["tmp_name"],$dirUploads . DIRECTORY_SEPARATOR . $file["name"])){
        //Verifica se foi possivel ler o certificado
        if (!$cert_store ) {
          
            echo "<script type='text/javascript'>toastr.error('Erro ao ler certificado!')</script>";
            exit;
        }
            
        //Pega dados do certificado
        if (openssl_pkcs12_read($cert_store, $cert_info, $senhaCert)) {

           $stmt = $pdo->prepare("INSERT INTO tb_certificados (desnome, dessenhacertificado, descaminho)
           VALUES (:desnome,:dessenhacertificado, :descaminho)");

            $insert = $stmt->execute(array(
                ':desnome' => $file["name"],
                ':dessenhacertificado' => $senhaCert,
                ':descaminho' => $dirUploads2
             ));

            if($insert){
            
                echo "<script type='text/javascript'>toastr.success('Certificado configurado com sucesso!')</script>";
            }

        }else{
         
            echo "<script type='text/javascript'>toastr.error('Erro ao ler certificado!')</script>";
            exit;
        }

	}else{

       
        echo "<script type='text/javascript'>toastr.error('Erro ao realizar upload!')</script>";
        exit;
	}

 

}
 ?>