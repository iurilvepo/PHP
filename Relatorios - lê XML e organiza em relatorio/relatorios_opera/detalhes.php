<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<?php
session_start();
if(!isset($_SESSION['idlogin'])){
    header("Location: ../index.php");
    exit();
}

$data = date('d/m/Y H:i:s');

if (isset($_GET['arquivo'])) {
    $arquivo = basename($_GET['arquivo']); // Evita ataques de diretório
    $caminhoArquivo = "relatorios_toro/" . $arquivo; // Caminho correto

    if (file_exists($caminhoArquivo)) {
        $xml = simplexml_load_file($caminhoArquivo);
        echo "<br>";
        echo "<div class='container'>";
        echo "<table>";
        echo "<tr>";
        echo "<table><tr><td><img src='img/logojade1.png' class='img-fluid' width='60'></td>";
        echo "<td><h6><b> Jade Hotel Brasilia</b></h6><h7>Hospedes na Casa</h7></td></tr></table>";
        echo "<p style='text-align: right; font-size: 9px'> Brasilia - DF, ".$data."</p></center>";

        // Começo do grid para as tabelas lado a lado
        echo "<div class='row'>";

        // Tabela A - Quartos
        echo "<div class='col-12 col-md-6'>"; // Coluna para a tabela A
        echo "<h7>Bloco - A</h7>";
        echo "<table class='table table-striped table-hover'>";
        echo "<tr>";
        echo "<td style='font-size: 10px; padding: 0px;'><strong>Quarto</strong></td>";
        echo "<td style='font-size: 10px; padding: 0px;'><center><strong>Café</strong></center></td>";
        echo "<td style='font-size: 10px; padding: 0px;'><strong>Nome</strong></td>";
        echo "<td style='font-size: 10px; padding: 0px;'><strong>Adultos</strong></td>";
        echo "<td style='font-size: 10px; padding: 0px;'><strong>Criancas</strong></td>";
        echo "</tr>";

        foreach ($xml->LIST_G_ROOM->G_ROOM as $reserva) {
            // Substituições conforme solicitado
            if (substr($reserva->ROOM, 0, 2) === '10') {
                $reserva->ROOM = 'A' . substr($reserva->ROOM, 2);
                echo "<tr>";
                echo "<td style='font-size: 10px; padding: 0px;'>{$reserva->ROOM}</td>";
                echo "<td style='background-color:rgb(220,220,220);'></td>";
                echo "<td style='font-size: 10px; padding: 0px;'>{$reserva->GUEST_NAME}</td>";
                echo "<td style='font-size: 10px; padding: 0px;'>{$reserva->ADULTS}</td>";
                echo "<td style='font-size: 10px; padding: 0px;'>{$reserva->CHILDREN}</td>";
                echo "</tr>";
            }
        }

        echo "</table>";
        echo "</div>"; // Fim da coluna para a tabela A

        // Tabela B - Quartos "B" e "BG" na mesma tabela
        echo "<div class='col-12 col-md-6'>"; // Coluna para a tabela B
        echo "<h7>Bloco - B & Bangalo</h7>";
        echo "<table class='table table-striped table-hover'>";
        echo "<tr>";
        echo "<td style='font-size: 10px; padding: 0px;'><strong>Quarto</strong></td>";
        echo "<td style='font-size: 10px; padding: 0px;'><center><strong>Café</strong></center></td>";
        echo "<td style='font-size: 10px; padding: 0px;'><strong>Nome</strong></td>";
        echo "<td style='font-size: 10px; padding: 0px;'><strong>Adultos</strong></td>";
        echo "<td style='font-size: 10px; padding: 0px;'><strong>Criancas</strong></td>";
        echo "</tr>";

        foreach ($xml->LIST_G_ROOM->G_ROOM as $reserva) {
            // Substituições conforme solicitado para quartos "B"
            if (substr($reserva->ROOM, 0, 2) === '20') {
                $reserva->ROOM = 'B' . substr($reserva->ROOM, 2);
                echo "<tr>";
                echo "<td style='font-size: 10px; padding: 0px;'>{$reserva->ROOM}</td>";
                echo "<td style='background-color:rgb(220,220,220);'></td>";
                echo "<td style='font-size: 10px; padding: 0px;'>{$reserva->GUEST_NAME}</td>";
                echo "<td style='font-size: 10px; padding: 0px;'>{$reserva->ADULTS}</td>";
                echo "<td style='font-size: 10px; padding: 0px;'>{$reserva->CHILDREN}</td>";
                echo "</tr>";
            }
            // Substituições conforme solicitado para quartos "BG"
            elseif (substr($reserva->ROOM, 0, 2) === '30') {
                $reserva->ROOM = 'BG' . substr($reserva->ROOM, 2);
                echo "<tr>";
                echo "<td style='font-size: 10px; padding: 0px;'>{$reserva->ROOM}</td>";
                echo "<td style='background-color:rgb(220,220,220);'></td>";
                echo "<td style='font-size: 10px; padding: 0px;'>{$reserva->GUEST_NAME}</td>";
                echo "<td style='font-size: 10px; padding: 0px;'>{$reserva->ADULTS}</td>";
                echo "<td style='font-size: 10px; padding: 0px;'>{$reserva->CHILDREN}</td>";
                echo "</tr>";
            }
        }

        echo "</table>";
        echo "</div>"; // Fim da coluna para a tabela B

        echo "</div>"; // Fim do grid row

        $sumAdults = (string) $xml->SUM_ADULTS;
        $sumChildren = (string) $xml->SUM_CHILDREN;
        echo "<center><table class='table table-striped table-hover w-25 p-3' border='2'>
        <tr>
        <th style='font-size: 12px; padding: 0px;'></th>
        <th style='font-size: 12px; padding: 0px;'><strong><center>Adultos</center></strong></th>
        <th style='font-size: 12px; padding: 0px;'><strong><center>Criancas</center></strong></th>
        </tr>
        <tr>
        <td style='font-size: 12px; padding: 0px;'><strong><center>Cafe: </center></strong></td>
        <td style='font-size: 12px; padding: 0px;'> <center>{$sumAdults}</center></td>
        <td style='font-size: 12px; padding: 0px;'> <center>{$sumChildren}</center></td>
        </tr>
        <tr>
        <td style='font-size: 12px; padding: 0px;'>&nbsp;</td>
        <td style='font-size: 12px; padding: 0px;'>&nbsp;</td>
        <td style='font-size: 12px; padding: 0px;'>&nbsp;</td>
        </tr>
        </table></center>
        ";
        echo "</div>";
    } else {
        echo "<p>Arquivo não encontrado.</p>";
    }
} else {
    echo "<p>Nenhum arquivo especificado.</p>";
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
