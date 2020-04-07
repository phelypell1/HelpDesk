<?php
    session_start();
    require_once('../Connections/Conexao.php');
    $userId = $_SESSION['userId'];
    $obj = new DB();
    $link = $obj->connecta_mysql();
    //$sql = "select * from histConsulta where Status = 'Fechado' and usuarioId = $userId";
    $sql = "select idChamado, assunto, date_format(dateChamado, '%d/%m/%Y %h:%m') as dataC, Nome, Status
    from Chamados
    inner join Usuario on IdUsuario = usuarioId
    inner join StatusServico on idStatus = statusId
    where IdUsuario = $userId and statusId = 3";
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
    <br>
        <hr>
        <div class="col-sm-12">
            <div class="col-sm-12">
                <table class="table table-hover col-sm-12" id="tbl-list">
                    <thead>
                        <tr>
                            <th width="35">ticket</th>
                            <th width="200">Assunto</th>
                            <th width="">Data resposta</th>
                            <th width="">Usuário</th>
                            <th width="">Status</th>
                            <th width="10">Ações</th>
                        </tr>
                    </thead>
                    <?
                        if($rows <= 0){
                            $flag = 0;
                            echo'<script> valor = 0</script>';
                            echo '<p id="msg-erro">Não existe registros em seu nome.</p>';
                            
                        }else{
                            $flag = 1;
                            while($registros = mysqli_fetch_array($query_consult)){
                                $id = $registros['idChamado'];
                                $assunto = $registros['assunto'];
                                $dataR = $registros['dataC'];
                                $nome = $registros['Nome'];
                                $status = $registros['Status'];
                            echo'<tbody>';
                            echo '<tr>';
                            echo '<td>'.$id.'</td>';
                            echo '<td>'.$assunto.'</td>';
                            echo '<td>'.$dataR.'</td>';
                            echo '<td>'.$nome.'</td>';
                            echo '<td>'.$status.'</td>';
                            echo '<td> <a class="btn btn-primary btn-sm" href="../views/ticket-detalhes-a.php?id='.$id.'">Detalhe</a></td>';
                            echo'</tr>';
                            echo'</tbody>';
                            }
                            
                            
                        }
                    ?>
                </table>
            </div>
        </div>
</div>
<script>
    $(document).ready(function(){
        var val = "<?echo $flag?>"; 
        if(val == 0){
            $('#tbl-list').hide();
            $('#msg-erro').css({'color': 'red'});
        }else{
            $('#tbl-list').show();
        }
    });
</script>