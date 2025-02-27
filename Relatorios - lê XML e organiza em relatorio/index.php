<?php
session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: ../index.php");
    exit();
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>..:: Relatórios Web ::..</title>
</head>

<body> 
<div class="container">   
<center><h5><?php echo "Olá, ".$_SESSION['nome'];?>&nbsp;&nbsp;&nbsp;

<!-- Inicio do código Saudação e data em JS-->
<script language="JavaScript" type="text/JavaScript">
 
var dataHora, xHora, xDia, dia, mes, ano, saudacao;
dataHora = new Date();
xHora = dataHora.getHours();

if (xHora >= 0 && xHora <12) {saudacao = "Bom Dia -"}
if (xHora >= 12 && xHora < 18) {saudacao = "Boa Tarde -"}
if (xHora >= 18 && xHora <= 23) {saudacao = "Boa Noite -"}

xDia = dataHora.getDay();

diaSem = new Array(7);

diaSem[0] = "Domingo";
diaSem[1] = "Segunda-feira";
diaSem[2] = "Terça-feira";
diaSem[3] = "Quarta-feira";
diaSem[4] = "Quinta-feira";
diaSem[5] = "Sexta-feira";
diaSem[6] = "Sábado";

dia = dataHora.getDate();
mes = dataHora.getMonth();

mesAno = new Array(12);

mesAno[0] = "Janeiro";
mesAno[1] = "Fevereiro";
mesAno[2] = "Março";
mesAno[3] = "Abril";
mesAno[4] = "Maio";
mesAno[5] = "Junho";
mesAno[6] = "Julho";
mesAno[7] = "Agosto";
mesAno[8] = "Setembro";
mesAno[9] = "Outubro";
mesAno[10] = "Novembro";
mesAno[11] = "Dezembro";

ano = dataHora.getFullYear();

document.write("<font face='verdana', arial' size=2 color='828282'>" + "  " + saudacao + " " + diaSem[xDia] + ", " + dia + " de " + mesAno[mes] + " de " + ano + "</font>");

</script>

<!-- Fim do código Saudação e data em JS-->
</h5>
</center>

<table class='table table-striped hover'>
  <tr>
    <td class="align-middle"><img src="../imagens/logojade1.png" width="100" /></td>
    <td class="align-middle"><h5>JADE HOTEL BRASILIA - RELATÓRIOS WEB</h5></td>
  </tr>
  <tr>
    <td colspan="2"><h6>Selecione um relatório abaixo:</h6></td>
  </tr>
</table>

  <?php 
  if($_SESSION['nome'] == "Vitral" || $_SESSION['nome'] == "Suporte"){

  echo"
  <table class='table table-striped hover'>
    <th>
      <td>RELATÓRIOS DO RAZÃO ANÁLITICO</td>
      <td>&nbsp;</td>
    </th>
    <tr>
      <td>&nbsp;</td>
      <td><img src='img/pastabase1.png' width='20'>&nbsp;<a href='parametrorazaoanalitico.php' target='_blank'>Razão Análitico</a></td>
    </tr>
  </table>";

  }
  ?>

  <table class="table table-striped hover">
  <th>
    <td>RELATÓRIOS DO RESTAURANTE</td>
    <td>&nbsp;</td>
  </th>
  <tr>
    <td>&nbsp;</td>
    <td><img src='img/pastabase1.png' width='20'>&nbsp;<a href="relatorios_opera/listar_relatorios.php">Relatório Café da Manhã</a></td>
  </tr>
</table>

<br>
<br>
<br>
<br>
<br>
<hr>
<a href="sair.php" style='text-align: right'><strong>Sair</strong></a>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>