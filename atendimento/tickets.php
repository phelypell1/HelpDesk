<?php
    session_start();
    require_once('../Connections/Conexao.php');
    $userId = $_SESSION['userId'];
    $obj = new DB();
    $link = $obj->connecta_mysql();
    //$sql = "select * from histConsulta where Status = 'Fechado' and usuarioId = $userId";
    $sql = "select idChamado, assunto, date_format(dateChamado, '%d/%m/%Y %h:%m') as dataC, Nome, Status, prioridade
    from Chamados
    inner join Usuario on IdUsuario = usuarioId
    inner join StatusServico on idStatus = statusId
    where statusId = 1 or statusId = 3 order by prioridade desc";
    $query_consult = mysqli_query($link, $sql);
    $rows = $query_consult->num_rows;
?>
<script src="../jquery/jquery-3.4.1.js"></script>
<script>
    $(document).ready(function(){
        $('#btnFechar').click(function(){
            window.location = '../views/home2.php';
        })
    })
</script>
<div class="shadow-lg p-3 mb-5 bg-white rounded border">
    <div class="form-group col">
                <br>
                <button class="btn btn-danger col-sm-1" id="btnFechar">Fechar</button>
                <button type="button" class="btn btn-success btn-sm float-right">Buscar</button>
                <input type="" name="btn-busca" id="" class="float-right form-control-sm form-control col-sm-3" placeholder="N° Ticket">
    </div>
    <!--<div class="form-group col-2">
        <select name="cbmPrioridade" id="cbmPrioridade" class="form-control form-control-sm ">
            <option value="Urgente">Urgente</option>
            <option value="Alta">Alta</option>
            <option value="Baixa">Baixa</option>
        </select>
    </div>-->
        <div class="col-sm-12">
                <table class="table table-hover table-sm" id="tbl-list">
                    <thead>
                        <tr>
                            <th width="35">ticket</th>
                            <th width="200">Assunto</th>
                            <th width="">Data resposta</th>
                            <th width="">Usuário</th>
                            <th width="">Status</th>
                            <th width="">Prioridade</th> 
                            <th width="10">Ações</th>
                        </tr>
                    </thead>
                    <?
                        if($rows <= 0){
                            $flag = 0;
                            echo'<script> valor = 0</script>';
                            echo '<p id="msg-erro">Nada por aqui. <br> Que tal tentar mais tarde =P</p>';
                            
                        }else{
                            $flag = 1;
                            while($registros = mysqli_fetch_array($query_consult)){
                                $id = $registros['idChamado'];
                                $assunto = $registros['assunto'];
                                $dataR = $registros['dataC'];
                                $nome = $registros['Nome'];
                                $status = $registros['Status'];
                                $prioridade = $registros['prioridade'];
                            echo'<tbody>';
                            echo '<tr>';
                            echo '<td>'.$id.'</td>';
                            echo '<td>'.$assunto.'</td>';
                            echo '<td>'.$dataR.'</td>';
                            echo '<td>'.$nome.'</td>';
                            echo '<td>'.$status.'</td>';
                            echo '<td id="idPrioridade">'.$prioridade.'</td>';
                            echo '<td> <a class="btn btn-primary btn-sm" href="../atendimento/atendeChamado.php?id='.$id.'">Atender</a></td>';
                            echo'</tr>';
                            echo'</tbody>';
                            }
                            
                            
                        }
                    ?>
                </table>
        </div>
</div>
<script>
    $(document).ready(function(){
        var val = "<?echo $flag?>";
        var opc;
        if(val == 0){
            $('#tbl-list').hide();
            $('#msg-erro').css({'color': 'red'});
        }else if(val == 1){
            $('#tbl-list').show();
        } 
    });
</script>