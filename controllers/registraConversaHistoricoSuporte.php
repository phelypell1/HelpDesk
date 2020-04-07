<?php
    session_start();
    require_once("../Connections/Conexao.php");
    $id_user = $_SESSION['userId'];

    $Obj = new DB();
    $link = $Obj->connecta_mysql();

    $txtId = filter_input(INPUT_GET,'id', FILTER_SANITIZE_STRING);
    $txtResposta = filter_input(INPUT_POST,'resposta', FILTER_SANITIZE_STRING);
    $cbmSituacao = filter_input(INPUT_POST,'cbmR', FILTER_SANITIZE_STRING);

if($txtResposta == ""){
        echo"Atenção preencha os campos para continuar";
        die();
    }

    $query_insert = "INSERT INTO histChamados (chamadoId, resolucao, dataResolucao, codUserId)
    values('$txtId', '$txtResposta', NOW(), '$id_user')"; 

    $queryUpdate = "update Chamados set statusId = $cbmSituacao where idChamado = $txtId";

    $result = mysqli_query($link, $query_insert);

    if($result != true){
        echo "Não foi possível atender a solicitação, tente novamente mais tarde!: ".mysqli_error($link);
    }else{
        echo 'Resposta enviado com sucesso';
        mysqli_query($link, $queryUpdate);
    }
?>