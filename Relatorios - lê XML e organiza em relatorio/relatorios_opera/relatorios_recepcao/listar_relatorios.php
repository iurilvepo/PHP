<?php
$diretorio = 'relatorios_toro/'; // Substitua pelo caminho correto

if (is_dir($diretorio)) {
    $arquivos = scandir($diretorio);
    
    echo "<h2>Relatório de Café - Toro Parrilla</h2>";
    echo "<ul>";
    
    foreach ($arquivos as $arquivo) {
        if ($arquivo !== "." && $arquivo !== "..") {
            $caminhoArquivo = $diretorio . DIRECTORY_SEPARATOR . $arquivo;
            $dataModificacao = date("d/m/Y H:i:s", filemtime($caminhoArquivo)); // Obtém a data e formata

            echo "<li>$arquivo - Data: $dataModificacao  - <a href='detalhes.php?arquivo=" . urlencode($arquivo) . "' target='_blank'><strong>Clique Aqui para Impressão!</strong></a></li>";

        }
    }
    
    echo "</ul>";
} else {
    echo "<p>Pasta não encontrada.</p>";
}
echo "<br>";
echo "<br>";
echo "<br>";
echo "<a href='javascript:history.back();' style='text-decoration: none; font-size: 16px;'><strong>⬅ Voltar</strong></a>";
?>
