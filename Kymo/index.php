<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CRUD Ususários</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
        .body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: plum;
        }
        #rodape {
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
        }
        #rodape img {
            width: 15%;
            height: 100px;
            position: absolute;
            bottom: 0;
            right: 0;
            object-fit: cover;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Usuários</h2>
                        <a href="criar.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Adicionar Usuário</a>
                    </div>
                    <?php
                    // Conecção com o MySQL
                    require_once "config.php";
                    
                    // Listar Usuários
                    $sql = "SELECT * FROM users";
                    if($result = $mysqli->query($sql)){
                        if($result->num_rows > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Nome</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>Senha</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_array()){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['password'] . "</td>";
                                        echo "<td>";
                                            //Acesso ao CRUD por incones
                                            echo '<a href="leitura.php?id='. $row['id'] .'" class="mr-3" title="Ver Registro" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="atualizar.php?id='. $row['id'] .'" class="mr-3" title="Atualizar Registro" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="deletar.php?id='. $row['id'] .'" title="Deletar Registro" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Liberar cache de busca
                            $result->free();
                        } else{
                            echo '<div class="alert alert-danger"><em>Nenhum resgistro encontrado.</em></div>';
                        }
                    } else{
                        echo "Algo deu errado. Tente novamente mais tarde.";
                    }
                    
                    // Fechar conexão com banco
                    $mysqli->close();
                    ?>
                </div>
            </div>        
        </div>
    </div>
    <div id="rodape">
    <img src="https://events.thechannelco.com/sites/thechannelco/files/events/sponsor_logos/files/kymo_web_logo.png"/> 
</div>
</body>
</html>