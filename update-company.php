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
           "UPDATE EMPRESA 
            SET RazaoSocial = ?,
                NomeFantasia = ?,
                CNPJ = ?,
                InscEstadual = ?,
                StatusCadastro = ?
            WHERE CodEmpresa = ?"
        );
        
        $data->execute(array(
            $_POST["RazaoSocial"],
            $_POST["NomeFantasia"],
            $_POST["CNPJ"],
            $_POST["InscEstadual"],
            $_POST["StatusCadastro"],
            $_POST["CodEmpresa"]
        ));
        
        if ( $data->rowCount() > 0 ) {
            header("Location: index.php?successMsg=Empresa alterada com sucesso!");
        }else {
            header("Location: index.php?errorMsg=Falha na alteração da empresa!");
        }
        
    }catch(Exception $error) {
        echo '<p style="color: red;">ERROR: ' . $error->getMessage() . '</p>';
    }
?>