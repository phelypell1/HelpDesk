<?php
    session_start();
    require_once("../Connections/Conexao.php");
    $id_user = $_SESSION['userId'];

    $Obj = new DB();
    $link = $Obj->connecta_mysql();

    $txtAssunto = filter_input(INPUT_POST,'txtAssunto', FILTER_SANITIZE_STRING);
    $txtDescricao = filter_input(INPUT_POST, 'txtDescricao', FILTER_SANITIZE_STRING);
    $cbmPrioridade = filter_input(INPUT_POST, 'cbmPrioridade', FILTER_SANITIZE_STRING);

    if($txtAssunto == "" || $txtDescricao == "" || $cbmPrioridade == "-Selecione-"){
        echo"Atenção preencha os campos para continuar";
        die();
    }

    $query_insert = "INSERT INTO Chamados (assunto, corpoMensagem, prioridade, dateChamado, statusId, usuarioId)
    values('$txtAssunto', '$txtDescricao', '$cbmPrioridade', NOW(), '1', '$id_user')"; 

    $result = mysqli_query($link, $query_insert);

    if($result != true){
        echo "Erro ao tentar criar ticket: ".mysqli_error($link);
    }else{
        $query = "SELECT * FROM Chamados";
        $valor;
        $id = mysqli_query($link, $query);
        while($reg = mysqli_fetch_array($id)){
            $total = $reg['idChamado'];
        }
        
        echo 'Atenção! O número do seu ticket é: '.$total;

    }
?>