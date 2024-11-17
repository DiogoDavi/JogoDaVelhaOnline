<?php

session_start();

if (!isset($_SESSION['grade']) || isset($_GET['reiniciar'])) {
    $_SESSION['grade'] = array_fill(0, 9, ''); 
    $_SESSION['jogadorAtual'] = 'X'; 
    echo json_encode(['grade' => $_SESSION['grade'], 'jogadorAtual' => $_SESSION['jogadorAtual']]);
    exit;}

$posicao = $_POST['posicao'];
$jogador = $_POST['jogador'];

if ($_SESSION['grade'][$posicao] === '') {
    $_SESSION['grade'][$posicao] = $jogador;
    $_SESSION['jogadorAtual'] = $jogador === 'X' ? 'O' : 'X';}

$vencedor = verificarVencedor($_SESSION['grade']);
$empate = !in_array('', $_SESSION['grade']) && !$vencedor;

echo json_encode([
    'grade' => $_SESSION['grade'],
    'jogadorAtual' => $_SESSION['jogadorAtual'],
    'vencedor' => $vencedor,
    'empate' => $empate]);

function verificarVencedor($grade) {
    $linhas = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8], 
        [0, 3, 6], [1, 4, 7], [2, 5, 8], 
        [0, 4, 8], [2, 4, 6]       
    ];
    foreach ($linhas as $linha) {
        if ($grade[$linha[0]] !== '' &&
            $grade[$linha[0]] === $grade[$linha[1]] &&
            $grade[$linha[1]] === $grade[$linha[2]]) {
            return $grade[$linha[0]];}}
    return null;}
?>
