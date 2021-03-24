<?php
// Incluindo o config
require_once "config.php";
 
// Definido variaveis e variaveis de erro como vazias
$name = $email = $password = "";
$name_err = $email_err = $password_err = "";
 
// Processando dados do formulário
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validar nome
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Insira um nome.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Favor, colocar um nome válido";
    } else{
        $name = $input_name;
    }
    
    // Validar email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Por favor, insira um email";     
    } else{
        $email = $input_email;
    }
    
    // Validar senha
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Por favor, insira uma senha";     
    } else{
        $password = $input_password;
    }
    
    // Checando os erros antes de inserir
    if(empty($name_err) && empty($email_err) && empty($password_err)){
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
 
        if($demo = $mysqli->prepare($sql)){
            // Vincular as variáveis à instrução preparada por parâmetros 
            $demo->bind_param("sss", $param_name, $param_email, $param_password);
            
            // Definir parâmetros 
            $param_name = $name;
            $param_email = $email;
            $param_password = $password;
            
            // Tentativa de execução
            if($demo->execute()){
                // Registros criados, redirecinar
                header("location: index.php");
                exit();
            } else{
                echo "Algo deu errado. Tentar novamente mais tarde.";
            }
        }
         
        // Fechar declaração
        $demo->close();
    }
    
    // Fechar conexão
    $mysqli->close();
}
?>
 
 <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criação de Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Adicionar Usuário</h2>
                    <p>Preencha os dados para adionar o Usuário ao Banco de Dados.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Senha</label>
                            <input type="text" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>