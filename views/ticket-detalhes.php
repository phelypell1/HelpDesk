<?php
    require_once('../Connections/Conexao.php');
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $obj = new DB;
    $link = $obj->connecta_mysql();
    $query = "select idHistorico, chamadoId, resolucao, dataResolucao, nome from histChamados
    inner join Usuario on IdUsuario = codUserId where chamadoId = $id";
    $result = mysqli_query($link, $query);
    
?>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<script src="../jquery/jquery-3.4.1.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#btnVoltar').click(function(){
            window.location = '../views/home2.php?st=1';
        })
    });
</script>
<body>
    <div class="container-fluid">
        <div class="shadow-lg p-3 mb-5 rounded border">
            <nav class="navbar navbar bg-transparent">
                <button type="button" class="btn btn-e" id="btnVoltar"><img src="../imagens/back.png" width="25" alt=""> Voltar</button>
            </nav>
            <hr>
            <div class="">
                <h4 class="">Historico de conversa</h4>
                <hr>
                    <div class="list-group">
                        <?
                            if($result){
                                while($registro = mysqli_fetch_array($result)){
                                    $Atendente = $registro['nome'];
                                    $resposta = $registro['resolucao'];
                                    $dataR = $registro['dataResolucao'];
                                    $cliente= $registro['nome'];
                                    echo'
                                    <a href="" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <small>Usuário: '.$Atendente.'</small>
                                    <p class="p-2 mb-1">Mensagem: '.$resposta.'</p>
                                    <small>data: '.$dataR.'</small>
                                    </a>
                                    ';
                                }
                            }
                        ?>
                    </div>
            </div>
        </div>
    </div>
</body>