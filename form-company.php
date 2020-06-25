<?php

    $action = ( isset($_GET["action"]) ? $_GET["action"] : "Insert" );
    $subTitle  = "";

    if ( $action == "Insert" ) {
        $subTitle = "Adicionar";
    } else if ( $action == "Read" ) {
        $subTitle = "Visualizar";
    } else if ( $action == "Update" ) {
        $subTitle = "Alteração";
    } else if ( $action == "Delete" ) {
        $subTitle = "Exclusão";
    }

    if ( $action != "Insert" ) {

        require_once 'config/config.php';

        try {

            $connect = new PDO(
                DB_DRIVE . ":host=" . DB_HOST . ";port=" . DB_PORT. ";dbname=" . DB_NAME , 
                DB_USER ,
                DB_PASSWORD ,
                array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" )
            );
            $connect->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            $data = $connect->prepare("SELECT * FROM EMPRESA WHERE CodEmpresa = ?");

            $data->execute(
                array( $_GET["id"] )
            );
    

            $arrayCompanys = $data->fetch(PDO::FETCH_OBJ);

        } catch (Exception $error) {
            echo '<p style="color: red;">ERROR: ' . $error->getMessage() . '</p>';
        }
        
        
    }
    
?>

<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <title>Cadastro de Empresa</title>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        
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
                            <h2>Cadastro de Empresa - <?= $subTitle ?></h2>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="<?= $action ?>-company.php" class="form">
                        <input type="hidden" id="CodEmpresa" name="CodEmpresa" value="<?= (isset($arrayCompanys->CodEmpresa) ? $arrayCompanys->CodEmpresa : "" ) ?>" />

                        <div class="row">
                            <div class="control-group col-xs-12 col-sm-6">
                                <div class="control-label txt">
                                    <label for="tipo">Razão Social</label>
                                </div>

                                <div class="controls">
                                    <input type="text" class="form-control" id="RazaoSocial" name="RazaoSocial" placeholder="Razão Social"
                                        maxlength="50" size="50" required
                                        value="<?= (isset($arrayCompanys->RazaoSocial) ? $arrayCompanys->RazaoSocial : "" ) ?>"
                                        <?= ($action == "Read" ? "readonly" : "" ) ?> />                    
                                </div>
                            </div>

                            <div class="control-group col-xs-12 col-sm-4">
                                <div class="control-label txt">
                                    <label for="descricao">Nome Fantasia</label>
                                </div>

                                <div class="controls">
                                    <input type="text" class="form-control txt" id="NomeFantasia" name="NomeFantasia" placeholder="Nome Fantasia" 
                                        maxlength="30" size="30" required
                                        value="<?= (isset($arrayCompanys->NomeFantasia) ? $arrayCompanys->NomeFantasia : "" ) ?>"
                                        <?= ($action == "Read" ? "readonly" : "" ) ?>
                                    />
                                </div>
                            </div>
                        </div>   

                        <div class="row">
                            <div class="control-group col-12">
                                &nbsp;
                            </div>
                        </div>

                        <div class="row">
                            <div class="control-group col-xs-12 col-sm-3">
                                <div class="control-label txt">
                                    <label for="CNPJ">CNPJ</label>
                                </div>

                                <div class="controls">
                                    <input type="text" class="form-control" id="CNPJ" name="CNPJ" placeholder="CNPJ"
                                        minlength="14" maxlength="14" size="14" required
                                        value="<?= (isset($arrayCompanys->CNPJ) ? $arrayCompanys->CNPJ : "" ) ?>"
                                        <?= ($action == "Read" ? "readonly" : "" ) ?>
                                    />
                                </div>       
                            </div>

                            <div class="control-group col-xs-12 col-sm-3">
                                <div class="control-label txt">
                                    <label for="InscEstadual">Inscrição Estadual</label>
                                </div>

                                <div class="controls">
                                    <input type="text" class="form-control" id="InscEstadual" name="InscEstadual" placeholder="Inscrição Estadual" 
                                        minlength="14" maxlength="14" size="14" required
                                        value="<?= (isset($arrayCompanys->InscEstadual) ? $arrayCompanys->InscEstadual : "" ) ?>"
                                        <?= ($action == "Read" ? "readonly" : "" ) ?>
                                    />
                                </div>       
                            </div>

                            <div class="control-group col-xs-12 col-sm-6">
                                <div class="control-label txt">
                                    <label for="statusCadastro txt">Status</label>
                                </div>

                                <div class="controls">
                                    <select class="form-control" id="StatusCadastro" name="StatusCadastro" required="required">
                                        <option class="opt" value="1" <?= (isset($arrayCompanys->StatusCadastro) ? ( $arrayCompanys->StatusCadastro == 1 ? 'selected="Ativo"' : "disabled" ) : "" ) ?>>Ativo</option>
                                        <option class="opt" value="2" <?= (isset($arrayCompanys->StatusCadastro) ? ( $arrayCompanys->StatusCadastro == 2 ? 'selected="Inativo"' : "disabled" ) : "" ) ?>>Inativo</option>
                                    </select>                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="control-group col-12">
                                &nbsp;
                            </div>
                        </div>

                        <div class="row">
                            <div class="control-group col-12">
                                <a class="btn return" href="index.php">Voltar</a>
                                
                                <?php
                                if ($action != "Read") {
                                    ?>
                                    <button name="btEnviar" id="btEnviar" class="btn save" type="submit">Salvar</button>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>    
        </div>
    </body>
</html>
            