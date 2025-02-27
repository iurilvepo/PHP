<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<?php
session_start();
if(!isset($_SESSION['idlogin'])){
    header("Location: ../index.php");
    exit();
}

$diretorio = 'relatorios_toro'; // Substitua pelo caminho correto

// Obtém as datas enviadas pelo formulário (se houver)
$dataInicio = isset($_GET['data_inicio']) ? strtotime($_GET['data_inicio'] . " 00:00:00") : null;
$dataFim = isset($_GET['data_fim']) ? strtotime($_GET['data_fim'] . " 23:59:59") : null;

$arquivosArray = [];

if (is_dir($diretorio)) {
    $arquivos = scandir($diretorio);

    // Armazena os arquivos com suas datas
    foreach ($arquivos as $arquivo) {
        if ($arquivo !== "." && $arquivo !== "..") {
            $caminhoArquivo = $diretorio . DIRECTORY_SEPARATOR . $arquivo;
            $timestamp = filemtime($caminhoArquivo); // Obtém o timestamp da última modificação

            // Se um intervalo de datas foi selecionado, filtra os arquivos dentro do período
            if ($dataInicio && $dataFim) {
                if ($timestamp < $dataInicio || $timestamp > $dataFim) {
                    continue;
                }
            }

            $arquivosArray[] = [
                'nome' => $arquivo,
                'caminho' => $caminhoArquivo,
                'timestamp' => $timestamp,
                'dataFormatada' => date("d/m/Y H:i:s", $timestamp)
            ];
        }
    }

    // Ordena os arquivos pelo timestamp (do mais recente para o mais antigo)
    usort($arquivosArray, function ($a, $b) {
        return $b['timestamp'] - $a['timestamp'];
    });

    // Se não houver filtro de datas, limita a exibição a 5 arquivos mais recentes
    if (!$dataInicio || !$dataFim) {
        $arquivosArray = array_slice($arquivosArray, 0, 5);
    }
}

echo "<br>";
echo "<div class='container'>";

echo "<table class='table table-striped'>
          <tr>
          <td class='align-middle'><img src='img/logojade1.png' class='img-fluid' width='100'></td>
          <td class='align-middle'><h5><center>Relatório Café da Manhã - Toro Parrilla</center></h5></td>
          </tr>
          <tr>
          <td colspan='2'><h6>Selecione um relatório abaixo:</h6></td>
          </tr>
          </table>";

 // ** Formulário de filtro por data com botão de limpar **
echo "<form method='GET' action='' class='mb-4 d-flex align-items-center'>
<label class='me-2'><strong>Data Inicial:</strong></label>
<input type='date' name='data_inicio' class='form-control me-2' value='" . (isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '') . "'>

<label class='me-2'><strong>Data Final:</strong></label>
<input type='date' name='data_fim' class='form-control me-2' value='" . (isset($_GET['data_fim']) ? $_GET['data_fim'] : '') . "'>
&nbsp;
<button type='submit' class='btn btn-primary btn-sm'>Filtrar</button>
&nbsp;
<a href='listar_relatorios.php' class='btn btn-outline-secondary btn-sm'>Limpar</a>
</form>";

echo "<table class='table table-striped table-hover'>";
echo "<thead>
        <tr>
            <th>Relatório</th>
            <th>Data</th>
            <th>Ação</th>
        </tr>
      </thead>
      <tbody>";

// Exibe os arquivos filtrados (todos dentro do intervalo OU no máximo 5 sem filtro)
if (!empty($arquivosArray)) {
    foreach ($arquivosArray as $arquivo) {
        echo "<tr>
                <td><img src='img/relatorio.png' width='20'>&nbsp;<strong>Relatório do Café</strong></td>
                <td>{$arquivo['dataFormatada']}</td>
                <td><a href='detalhes.php?arquivo=" . urlencode($arquivo['nome']) . "' target='_blank'><strong>Clique Aqui para Impressão!</strong></a></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3' style='text-align: center; color: red;'><strong>Nenhum relatório encontrado.</strong></td></tr>";
}

echo "</tbody></table>";

echo "<br><br><br>";
echo "<a href='javascript:history.back();' style='text-decoration: none; font-size: 16px;'><strong>⬅ Voltar</strong></a> / <a href='../index.php' style='text-decoration: none; font-size: 16px;'><strong>🏠 Página Inicial</strong></a>";
echo "</div>";
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>