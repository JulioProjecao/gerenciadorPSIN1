<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="ISO-8859-1">
        <title>Cadastro</title>
        
        <link rel="stylesheet" type="text/css" href="estilo.css" />
        
        <script>
          function validarCadastro(){
              var nome_cadastro = formCadastro.nome_cad.value;
              var email_cadastro = formCadastro.email_cad.value;
              var senha_cadastro = formCadastro.senha_cad.value;
              
              if(nome_cadastro === ""){
                  alert('Digite o seu nome');
                  formCadastro.nome_cad.focus();
                  return false;
                 }
                  
                  if(email_cadastro === ""){
                      alert('Informe o seu email da empresa');
                      formCadastro.email_cad.focus();
                      return false;
                  }
                  
                  if(senha_cadastro === "" || (senhaCad.length < 6 )){
                      alert('Digite uma senha entre 6 e 8 caracteres');
                      formCadastro.senha_cad.focus();
                      return false;
                  }
                  
                  document.formCadastro.submit();
              }
              
          
           </script>
    </head>
    <body>
            <div class="container">
                    <div class="content">
                <!--FORMULARIO DE CADASTRO -->
                    <div id="cadastro">
                            <form name="formCadastro" method="post" action="ValidaCadastro.php">
                                <h1>Cadastro</h1>
                                    <p>
                                        <label for="nome_cad">Seu nome</label>
                                        <input id="nome_cad" name="nome" maxlength="60"
                                               required="required" type="text" placeholder="Nome" />
                                </p>
                                
                                <p>
                                <label for="email_cad">Seu e-mail</label>
                                <input id="email_cad" name="email" maxlength="50"
                                       required="required" type="text" placeholder="ex.contato@empresa.com"/>
                                </p>
                                      
                                <p>
                                    <label for="senha_cad">Sua senha</label>
                                    <input id="senha_cad" name="senha" maxlength="8"
                                           required="required" type="password" placeholder="ex.12345678"/>
                                </p>
                                
                               
                                
                                    <p>
                                        <input type="submit" value="Cadastrar"
                                               onclick="return validarCadastro()"/>
                                </p>
                                
                                    <p class="link">
                                Ja tem conta?
                                <a href="login.php">Ir para Login</a>
                                </p>
                        </form>
                </div>
                
            </div>
        </div>

    </body>
</html>
