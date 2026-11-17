<?php
session_start();
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";
verificarLogin(); // Garante que ninguém acesse sem estar logado

$meu_id = $_SESSION['usuarios_id'];


// Verifica se o ID da conversa foi passado na URL
if (!isset($_GET['id_conversa']) || empty($_GET['id_conversa'])) {
    header("Location: lista_conversas.php"); // Se não tem ID, manda de volta pra lista
    exit;
}
$id_conversa = (int)$_GET['id_conversa'];

$usuario_conversa = buscarOutroUsuarioConversa($conexao, $id_conversa, $meu_id);
// Retorna as mensagens para o JavaScript
if (isset($_GET['buscar_mensagens'])) {
    $mensagens = listarMensagens($conexao, $id_conversa);

    header('Content-Type: application/json');
    echo json_encode($mensagens);
    exit;
}


// LÓGICA DE ENVIAR MENSAGEM
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $texto_mensagem = trim($_POST['mensagem_texto']);

    if (!empty($texto_mensagem)) {
        enviarMensagem($conexao, $id_conversa, $meu_id, $texto_mensagem);

        // Redireciona para a mesma página para evitar envio duplicado ao atualizar a tela (F5)
        header("Location: chat_fim.php?id_conversa=" . $id_conversa);
        exit;
    }
}

// LÓGICA DE LISTAR MENSAGENS
$mensagens = listarMensagens($conexao, $id_conversa);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Chat - WorkMatch</title>

    <link rel="stylesheet" href="../css/css.css">
</head>

<body class="pagina-chat">

    <header>
        <div class="logo">WorkMatch - Chat</div>
        <nav><a href="lista_conversas.php">Voltar para Conversas</a></nav>
    </header>

    <main>
        <div class="chat-container">
            <div class="cabecalho-chat">
                <?php if (!empty($usuario_conversa['usuario_img'])): ?>
                    <img src="<?= htmlspecialchars($usuario_conversa['usuario_img']) ?>" alt="Foto do usuário" class="foto-chat">

                <?php else: ?>
                    <div class="foto-chat sem-foto">👤</div>
                <?php endif; ?>

                <div class="info-chat">
                    <h2><?= htmlspecialchars($usuario_conversa['usuarios_nome']) ?></h2>
                    <span>Conversa</span>
                </div>

            </div>

            <!-- EXIBIÇÃO DAS MENSAGENS -->
            <div class="area-mensagens" id="areaMensagens">

                <?php if (count($mensagens) > 0): ?>
                    <?php foreach ($mensagens as $msg): ?>

                        <!-- Verifica se a mensagem é sua ou da outra pessoa -->
                        <?php $classe_balao = ($msg['mensagem_usuarios_id'] == $meu_id) ? 'minha-mensagem' : 'outra-mensagem'; ?>

                        <div class="balao <?= $classe_balao ?>">
                            <?= htmlspecialchars($msg['mensagem_texto']) ?>
                            <!-- Formata a hora para mostrar no cantinho do balão -->
                            <span class="hora"><?= date('H:i', strtotime($msg['mensagem_hora'])) ?></span>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="mensagem-vazia">Nenhuma mensagem ainda. Envie um "Olá" para começar!</p>
                <?php endif; ?>

            </div>

            <!-- FORMULÁRIO DE DIGITAÇÃO -->
            <form class="area-envio" method="POST" action="chat_fim.php?id_conversa=<?= $id_conversa ?>">
                <!-- autofocus faz o cursor já nascer piscando no campo de texto -->
                <input type="text" name="mensagem_texto" placeholder="Digite sua mensagem... ( não suporta emogis )" required autofocus autocomplete="off">
                <button type="submit" class="btn-enviar">Enviar</button>
            </form>

        </div>
    </main>

    <!-- Script simples para garantir que a barra de rolagem desça para a última mensagem -->
    <script>
        const areaMensagens = document.getElementById('areaMensagens');
        const idConversa = <?= $id_conversa ?>;
        const meuId = <?= $meu_id ?>;

        let quantidadeMensagens = <?= count($mensagens) ?>;

        // Mantém o chat na última mensagem
        areaMensagens.scrollTop = areaMensagens.scrollHeight;

        async function atualizarMensagens() {

            try {

                const resposta = await fetch(
                    'chat_fim.php?id_conversa=' + idConversa + '&buscar_mensagens=1'
                );

                const mensagens = await resposta.json();

                // Só atualiza se a quantidade de mensagens mudou
                if (mensagens.length !== quantidadeMensagens) {

                    quantidadeMensagens = mensagens.length;

                    areaMensagens.innerHTML = '';

                    mensagens.forEach(msg => {

                        const balao = document.createElement('div');

                        balao.classList.add('balao');

                        if (parseInt(msg.mensagem_usuarios_id) === meuId) {
                            balao.classList.add('minha-mensagem');
                        } else {
                            balao.classList.add('outra-mensagem');
                        }

                        const texto = document.createTextNode(
                            msg.mensagem_texto
                        );

                        balao.appendChild(texto);

                        const hora = document.createElement('span');

                        hora.classList.add('hora');

                        const data = new Date(
                            msg.mensagem_hora.replace(' ', 'T')
                        );

                        hora.textContent =
                            data.getHours().toString().padStart(2, '0') +
                            ':' +
                            data.getMinutes().toString().padStart(2, '0');

                        balao.appendChild(hora);

                        areaMensagens.appendChild(balao);
                    });

                    // Desce para a última mensagem
                    areaMensagens.scrollTop = areaMensagens.scrollHeight;
                }

            } catch (erro) {
                console.error('Erro ao atualizar mensagens:', erro);
            }
        }

        // Verifica novas mensagens a cada 1 segundo
        setInterval(atualizarMensagens, 1000);
    </script>

</body>

</html>