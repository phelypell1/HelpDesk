<?php
    $erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../PageStyle/estilo.css">
    <link rel="stylesheet" href="../Controllers/">
    <title>HelpDesk</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="main.js"></script>
    <script>
        $(document).ready(function(){
            $('#btn_acesso').click(function(){
                var campo_vazio = false
                if($('#campo_login').val() == ''){
                    $('#campo_login').css({'border-color': '#A94442'});
                    campo_vazio = true;
                }
                if($('#campo_pass').val()== ''){
                    $('#campo_pass').css({'border-color': '#A94442'});
                    campo_vazio = true;
                }
                if(campo_vazio) return false;
            });
        });
    </script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4 login">
                <form action="../controllers/autentica_login.php" method="post">
                    <div class="form-row form">
                        <div class="form-group col-md-12">
                            <label for="" class="position-inputs">Usuário</label>
                            <input type="text" class="form-controls" name="login" id="campo_login">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="" class="position-inputs">Senha</label>
                            <input type="password" class="form-controls" name="senha" id="campo_pass">
                        </div>
                        <button type="submit" class="btn btn-danger btn-lg btn-block col-md-12" id="btn_acesso">Entrar</button>
                        </div>
                        <?php
                        if($erro == 1){
                            echo '<font color="FF0000" style="text-align:center">Usuário ou senha inválidos</font>';
                        }
                        ?>
                    <p class="">Não possui acesso ? Solicite ao CPD nesse <a href="../Views/page-solicita-acesso.php">link</a></p>
                </form>
                
            </div>
            <div class="col-md-8"></div>
        </div>
    </div>
</body>
</html>