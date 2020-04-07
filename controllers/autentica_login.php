<?php
    //sempre iniciar o session;
    session_start();
    require_once('../Connections/Conexao.php');
    $usuario = $_POST['login'];
    $passwords = $_POST['senha'];

    $ObjDB = new DB();
    $link = $ObjDB -> connecta_mysql();

      //$sql = "select idLogin, login, email, ehAtivo, nivel_acesso from logins where login='$usuario'  and pass='$passwords' and ehAtivo = '1'";
    $sql = "select L.IdLogin, L.Login, L.Senha, U.IdUsuario, U.Nome, U.Email, U.Cargo, U.Imagem, P.Perfil, U.EhAtivo from Login AS L INNER JOIN ";
    $sql.= " Usuario AS U ON U.IdLogin = L.IdLogin INNER JOIN Perfil AS P ON P.IdPerfil = U.IdPerfil WHERE L.Login ='$usuario' AND ";
    $sql.=" L.Senha ='$passwords' AND U.EhAtivo = 1";     
    $result = mysqli_query($link, $sql);

    if($result){
        $dados = mysqli_fetch_array($result);
        if(isset($dados['Login'])){

            $_SESSION['userId'] = $dados['IdUsuario'];
            $_SESSION['id'] = $dados['IdLogin'];
            $_SESSION['login']  = $dados['Login'];
            $_SESSION['username'] = $dados['Nome'];
            $_SESSION['useremail'] = $dados['Email'];
            $_SESSION['EhAtivo'] = $dados['EhAtivo'];
            $_SESSION['userperfil']  = $dados['Perfil'];
            $_SESSION['imagem'] = $dados['Imagem'];

            
             //header('location: ../Views/home.php');
            if($_SESSION['EhAtivo'] == '1'){
            header('location: ../views/home2.php');
            }
        }else{
            header('location: ../views/login.php?erro=1');
    }
    }else{
        echo 'ERROR ! <br>'.mysqli_error($link);
    }
?>