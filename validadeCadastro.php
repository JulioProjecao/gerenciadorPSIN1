<?php
$obj_mysqli = new mysqli("127.0.0.1", "root", "", "cadastrologin");

if($obj_mysqli->connect_errno)
{
    echo "Ocorreu um errro na conexão com o banco de dados.";
    exit;
}

mysqli_set_charset($obj_mysqli, 'utf8');

$nome = "";
$email = "";
$senha = "";

//validando a existencia dos dados
if(isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["senha"])){
    if(empty($_POST["nome"]))
             $erro ="Campo nome obrigatorio";
    else
    if(empty($_POST["email"]))
        $erro = "Campo e-mail obrigatorio";
    else
    {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        
        $stmt = $obj_mysqli->prepare("INSERT INTO tb_login(nome, email, senha) VALUES(?,?,?");
        $stmt->bind_param('sss', $nome, $email, $senha);
        
        if(!$stmt->execute()){
            $erro = $stmt->error;
        }
        
        else{
            header("Location:login.php");
        }
            
    }
} 

?>