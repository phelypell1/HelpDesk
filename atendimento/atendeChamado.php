<?php
    require_once('../Connections/Conexao.php');
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $obj = new DB;
    $link = $obj->connecta_mysql();
    $query = "select idChamado, assunto, corpoMensagem, date_format(dateChamado, '%d-%m-%Y %h:%m:%s') as dateC,
    Nome from Chamados
    inner join Usuario on IdUsuario = usuarioId where idChamado = $id";
    $result = mysqli_query($link, $query);
    $rows = $result->num_rows;
    if($result){
        while($registro = mysqli_fetch_array($result)){
            $idtic = $registro['idChamado'];
            $resposta = $registro['corpoMensagem'];
            $dataR = $registro['dateC'];
            $cliente= $registro['Nome'];
        }
    }
    
?>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<script src="../jquery/jquery-3.4.1.js"></script>
<!-- Esse script abaixo configura a ação do button-->
<script type="text/javascript">
    $(document).ready(function(){
        var linhas = "<?echo$rows?>";
        $('#formResposta').hide();
        if(linhas > 0){
        $('#btnVoltar').click(function(){
            window.location = '../views/home2.php?at=3';
        })
        $('#btnResponder').click(function(){
            $('#btnResponder').hide();
            $('#formResposta').show();
        });
        $('#btnCancelar').click(function(){
            $('#btnResponder').show();
            $('#formResposta').hide();
        });
        }
        else{
            $('#btnResponder').hide();
            $('#btnVoltar').click(function(){
            window.location = '../views/home2.php?at=3';
        })
        }
        
    });
</script><!--Termino da configuração-->
<!--Script para enviar informações para adicionar ao histChamado-->
<script>
    $(document).ready(function(){
        var idT = "<?echo$id?>";
        $('#btnEnviar').click(function(){
            $.ajax({
                url: '../controllers/registraConversaHistoricoSuporte.php?id=<?echo$id?>',
                method: 'post',
                //data: $('#formResposta').serialize(),
                data: {resposta: $('#txtResposta').val(), cbmR: $("#cbmSituacao").val()},
                success:function(data){
                    alert(data);
                    $('#formResposta').hide();
                    $('#btnResponder').show();
                    location.reload();
                }
            });
        })
    })
</script>
<body>
    <div class="container-fluid">
        <div class="shadow-lg p-3 mb-5 rounded border">
            <nav class="navbar navbar bg-transparent">
                <button type="button" class="btn btn-e" id="btnVoltar"><img src="../imagens/back.png" width="25" alt=""> Voltar</button>
            </nav>
            <hr>
            <div class="">
                <h4 class="">Atendimento</h4>
                <hr>
                    <div class="list-group">
                        <li class="list-group-item"><p>Ticket: <?echo$idtic?></p>
                            Descrição problema: <?echo$resposta?><br>
                            <small>Solicitante: <?echo$cliente?></small><br><small>Data: <?echo$dataR?></small>    
                            </li>
                            <?
                            $queryHist = "select idHistorico, chamadoId, resolucao, date_format(dataResolucao, '%d-%m-%Y %h:%m:%s') as dataR,
                            Nome from histChamados
                            inner join Usuario on IdUsuario = codUserId where chamadoId = $id";
                            $result_queryH = mysqli_query($link, $queryHist);
                            if($result_queryH == false){
                                echo '<p> Atenção, não existe resposta.</p>';
                            }else{
                                while($reg = mysqli_fetch_array($result_queryH)){
                                    echo'
                                    <li class="list-group-item">Resposta: '.$reg['resolucao'].'
                                    <br><small>Usuário: '.$reg['Nome'].'<br></small><small>Data: '.$reg['dataR'].'</small></li>
                                    ';
                                }
                            }
                        ?>
                    </div>
                    <hr>
                    <div class="mb-5 p-1">
                    <button class="btn btn-sm btn-success float-right mb-3" id="btnResponder">Responder</button>
                    </div>
                    <div id="formResposta">
                        <form id="#">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="">Resposta:</label>
                                    <textarea class="form-control " name="txtResposta" id="txtResposta" cols="30" rows="3"></textarea>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="txtIdChamado">Situação Chamado:</label>
                                    <select name="cbmSituacao" id="cbmSituacao" class="form-control form-control-sm col-sm-2">
                                        <option value="2">Fechado</option>
                                        <option value="3">Aguardando Resposta</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-2">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnEnviar">Enviar <img src="../imagens/enviar.png" width="20" alt=""></button>
                                    <button type="button" class="btn btn-danger btn-sm" id="btnCancelar">Cancelar</button>
                                </div>  
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</body>