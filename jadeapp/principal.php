﻿<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: index.php");
}else{ }

include('connect_app2.php');


// Função para verificar o nível de acesso
function verificarPermissao($pdo, $nomeUsuario) {
  $sql = "SELECT nivel FROM loginapp WHERE nome = :nome";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['nome' => $nomeUsuario]);
  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($usuario) {
      return $usuario['nivel'];
  } else {
      return null;
  }
}


// Exemplo de uso da função
$nomeUsuario = $_SESSION['nome'];; // Substitua pelo nome do usuário atual
$nivel = verificarPermissao($pdo, $nomeUsuario);

?>

<!DOCTYPE html">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" media="all" />

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<title>Jade</title>
<!-- ESTYLO da notificação SININHO -->
<style>
        .notification {
            position: relative;
            display: inline-block;
        }
        .notification .badge {
            position: absolute;
            top: -10px;
            right: -10px;
            padding: 2px 4px;
            border-radius: 50%;
            background: red;
            color: white;
        }
</style>
<!-- FIM da notificação SININHO -->

</head>

<body>

      <!-- script para fechar o menu lateral -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  var offcanvasLinks = document.querySelectorAll('.offcanvas-link');
  var offcanvasElement = document.getElementById('offcanvasDarkNavbar');
  var offcanvas = new bootstrap.Offcanvas(offcanvasElement);

  offcanvasLinks.forEach(function(link) {
    link.addEventListener('click', function() {
      offcanvas.hide();
    });
  });
});

</script>
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="imagens/logtransjade.png" width="60" class="rounded float-start"></a>
    <div>
    </div>
    <div>
    </div>
    <div>
    </div>
<!-- Notificação SININHO -->
    <div class="notification">
    <a href="arcondicionadoapp.php" target="conteudo"><img src="imagens/sininho1.png" alt="Notifications" width="25" height="25"></a>
    <span class="badge" id="notification-count"></span>
    </div>
<!-- FIM da notificação SININHO -->

<!-- código da notificação SININHO -->
    <script>
    function fetchNotifications() {
        fetch('fetch_notifications.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('notification-count').innerText = data.new_notifications;
            });
    }

    // Fetch notifications on page load
    window.onload = function() {
        fetchNotifications();

        // Set interval to fetch notifications every 30 seconds
        setInterval(fetchNotifications, 30000);
    };
    </script>
    <!-- FIM do código da notificação SININHO -->

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
    <div class="offcanvas-header">

<button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>

 
    <center>
          <img src="imagens/logtransjade.png" width="80px">
          <br><br>
          <h3><?php echo $_SESSION['nome'];?></h3>
          
             <?php if($_SESSION['nivel'] == 'Admin'){
              echo'ADMINISTRADOR';
            } else if($_SESSION['nivel'] == 'Gerencia'){
              echo'GERÊNCIA';
            } else if($_SESSION['nivel'] == 'Manutencao'){
              echo'MANUTENÇÃO';
            } else if($_SESSION['nivel'] == 'Recepcao'){
              echo'RECEPÇÃO';
            } else if($_SESSION['nivel'] == 'Prestador'){
              echo'PRESTADOR DE SERVIÇOS';
            } else if($_SESSION['nivel'] == 'Compras'){
              echo'COMPRAS';
            } else { echo'>> N/A <<';}?>
          
        </center>
      
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            &nbsp;
            <a class="nav-link active offcanvas-link" aria-current="page" href="inicial.php" target="conteudo">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
              <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
              <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
              </svg>&nbsp;&nbsp;&nbsp;Home</a>
          </li>

          <?php if ($nivel) { 
  
            switch ($nivel) {
              case 'Admin':
              ?>
          <li class="nav-item">
            &nbsp;
            <a class="nav-link active offcanvas-link" aria-current="page" href="usuarioapp.php" target="conteudo">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#008000" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
            </svg>&nbsp;&nbsp;&nbsp;Usuários</a>
          </li>

          <?php
            case 'Gerencia':
            case 'Manutencao':
            case 'Compras':
            ?>
          <li class="nav-item">
            &nbsp;
            <a class="nav-link active offcanvas-link" aria-current="page" href="manutencaoapp.php" target="conteudo">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#A0522D" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
            <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5m0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78zM5.048 3.967l-.087.065zm-.431.355A4.98 4.98 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8zm.344 7.646.087.065z"/>
            </svg>&nbsp;&nbsp;&nbsp;Gerar O.S.</a>
          </li>
          <li class="nav-item">
            &nbsp;
            <a class="nav-link active offcanvas-link" aria-current="page" href="camasapp.php" target="conteudo">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16">
              <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
              <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
            </svg>&nbsp;&nbsp;&nbsp;Cama Extra</a>
          </li>
          <li class="nav-item">
            &nbsp;
            <a class="nav-link active offcanvas-link" aria-current="page" href="comprasapp.php" target="conteudo">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#228B22" class="bi bi-cart-check" viewBox="0 0 16 16">
              <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
              <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg>&nbsp;&nbsp;&nbsp;Compras</a>
          </li>
          <li class="nav-item">
            &nbsp;
            <a class="nav-link active offcanvas-link" aria-current="page" href="relatoriosapp.php" target="conteudo">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#DAA520" class="bi bi-file-text-fill" viewBox="0 0 16 16">
            <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1"/>
            </svg>&nbsp;&nbsp;&nbsp;Relatórios</a>
          </li>

          <?php
            case 'Prestador':
            ?>
          <li class="nav-item">
            &nbsp;
            <a class="nav-link active offcanvas-link" aria-current="page" href="arcondicionadoapp.php" target="conteudo">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#00BFFF" class="bi bi-thermometer-snow" viewBox="0 0 16 16">
            <path d="M5 12.5a1.5 1.5 0 1 1-2-1.415V9.5a.5.5 0 0 1 1 0v1.585A1.5 1.5 0 0 1 5 12.5"/>
            <path d="M1 2.5a2.5 2.5 0 0 1 5 0v7.55a3.5 3.5 0 1 1-5 0zM3.5 1A1.5 1.5 0 0 0 2 2.5v7.987l-.167.15a2.5 2.5 0 1 0 3.333 0L5 10.486V2.5A1.5 1.5 0 0 0 3.5 1m5 1a.5.5 0 0 1 .5.5v1.293l.646-.647a.5.5 0 0 1 .708.708L9 5.207v1.927l1.669-.963.495-1.85a.5.5 0 1 1 .966.26l-.237.882 1.12-.646a.5.5 0 0 1 .5.866l-1.12.646.884.237a.5.5 0 1 1-.26.966l-1.848-.495L9.5 8l1.669.963 1.849-.495a.5.5 0 1 1 .258.966l-.883.237 1.12.646a.5.5 0 0 1-.5.866l-1.12-.646.237.883a.5.5 0 1 1-.966.258L10.67 9.83 9 8.866v1.927l1.354 1.353a.5.5 0 0 1-.708.708L9 12.207V13.5a.5.5 0 0 1-1 0v-11a.5.5 0 0 1 .5-.5"/>
            </svg>&nbsp;&nbsp;&nbsp;Ar-Condicionado</a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link active offcanvas-link" aria-current="page" href="#"></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active offcanvas-link" aria-current="page" href="#"></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active offcanvas-link" aria-current="page" href="#"></a>
          </li>
          <br>
          <br>
          <li class="nav-item">
            <a class="nav-link active offcanvas-link" aria-current="page" href="sair.php"><img src="imagens/sair.png"> &nbsp; Sair</a>
          </li>
          <?php 
            break;
          default:
          echo "&nbsp; &nbsp; <center><img src='imagens/permissao321.png' width='120px'><br>Usuário sem Permissão!</center>";
                    break;
            }

            } else {
              echo "&nbsp; &nbsp; Usuário não encontrado!";
            }
          ?>
        </ul>
      </div>
    </div>
  </div>
</nav>

<center>
<iframe id="conteudo" name="conteudo" width="95%" height="690" frameborder="0" src="inicial.php"></iframe>
</center>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
        // Função para buscar notificações não vistas
        function checkNotifications() {
            fetch('notificacoes.php')
                .then(response => response.json())
                .then(data => {
                    const notificationCount = document.getElementById('notification-count');
                    if (data.count > 0) {
                        notificationCount.textContent = data.count;
                    } else {
                        notificationCount.textContent = '';
                    }
                });
        }

        // Verificar notificações a cada 5 segundos
        setInterval(checkNotifications, 5000);

        // Verificar notificações ao carregar a página
        document.addEventListener('DOMContentLoaded', checkNotifications);
</script>

</body>

</html>