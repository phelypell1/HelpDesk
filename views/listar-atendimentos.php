<?php
session_start();
$idUser = $_SESSION['userId'];
require_once('../Connections/Conexao.php');
if(!isset($_SESSION['login'])){
    header('Location: ../views/login.php?erro=1');
  }
?>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../PageStyle/list-rel.css">
<script src="../jquery/jquery-3.4.1.js"></script>
<body>
<div class="shadow-lg p-3 mb-5 bg-white rounded border" id="info1">
    <a href="../views/home2.php" class="btn btn-success">Voltar</a>
    <h5>Lista de Atendimentos.</h5>
</div>
<div class="container-fluid">
    <div class="shadow-lg p-3 mb-5 bg-white rounded border" id="info1">
    <?
    require_once('../Connections/Conexao.php');
    $ObjDB = new DB();
    $link = $ObjDB->connecta_mysql();
    $maxlink = 5;
    $pagina = (isset($_GET['pagina'])) ? (int) $_GET['pagina'] : 1;
    $maximo = 3;
    $inicio = (($maximo * $pagina) - $maximo);

    $sql = "select idChamado, assunto, corpoMensagem, date_format(dateChamado, '%d-%m-%Y %h:%m:%s') as dat, Status
    from Chamados
    inner join StatusServico on statusId = idStatus where usuarioId = $idUser limit $inicio, $maximo";
    $result = mysqli_query($link, $sql);
        if ($result) {
      while ($registro = mysqli_fetch_array($result)) {
        echo '<ul class="list-group list-group-flush">
            <a href="#">
              <li class="list-group-item"><span class="badge-success badge-pill">N° '.$registro['idChamado'].'</span>
              <div class="col"><p>Descrição: </p><p class="descricao">'.$registro['corpoMensagem'].'</p></div>
              <span class="badge-primary badge-pill infos">'.$registro['dat'].'</span>
              <span class="badge-primary badge-pill infos1">'.$registro['Status'].'</span>
              </li>
            </a>
      </ul>';
      }
    }else{
        echo mysqli_error($link);
    }
    $rowst = mysqli_num_rows($result);
    ?>
    </div>
    <div class="container-fluid">
      <p class="float-right">Total: <?echo$rowst?></p>
    </div>
  <div>
    <?
    require_once('../Connections/Conexao.php');
    $ObjDB = new DB();
    $link = $ObjDB->connecta_mysql();
    $query = "select idChamado, assunto, corpoMensagem, date_format(dateChamado, '%d-%m-%Y') as dat, Status
    from Chamados
    inner join StatusServico on statusId = idStatus";
    $result_query = mysqli_query($link, $query);
    $total =  $result_query->num_rows;
    $total_pg = ceil($total/$maximo);
    if($total > $maximo){
    echo' <nav aria-label="Navegação de página exemplo" clas="col-md-10">';
    echo'<ul class="pagination justify-content-center">';
    echo'<li class="page-item">';
      echo' <a class="page-link" href="?pagina=1" tabindex="-1">Primeiro</a>';
      for($i = $pagina - $maxlink; $i <= $pagina -1; $i++){
        if($i >= 1){
          echo '<li>';
        echo' <a class="page-link" href="?pagina='.$i.'" tabindex="-1">'.$i.'</a>';
        echo'</li>';
        }
    }
    echo '<li>';
        echo' <a class="page-link" href="?pagina='.$pagina.'">'.$pagina.'</a>';
        echo'</li>';
    for($i = $pagina +1; $i <= $pagina + $maxlink; $i++){
      if($i <= $total_pg){
        echo '<li>';
        echo' <a class="page-link" href="?pagina='.$i.'" tabindex="-1">'.$i.'</a>';
        echo'</li>';
      }
    }
    echo '<li>';
    echo' <a class="page-link" href="?pagina='.$total_pg.'">Ultima</a>';
    echo'</li>';
    }
    echo'<ul>';
    echo'</ul>';
    echo'<nav>';
    echo'</nav>';
    ?>
    </div>
    </div>
</body>