<?php
    require_once 'config/config.php';

    try {
        $connect = new PDO(    
            DB_DRIVE . ":host=" . DB_HOST . ";port=" . DB_PORT. ";dbname=" . DB_NAME, 
            DB_USER,                                                       
            DB_PASSWORD,                                                
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );

        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $data = $connect->prepare(
            "SELECT * FROM EMPRESA ORDER BY CodEmpresa"
        );

        $data->execute();

    }catch(Exception $error) {
        echo '<p style="color: red;">ERROR: ' . $error->getMessage() . '</p>';
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <title>Lista de Empresas</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>  
        <link href="css/style.css" rel="stylesheet" type="text/css"/>        
    </head>
    
    <body>
        <div class="container">
            <div class="card element">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h2>Lista de Empresas</h2>
                        </div>
                        <div class="col-2 text-right">
                            <a href="form-company.php" class="btn btn-sm new" title="Novo">Novo</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    
                    <?php
                    
                        if (isset($_GET["msgSucesso"])) {
                            ?>
                            <div class="alert alert-success" role="alert">
                                <?= $_GET["msgSucesso"] ?>
                            </div>                    
                            <?php
                        }
                    
                        if (isset($_GET["msgError"])) {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $_GET["msgError"] ?>
                            </div>                    
                            <?php
                        }
                    ?>                    
                    <div class="outTable">
                        <table class="table table-bordered table-striped table-hover table-sm" cellpadding="0">

                            <thead class="thead-light">
                                <tr>
                                    <th>Razão Social</th>
                                    <th class="fantasia">Nome Fantasia</th>
                                    <th>CNPJ</th>
                                    <th>Inscrição Estadual</th>
                                    <th>Status</th>
                                    <th class="text-center">Opções</th>
                                </tr>
                            </thead>

                            <tbody>
                                
                                <?php
                                
                                    if ( $data->rowCount() > 0 ) {
                                        
                                        while ($row = $data->fetch(PDO::FETCH_OBJ) ) {
                                            ?>
                                            <tr>
                                                <td><?= $row->RazaoSocial ?></td>
                                                <td width="300"><?= $row->NomeFantasia ?></td>
                                                <td><?= ( $row->CNPJ) ?></td>
                                                <td><?= ( $row->InscEstadual) ?></td>
                                                <td><?= ( $row->StatusCadastro == 1 ? "Ativo" : "Inativo" ) ?></td>
                                                <td class="text-center">
                                                    <a href="form-company.php?action=Read&id=<?= $row->CodEmpresa ?>" class="btn btn-info btn-sm view" title="Read">Visualizar</a>
                                                    <a href="form-company.php?action=Update&id=<?= $row->CodEmpresa ?>" class="btn btn-warning btn-sm update" title="Update">Alterar</a>
                                                    <a href="delete-company.php?CodEmpresa=<?= $row->CodEmpresa ?>" class="btn btn-danger btn-sm delete" title="Delete">Excluir</a>
                                                </td>
                                            </tr>

                                            <?php
                                        }
                                        
                                
                                    } else {
                                        ?>
                                        <td colspan="5" style="color: red;">Não foi possivel listar as empresas.</td>
                                        <?php
                                    }

                                    ?>
                                            
                            </tbody>

                        </table>
                    </div>

                </div>

            </div>

        </div>

    </body>
</html>
