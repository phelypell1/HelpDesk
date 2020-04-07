<?php
session_start();
require_once('../Connections/Conexao.php');
if(!isset($_SESSION['login'])){
    header('Location: ../views/login.php?erro=1');
}
?>
<script>
        $(document).ready(function(){
        $('#btnCriar-formTicket').click(function(){
            $.ajax({
                url: '../controllers/criar-ticket.php',
                method: 'post',
                data: $('#form-ticket').serialize(),
                success:function(data) {
                    alert(data);
                    $('#textAssunto').val("");
                    $('#textDescricao').val("");
                    $('#cbmPrioridade').val('-Selecione-');
                }
            });
        });
    });
    </script>
    <script>
        $(document).ready(function(){
            $('#btnCancelar-formTicket').click(function(){
                location.reload();
            });
        });
    </script>
<div class="container-fluid" >
                <div class="shadow-lg p-3 mb-5 bg-white rounded border" id="container-formTicket">
                <h5>Novo Chamado</h5>
                    <hr>
                    <form id="form-ticket">
                    
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="txtAssunto">Assunto.:</label>
                                <input type="text" id="textAssunto" name="txtAssunto" class="form-control form-control-sm">
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="txtDescricao">Descrição.:</label>
                                <textarea name="txtDescricao" id="textDescricao" cols="5" rows="5" class="form-control form-control-sm" maxlength="250"></textarea>
                            </div>
                            <div class="form-group col-sm-12">
                                <select name="cbmPrioridade" id="cbmPrioridade" class="form-control form-control-sm col-sm-2">
                                    <option value="-Selecione-">-Selecione-</option>
                                    <option value="Urgente">Urgente</option>
                                    <option value="Alta">Alta</option>
                                    <option value="Baixa">Baixa</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <button type="button" class="btn btn-success btn-sm" id="btnCriar-formTicket">Criar ticket</button>
                                <button type="button" class="btn btn-danger btn-sm" id="btnCancelar-formTicket">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>