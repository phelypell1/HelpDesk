<?  
    session_start();
    require_once('../Connections/Conexao.php');
    $userId = $_SESSION['userId'];
    $obj = new DB();
    $link = $obj->connecta_mysql();
    //Consulta no banco de dados Chamados abertos//
    $query1 = "select * from Chamados where prioridade = 'Urgente' and usuarioId = $userId and statusId = 1";
    $result_query1 = mysqli_query($link, $query1);
    $total = $result_query1->num_rows;
    
    //Total de Chamados;
    $query2 = "select * from Chamados where usuarioId = $userId  and statusId = 1";
    $result_query2 = mysqli_query($link, $query2);
    $totalC = $result_query2->num_rows;
    //Total de Chamados Fechados;
    $queryF = "select * from Chamados where prioridade = 'Alta' and usuarioId = $userId and statusId = 1";
    $result_queryF = mysqli_query($link, $queryF);
    $totalF = $result_queryF->num_rows;

    ///Chamados urgentes
    $queryU = "select * from Chamados where prioridade = 'Baixa' and usuarioId = $userId and statusId = 1";
    $result_queryU = mysqli_query($link, $queryU);
    $totalU = $result_queryU->num_rows;
    
?>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<body>
    <div class="container">
        <div class="shadow-sm p-4 mb-5 bg-white rounded border">
            <div class="col-sm-12">
            <button class="btn btn-light btn-sm">Voltar</button>
            </div>
            <hr>

            <div class="col-sm-12">
                <h4>Relatório Geral</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Urgentes</th>
                            <th scope="col">Alta</th>
                            <th scope="col">Baixa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="col" class=""><?echo$total?></th>
                            <th scope="col"><?echo$totalF?></th>
                            <th scope="col"><?echo$totalU?></th>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <span class="float-right">Total: <?echo$totalC?></span>
            </div>
        </div>
    </div>
</body>