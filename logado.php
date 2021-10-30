<?php

$obj_mysqli = new mysqli("127.0.0.1", "root", "", "cadastrologin");

if($obj_mysqli->connect_errno)
{
    echo "Ocorreu um erro na conexão com o banco de dados.";
    exit;
}

mysqli_set_charset($obj_mysqli, 'utf8');
$id = -1;
$nome = "";
$email = "";
$senha = "";
//Validando a existencia dos dados
if(isset($_POST["nome"]) && isset($_POST["email"]) &&isset($_POST["senha"]))
{
    if(empty($_POST["nome"]))
        $erro = "Campo nome obrigatorio";
    else
        if(empty ($_POST["email"]))
            $erro = "Campo e-mail obrigatorio";
        else{
            $id    = $_POST["id"];
            $nome  = $_POST["nome"];
            $email = $_POST["email"];
            $senha = $_POST["senha"];
            //Se o id for -1, vamos realizar o cadastro ou alteração dos dados enviados.
            if($id == -1)
            {
                $stmt = $obj_mysqli->prepare("INSERT INTO tb_login (nome,email,senha) VALUES(?,?,?)");
                $stmt->bind_param('sss', $nome, $email, $senha);
                
                if(!$stmt->execute()){
                    $erro = $stmt->error;
                }
                else{
                    header("Location:logado.php");
                    exit;
                }
            }
            
            else
            if(is_numeric($id) && $id >= 1){
                $stmt = $obj_mysqli->prepare("UPDATE tb_login SET nome =?"
                        ." email =?, senha =? WHERE id = ? ");
                $stmt->bind_param('sssi', $nome, $email, $senha, $id);
                
                if(!$stmt->execute()){
                    $erro = $stmt->error;
                }
                else{
                    header("Location:logado.php");
                    exit;
                }
                
            }
            //retorna erro.
            else{ $erro = "Número inválido";
        }
}
}

else 
    
    if(isset ($_GET["id"]) && is_numeric($_GET["id"])){
        
        $id = (int)$_GET["id"];
        
        if(isset($_GET["del"])){
            $stmt = $obj_mysqli->prepare("DELETE FROM tb_login WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            header("Location:logado.php");
            exit;
        }else{
            $stmt = $obj_mysqli->prepare("SELECT * FROM tb_login WHERE id= ?");
            
            $stmt->bind_param('i', $id);
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            $aux_query = $result->fetch_assoc();
            
            $nome = $aux_query["nome"];
            $email = $aux_query["email"];
            $senha = $aux_query["senha"];
            $stmt->close();
        }
    }
    ?>
<!-- DOCTYPE html -->
<html>
    <header>
        <title>CRUD com PHP</title>
    </header>
    <body>
        <?php
        if(isset($erro))
            echo'<div style="color:#F00">'.$erro.'</div><br/><br>';
        else
            if(isset($sucesso))
                echo '<div style="color:#00f">'.$sucesso.'</div><br><br/>';
        ?>
        <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
            Nome:<br/>
            <input type="text" name="nome" placeholder="Nome para Cadastro."
                   value="<?=$nome?>"><br/><br/>
            
             E-mail:<br/>
            <input type="email" name="email" placeholder="E-mail para Cadastro."
                   value="<?=$email?>"><br/><br/>
            
             Senha:<br/>
             <input type="password" name="senha" placeholder="senha para Cadastro."
                   value="<?=$senha?>"><br/><br/>
             <br/><br/>
             <input type="hidden" value="<?=$id?>" name="id">
             
             <button type="submit"><?=($id==1)?"Cadastrar":"Salvar"?></button>
        </form>
        <br>
        <br>
        <table width="700px" border="1" cellspacing="0">
            <tr>
                <td><strong>#</strong></td>
                <td><strong>Nome</strong></td>
                <td><strong>Email</strong></td>
                <td><strong>Senha</strong></td>
                <td><strong>#</strong></td>
                <td><strong>#</strong></td>
            </tr>
            <?php
            $result = $obj_mysqli->query("SELECT * FROM tb_login");
            while ($aux_query = $result->fetch_assoc())
            {
                echo '<tr>';
                echo '  <td>'.$aux_query["id"].'</td>';
                echo '  <td>'.$aux_query["nome"].'</td>';
                echo '  <td>'.$aux_query["email"].'</td>';
                echo '  <td>'.$aux_query["senha"].'</td>';
                echo '  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["id"].'">'.'Editar</a></td>';
                echo '<td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["id"].'&del=true>'.'Excluir</a></td>';
                echo '</tr>';
            }
            ?>
            
        </table>
             
        
        </form>
    </body>
</html>
