<?php

//cria um arquivo de log dentro da pasta LOG no formato em txt, com informações das ações feitas!
$fp = fopen("logs/add-ValoresAgua-".date('d-m-Y').".txt", "a");
$quebra = chr(13).chr(10);
$escreve = fwrite($fp, "Valores Atualização as - ".date('H:i:s')." _ ".date('d-m-Y').$query.$quebra);


?>
