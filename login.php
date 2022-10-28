<?php
// Inicialize a sessão
session_start();
 
// Verifique se o usuário já está logado, em caso afirmativo, redirecione-o para a página de boas-vindas
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}
 
// Incluir arquivo de configuração
require_once "db/config.php";
 
// Defina variáveis e inicialize com valores vazios
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processando dados do formulário quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Verifique se o nome de usuário está vazio
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor, insira o nome de usuário.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Verifique se a senha está vazia
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, insira sua senha.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validar credenciais
    if(empty($username_err) && empty($password_err)){
        // Prepare uma declaração selecionada
        $sql = "SELECT id, usuario, senha FROM usuarios WHERE usuario = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Definir parâmetros
            $param_username = trim($_POST["username"]);
            
            // Tente executar a declaração preparada
            if($stmt->execute()){
                // Verifique se o nome de usuário existe, se sim, verifique a senha
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["usuario"];
                        $hashed_password = $row["senha"];
                        if(password_verify($password, $hashed_password)){
                            // A senha está correta, então inicie uma nova sessão
                            session_start();
                            
                            // Armazene dados em variáveis de sessão
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirecionar o usuário para a página de boas-vindas
                            header("location: home.php");
                        } else{
                            // A senha não é válida, exibe uma mensagem de erro genérica
                            $login_err = "Nome de usuário ou senha inválidos.";
                        }
                    }
                } else{
                    // O nome de usuário não existe, exibe uma mensagem de erro genérica
                    $login_err = "Nome de usuário ou senha inválidos.";
                }
            } else{
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }
    
    // Fechar conexão
    unset($pdo);
}
?>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
      <link rel="stylesheet" href="dist/css/indexstyle.css">
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>

    <title>Oleiroagro, Login!</title>
      <link rel="shortcut icon" href="imagens/avatar.png" type="image/x-icon">

  </head>
  <body>
<div class="login-wrap">
	<div class="login-html">
		<div class="login-form">
			<div class="sign-in-htm">
			    <div class="group">

   <center>     <img src="dist/img/oleiro.png"  class="img-fluid " alt=""/> </center>
        </div> 
                            <form id="login" name="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >

				<div class="group">
					<label for="user" class="label">Usuário</label>
                   <input type="text" id="usuario" name="username" class="input" placeholder="" required/>
				</div>
				<div class="group">
					<label for="pass" class="label">Senha</label>
           <input id="senha"  name="password" type="password" class="input" style="font-color:white" placeholder="" required />
				</div>
				<div class="group">
				<!--	<input id="check" type="checkbox" class="check" checked>
					<label for="check"><span class="icon"></span> Keep me Signed in</label> -->
				</div>
				<div class="group">
                      <input type="submit" class="button" value="Login"/>
                      			</form>

				</div>
				<div class="hr"></div>
				<div class="foot-lnk">
</div>
			</div>
		
			</div>
		</div>
	</div>
</div>
  </body>
</html>