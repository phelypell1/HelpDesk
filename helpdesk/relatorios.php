<?php
    require_once('../Connections/Conexao.php');
    $obj = new DB();
    $link = $obj->connecta_mysql();
    ///////////////////////////////////////////

    $query = "select idChamado, assunto, corpoMensagem, date_format(dateChamado, '%d-%m-%Y') as dat, Status
    from Chamado inner join StatusServico on statusId = idStatus";
    $result = mysqli_query($link, $query);
    if($result == False){
        echo"Vish, não estou conseguindo achar as informações, tente novamente mais tarde.";
    }else{
        if($result){
        while($registro = mysqli_fetch_array($result)){
            echo'<div class="container">
            <div class="shadow-lg p-3 mb-5 bg-white rounded border">
            <ul class="list-group list-group-flush">
            <li class="list-group-item"><span></span></li>
            </ul>
            </div>
            </div>';

        }
    }
    }
?>