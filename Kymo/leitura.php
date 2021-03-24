<?php
// Verificar ID antes de processar
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Incluindo o config
    require_once "config.php";
    
    // Preparar declaração
    $sql = "SELECT * FROM users WHERE id = ?";
    
    if($demo = $mysqli->prepare($sql)){
        // Vincular variáveis
        $demo->bind_param("i", $param_id);
        
        // Definir parâmetros
        $param_id = trim($_GET["id"]);
        
        // Tentativa de execução
        if($demo->execute()){
            $result = $demo->get_result();
            
            if($result->num_rows == 1){
                // Busca de resultados com Array.
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                // Recuperar valores
                $name = $row["name"];
                $email = $row["email"];
                $password = $row["password"];
            } else{
                // Redirecionar para pagina de erro ao não encontrar o ID
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Algo deu errado. Tente novamente!";
        }
    }
     
    // Fechar declaração
    $demo->close();
    
    // Fechar conexão
    $mysqli->close();
} else{
    // Redirecionar para pagina de erro ao não encontrar o ID
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ver Registro</title>
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
                    <h1 class="mt-5 mb-3">Verificar Usuário</h1>
                    <div class="form-group">
                        <label>Nome</label>
                        <p><b><?php echo $row["name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <p><b><?php echo $row["email"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Senha</label>
                        <p><b><?php echo $row["password"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Voltar</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>