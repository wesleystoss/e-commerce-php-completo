<?php
echo "<h1>Teste de Arquivo Físico</h1>";
echo "<p>Se você está vendo esta página, arquivos físicos estão sendo servidos corretamente.</p>";
echo "<p>Data e hora: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Servidor: " . $_SERVER['SERVER_NAME'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "</p>";
echo "<p>Request URI: " . $_SERVER['REQUEST_URI'] . "</p>";
?> 