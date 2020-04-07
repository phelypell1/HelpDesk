<?php
    session_start();
    require_once('../Connections/Conexao.php');
    $st = isset($_GET['st']) ? $_GET['st'] : 0;
    $ar = isset($_GET['at']) ? $_GET['at'] : 0;
    $Obj = new DB();
    $link = $Obj->connecta_mysql();
    $nomeUser = $_SESSION['login'];
    $userId = $_SESSION['userId'];
    $perfil = $_SESSION['userperfil'];
    if (!isset($_SESSION['login'])) {
        header('Location: ../views/login.php?erro=1');
    }
    //Consulta no banco de dados Chamados abertos//
    $query1 = "select * from Chamados where statusId = 1 and usuarioId = $userId";
    $result_query1 = mysqli_query($link, $query1);
    $total = $result_query1->num_rows;

    $queryT = "select * from Chamados where statusId = 1 or statusId = 3";
    $result_queryT = mysqli_query($link, $queryT);
    $totalT = $result_queryT->num_rows;
    
    //Total de Chamados;
    $query2 = "select * from Chamados where usuarioId = $userId ";
    $result_query2 = mysqli_query($link, $query2);
    $totalC = $result_query2->num_rows;
    //Total de Chamados Fechados;
    $queryF = "select * from Chamados where statusId = 2 and usuarioId = $userId";
    $result_queryF = mysqli_query($link, $queryF);
    $totalF = $result_queryF->num_rows;

    ///Chamados urgentes
    $queryU = "select * from Chamados where statusId = 1 and usuarioId = $userId";
    $result_queryU = mysqli_query($link, $queryU);
    $totalU = $result_queryU->num_rows;
    ///Chamados Alta
    $queryA = "select * from Chamados where statusId = 2 and usuarioId = $userId";
    $result_queryA = mysqli_query($link, $queryA);
    $totalA = $result_queryA->num_rows;
    ///Chamados Baixa
    $queryB = "select * from Chamados where statusId = 3 and usuarioId = $userId";
    $result_queryB = mysqli_query($link, $queryB);
    $totalB = $result_queryB->num_rows;

    $date = date('Y-m-d');
    $queryAbertos = "select * from Chamados where dateChamado like '%$date%' and statusId = 1";
    $abertos = mysqli_query($link, $queryAbertos);
    $ab = $abertos->num_rows;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../PageStyle/style2.css">
    <link rel="stylesheet" href="../PageStyle/home.css">
    <!-- Font Awesome JS -->
    <script src="../jquery/jquery-3.4.1.js"></script>
    <!--Essa parte carrega as informações com base no perfil do Usuario-->
    <script>
        $(document).ready(function(){
            var valorPerfil = "<?php echo$perfil?>"
            if(valorPerfil == 'Operador'){
                $("#form-chamado").hide();
                $('#infoSuporte').hide();
                $('#SubMenuTicketGeral').hide();
                $('#SubMenuTicketS').hide();
                $('#SubMenuTicketF').hide();
            $("#new-ticket").click(function(){
                $.ajax({
                url: '../views/new_ticket.php',
                success:function(data) {
                $("#form-chamado").html(data).show();
                $("#info1").hide();
                $("#info2").hide();
                $("#List-Chamado-finalizado").hide();
                }
            });
            });
            $("#tickets-closed").click(function(){
                $.ajax({
                url: '../views/tickets-finalizados.php',
                success:function(data) {
                $("#List-Chamado-finalizado").html(data).show();
                $("#info1").hide();
                $("#info2").hide();
                $("#form-chamado").hide();
                $('#List-Chamados-abertos').hide();
                $('#list-Chamado-abertos').hide();
                }
            });
            });
            $("#tickets-open").click(function(){
                $.ajax({
                url: '../views/tickets-Abertos.php',
                success:function(data) {
                $("#list-Chamado-abertos").html(data).show();
                $("#info1").hide();
                $("#info2").hide();
                $("#form-chamado").hide();
                $("#List-Chamado-finalizado").hide();
                }
            });
            });
            $("#btnContatos").click(function(){
                $.ajax({
                url: '../views/contatos.php',
                success:function(data) {
                $("#list-Chamado-abertos").html(data).show();
                $("#info1").hide();
                $("#info2").hide();
                $("#form-chamado").hide();
                $("#List-Chamado-finalizado").hide();
                }
            });
            });
            }else if(valorPerfil == 'Suporte'){
                $("#info1").hide();
                $("#info2").hide();
                $('#SubMenuNewTicket').hide();
                $('#SubMenuTicketClosed').hide();
                $('#SubMenuTicketOpen').hide();

                $('#ticketsAtender').click(function(){
                    $('#infoSuporte').hide();
                    $.ajax({
                    url: '../atendimento/tickets.php',
                    success:function(data) {
                    $("#list-Atendimentos").html(data).show();
                }
            });
            })
            }
        })
    </script>
<!-- Essa parte do scrit funciona da seguinte forma: quando usuaário clicar no voltar lá da view ticket-finalizado, ele retornará um get via url, atrás dessa get ele irá listar a view correta-->
    <script>
        $(document).ready(function(){
            //$("#List-Chamado-finalizado").hide();
            var sts = "<?echo $st?>";
            var at = "<?echo $ar?>"
            if(sts == '1')
                $.ajax({
                url: '../views/tickets-finalizados.php',
                success:function(data) {
                $("#List-Chamado-finalizado").html(data).show();
                $("#info1").hide();
                $("#info2").hide();
                $("#form-chamado").hide();
                $('#list-Chamado-abertos').hide();
                }
            })
            else if(sts == '2'){
                $.ajax({
                url: '../views/tickets-Abertos.php',
                success:function(data) {
                $("#list-Chamado-abertos").html(data).show();
                $("#info1").hide();
                $("#info2").hide();
                $("#form-chamado").hide();
                $('#list-Chamado-finalizado').hide();
                }
            })
            }else if(at == '3'){
                $.ajax({
                url: '../atendimento/tickets.php',
                success:function(data) {
                $("#infoSuporte").hide();
                $("#list-Atendimentos").html(data).show();
                
                }
            })
            }
            
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
            </div>
            <div class="img-user">
                <?
                if($_SESSION['imagem'] == NULL){
                    echo'<span class="span"><img class="span" src="../imagens/user.png" width="60"></span>';
                }else{
                    echo'<span class="span"><img class="span" src="'.$_SESSION['imagem'].'" width="38"></span>';
                }
                ?>
            </div>
            <div>
                <p class="col"><span class="sp-nome"><?echo$nomeUser?></span></p>
                <p class="col tx"><span class="tx"><?echo$perfil?></span></p>
            </div>
            <hr>
            <ul class="list-unstyled components">
                <li class="active">
                    <a href="../views/home2.php"><img src="../imagens/home.png" width="30" alt=""><span> Home</span></a>
                </li>
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><img src="../imagens/ticket.png" width="30" alt=""> Tickets</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li id="SubMenuNewTicket">
                            <a href="#" id="new-ticket"> Novo ticket</a>
                        </li>
                        <li id="SubMenuTicketClosed">
                            <a href="#" id="tickets-closed" >Tickets Finalizados</a>
                        </li>
                        <li id="SubMenuTicketOpen">
                            <a href="#" id="tickets-open">Tickets em Aberto</a>
                        </li>
                        <li id="SubMenuTicketGeral">
                            <a href="#" id="ticketsAtender">Tickets</a>
                        </li>
                        <li id="SubMenuTicketF">
                            <a href="#" id="ticketsAtender">Tickes em Finalizados</a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><img src="../imagens/relatorio.png" width="30" alt=""> Relatórios</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="../relatorios/relatoriogeral.php">Atendimentos</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" id="btnContatos"><img src="../imagens/contatos.png" width="30" alt=""> Contatos</a>
                </li>
                <li>
                    <a href="../views/logoutHome.php"><img src="../imagens/logout2.png" width="25" alt=""><span> Sair</span></a>
                </li>
            </ul>
            <div class="row">
                <div class="col-sm-12">
                <a class="float-lefts" href="../configuracoes/config.php"><img src="../imagens/conf.png" width="20" alt=""></a>
                </div>
            </div>
        </nav>
        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <span>Dashboard</span>
                        </ul>
                    </div>
                </div>
                
            </nav>
            <div class="row">
            <div class="col-sm-6">
                <div class="container">
                    <div class="shadow-lg p-3 mb-5 bg-white rounded border" id="info1">
                        <h6>Status Atendimentos:</h6>
                        <hr>
                        <p class="p">Chamados Abertos:<span class="badge  badge-warning float-right"><?echo$totalU?></span></p>
                        <p class="p"> Chamados Atendidos:<span class="badge badge-warning float-right"><?echo$totalA?></span></p>
                        <p class="p"> Aguardando resposta:<span class="badge badge-warning float-right"><?echo$totalB?></span></p>
                        <hr>
                        <p class="p">Total Chamados:<span class="badge badge-success float-right"><?echo$totalC?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="container">
                    <div class="shadow-lg p-3 mb-5 bg-white rounded border" id="info2">
                        <h6>Status atendimentos:</h6>
                        <hr>
                        <p class="p">Atendimentos fora do prazo:</p>
                        <p class="p">Atendimentos dentro do prazo:</p>
                        <hr>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="container">
                    <div class="shadow-lg p-3 mb-5 bg-white rounded border" id="infoSuporte">
                        <h6>Tickets Atendimentos</h6>
                        <hr>
                        <p class="p">Novos tickets: <a href=""><span class="badge badge-success float-right"><?echo$ab?></a></p>
                        <p class="p">Tickets em aberto: <a href=""><span class="badge badge-success float-right"><?echo$totalT?></a></p>
                        <hr>
                    </div>
                </div>
            </div>

            <!--Div para portar o formulario de novo chamado-->
            <div class="container-fluid">
                <div id="form-chamado">
                </div>
            </div>
            <!--Div para portar lista de chamados já finalizados-->
                <div class="container" id="List-Chamado-finalizado">
                </div>
                <div class="container" id="list-Chamado-abertos">
                </div>
                <div class="container" id="divContato">
                </div>
            </div>
            <div id="Relatorio-1"></div>
            <div id="list-Atendimentos"></div>
        </div>
    </div>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });
            
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'true');
            });
        });
    </script>
</body>
</html>