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
           "INSERT INTO EMPRESA(razaoSocial, nomeFantasia, CNPJ, inscEstadual, statusCadastro)
            VALUES (?, ?, ?, ?, ?)"
        );
                                
        $data->execute(array(
            $_POST["RazaoSocial"],
            $_POST["NomeFantasia"],
            $_POST["CNPJ"],
            $_POST["InscEstadual"],
            $_POST["StatusCadastro"]
        ));
        
        if($connect->lastInsertId() > 0 ) {
            header("Location: index.php?successMsg=Empresa inserida com sucesso!");
        }else {
            header("Location: index.php?errorMsg=Falha na inserção da empresa!");
        }

    }catch(Exception $error) {
        echo '<p style="color: red;">ERROR: ' . $error->getMessage() . '</p>';
    }
?>
   