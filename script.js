let jogadorAtual = 'X';

document.querySelectorAll('.celula').forEach(celula => {
    celula.onclick = () => {
        fetch('atualizar_jogo.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `posicao=${celula.getAttribute('data-posicao')}&jogador=${jogadorAtual}`})
        .then(res => res.json())
        .then(data => {
            data.grade.forEach((valor, i) => {
                document.querySelectorAll('.celula')[i].innerText = valor;});
            if (data.vencedor) alert(`Jogador ${data.vencedor} venceu!`);
            else if (data.empate) alert("Empate!");
            else jogadorAtual = data.jogadorAtual;});
    };});

function reiniciarJogo() {
    fetch('atualizar_jogo.php?reiniciar=true')
        .then(res => res.json())
        .then(data => {
            data.grade.forEach((valor, i) => {
                document.querySelectorAll('.celula')[i].innerText = valor;
            });
            jogadorAtual = 'X';
            alert("Novo jogo iniciado!");});}
