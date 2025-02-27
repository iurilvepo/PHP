<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: ../index.php");
}else{ }


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>..:: Parametros ::..</title>
</head>

<body>
<form action="relatoriorazaoanalitico.php" method="post">
<table width="200" border="0" align="center">
  <tr>
    <td align="center" bgcolor="#999999">Parametros - Relatório Razão Analitico</td>
  </tr>
  <tr>
    <td>Data Inicial:<br />
    <input name="datainicial" id="datainicial" type="date"  /></td>
  </tr>
  <tr>
    <td>Data Final:<br />
    <input name="datafinal" id="datafinal" type="date"  /></td>
  </tr>
  <tr>
    <td>Exercicio:<br />
   
  <select name="exercicio" id="exercicio">
    <option value="2018">2018</option>
	<option value="2019">2019</option>
	<option value="2020">2020</option>
    <option value="2021">2021</option>
    <option value="2022">2022</option>
    <option value="2023">2023</option>
    <option value="2024">2024</option>
    <option value="2024">2025</option>
  </select>
  
  </td>
  </tr>
  <tr>
    <td>Empresa:<br />
    
    <select name="empresa" id="empresa">
    <option value="2">1 - Jade Hotel (Hotel)</option>
    <option value="12">2 - Condominio Jade Hotel Home Office</option>
    <option value="13">3 - Subcondominio Jade Hotel Home Office</option>
    <option value="1">4 - Cnpj Antigo - 0002-00</option>
    
  </select></td>
  </tr>
  <tr>
    <td>
      <input type="submit" name="gerar" id="gerar" value="Gerar Relatório" />
    </td>
  </tr>
</table>

</form>

</body>
</html>