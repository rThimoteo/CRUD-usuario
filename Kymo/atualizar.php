<?php
// Incluindo o config
require_once "config.php";
 
// Definido variaveis e variaveis de erro como vazias
$name = $email = $password = "";
$name_err = $email_err = $password_err = "";
 
// Processando dados do formulário
if(isset($_POST["id"]) && !empty($_POST["id"])){
    
    $id = $_POST["id"];
    
    // Validar nome
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Por favor, insira um nome.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Por favor, insira um nome válido.";
    } else{
        $name = $input_name;
    }
    
    // Validar Email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Por favor, insira um email.";     
    } else{
        $email = $input_email;
    }
    
    // Validar senha
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Por favor, insira uma senha.";    
    } else{
        $password = $input_password;
    }
    
    // Checando erros antes de enviar ao banco de dados
    if(empty($name_err) && empty($email_err) && empty($password_err)){
        // Prepare a declaração no banco
        $sql = "UPDATE users SET name=?, email=?, password=? WHERE id=?";
 
        if($demo = $mysqli->prepare($sql)){
            // Vincular variáveis à instruçãodos parâmetros 
            $demo->bind_param("sssi", $param_name, $param_email, $param_password, $param_id);
            
            // Definir parâmetros 
            $param_name = $name;
            $param_email = $email;
            $param_password = $password;
            $param_id = $id;
            
            // Tente executar a declaração
            if($demo->execute()){
                // Registros atualizados com sucesso. Redirecionar ao início 
                header("location: index.php");
                exit();
            } else{
                echo "Algo deu errado. Tente novamente mais tarde.";
            }
        }
         
        // Fechar declaração
        $demo->close();
    }
    
    // Fechar conexão
    $mysqli->close();
} else{
    // Verifique a existência do parâmetro id antes de continuar  
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        
        $id =  trim($_GET["id"]);
        
        // Preparando a declaração SQL
        $sql = "SELECT * FROM users WHERE id = ?";
        if($demo = $mysqli->prepare($sql)){
            // Vincular variáveis à instrução preparada como parâmetros 
            $demo->bind_param("i", $param_id);
            
            // Definir parâmetros
            $param_id = $id;
            
            // Tente executar
            if($demo->execute()){
                $result = $demo->get_result();
                
                if($result->num_rows == 1){
                    //Resultado com array
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Recuperar valores 
                    $name = $row["name"];
                    $email = $row["email"];
                    $password = $row["password"];
                } else{
                    // ID inválido, retornar erro
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Algo deu errado. Tente novamente mais tarde.";
            }
        }
        
        // Fechar declaração
        $demo->close();
        
        // Fechar conexão
        $mysqli->close();
    }  else{
        // ID inválido, retornar erro
        header("location: error.php");
        exit();
    }
}
?>
 
 <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Registro</title>
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
                    <h2 class="mt-5">Atualizar Usuário</h2>
                    <p>Edite os valores e envie para atualizar o registro do usuário. </p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Atualizar">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>