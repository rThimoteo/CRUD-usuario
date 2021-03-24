<?php
// Operação de exclusão após confirmação 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Incluindo o config
    require_once "config.php";
    
    // Prepare a declaração no banco
    $sql = "DELETE FROM users WHERE id = ?";
    
    if($demo = $mysqli->prepare($sql)){
        // Vincular variáveis 
        $demo->bind_param("i", $param_id);
        
        // Definir parâmetros 
        $param_id = trim($_POST["id"]);
        
        // Tentativa de execução
        if($demo->execute()){
            // Dados deletados. Voltando ao Início
            header("location: index.php");
            exit();
        } else{
            echo "Algo deu errado. Tente novamente mais tarde.";
        }
    }
     
    // Fechar declaração
    $demo->close();
    
    // Fechar conexão
    $mysqli->close();
} else{
    // Verificar o ID
    if(empty(trim($_GET["id"]))){
        // ID invalido, exibir erro
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Deletar Registro</title>
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
                    <h2 class="mt-5 mb-3">Deletar Usuário</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Deseja remover este usuário?</p>
                            <p>
                                <input type="submit" value="Sim" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary ml-2">Não</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>