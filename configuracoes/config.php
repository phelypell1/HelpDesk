<?php
    session_start();
    $userId = $_SESSION['userId'];
    require_once('../Connections/Conexao.php');
    $obj = new DB();
    $link = $obj->connecta_mysql();

    $query_user = "select u.idUsuario, l.Login, p.Perfil, Nome, EhAtivo,
    date_format(u.DataCadastro, '%d-%m-%Y %h:%m:%s') as dt,
    Email, c.Cargo, r.Regiao, imagem from Usuario as u
    inner join Login as l on l.idLogin = u.idLogin
    inner join Perfil as p on p.idPerfil = u.idPerfil
    inner join Cargo as c on c.idCargo = u.Cargo
    inner join Regiao as r on r.idRegiao = u.Regiao where idUsuario = $userId";

    $result = mysqli_query($link, $query_user);
    if($result == true){
        while($reg = mysqli_fetch_array($result)){
            $login = $reg['Login']; $perfil = $reg['Perfil']; $nome = $reg['Nome'];
            $ehativo = $reg['EhAtivo']; $email = $reg['Email']; $cargo = $reg['Cargo'];
            $regiao = $reg['Regiao']; $imagem = $reg['imagem']; $data = $reg['dt'];

        }
    }else{
        echo "Impossivel concluir consulta";
    }
?>
<script src="../jquery/jquery-3.4.1.js"></script>
<script>
    $(document).ready(function(){
        $('#txtCodUser').attr('readonly', true);
        $('#txtUser').attr('readonly', true);
        $('#txtEmail').attr('readonly', true);
        $('#txtCargo').attr('readonly', true);
        $('#txtRegiao').attr('readonly', true);
        $('#txtDataCadastro').attr('readonly', true);
        $('#txtLogin').attr('readonly', true);
        $('#txtPerfil').attr('readonly', true);
        $('#txtAtivo').attr('readonly', true);
        $('#btnEnviar').hide();
        $('#btnEditar').click(function(){
            $('#btnEditar').hide();
            $('#btnEnviar').show();
        })
        $('#btnCancelar').click(function(){
            $('#btnEditar').show();
            $('#btnEnviar').hide();
        });
    });
</script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<script src="/bootstrap/js/bootstrap.min.js"></script>
<div class="container">
    <div class="shadow-lg p-3 mb-5 rounded border">
        <a href="../views/home2.php">voltar</a><h4>Dados Pessoais</h4>
        <hr>
        <form id="formUsuario">
            <div class="row">
                <div class="form-group col-sm-12">
                    <img src="<?echo$imagem?>" alt="" width="40">
                </div>
                <div class="form-group col-1">
                    <label for="">Cód:</label>
                    <input type="text" name="txtCodUser" id="txtCodUser" class="form-control form-control-sm col-12" value="<?echo$userId?>">
                </div>
                <div class="form-group col-4">
                    <label for="">Usuário:</label>
                    <input type="text" name="txtUser" id="txtUser" class="form-control form-control-sm" value="<?echo$nome?>">
                </div>
                <div class="form-group col-4">
                    <label for="">E-mail:</label>
                    <input type="text" name="txtEmail" id="txtEmail" class="form-control form-control-sm" value="<?echo$email?>">
                </div>
                <div class="form-group col-2">
                    <label for="">Cargo:</label>
                    <input type="text" name="txtCargo" id="txtCargo" class="form-control form-control-sm" value="<?echo$cargo?>">
                </div>
                <div class="form-group col-2">
                    <label for="">Região:</label>
                    <input type="text" name="txtRegiao" id="txtRegiao" class="form-control form-control-sm" value="<?echo$regiao?>">
                </div>
                <div class="form-group col-3">
                    <label for="">Data Cadastro</label>
                    <input type="text" name="txtDataCadastro" id="txtDataCadastro" class="form-control form-control-sm" value="<?echo$data?>">
                </div>
                <div class="form-group col-3">
                    <label for="">Login:</label>
                    <input type="text" name="txtLogin" id="txtLogin" class="form-control form-control-sm" value="<?echo$login?>">
                </div>
                <div class="form-group col-3">
                    <label for="">Perfil:</label>
                    <input type="text" name="txtPerfil" id="txtPerfil" class="form-control form-control-sm" value="<?echo$perfil?>">
                </div>
                <div class="form-group col-2">
                    <label for="">Ativo:</label>
                    <input type="text" name="txtAtivo" id="txtAtivo" class="form-control form-control-sm" value="<?echo$ehativo?>">
                </div>
                <div class="form-group col-sm-12">
                    <button type="button" class="btn btn-sm btn-primary"id="btnEditar">Editar</button>
                    <button type="button" class="btn btn-sm btn-success"id="btnEnviar">Enviar</button>
                    <button type="button" class="btn btn-sm btn-danger"id="btnCancelar" >Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>