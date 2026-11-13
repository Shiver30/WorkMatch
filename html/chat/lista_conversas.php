<?php
session_start();
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";
verificarLogin();

$id = $_SESSION['usuarios_id'];

$dados = listarConversas($conexao, $id);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>WorkMatch - Minhas Conversas</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- CSS principal -->
    <link rel="stylesheet" href="../css/css.css">
</head>

<body class="pagina-logada">

    <!-- Navegação lateral -->
    <?php require_once "../include/navegacao.php"; ?>

    <main class="lista-conversas-main">

        <div class="lista-conversas-container">

            <h1>Minhas Conversas</h1>

            <p class="lista-conversas-descricao">Selecione um chat para continuar conversando.</p>

            <?php if (!empty($dados)): ?>

                <div class="lista-chats">

                    <?php foreach ($dados as $chat): ?>

                        <?php
                            $nome = htmlspecialchars($chat['usuarios_nome']);
                            $id_conversa = (int) $chat['conversa_id'];
                            $id_usuario = (int) $chat['usuarios_id'];
                        ?>

                        <div class="chat-item">
                            <div class="chat-info">

                                <h3>
                                    <a href="../home/perfil.php?id=<?php echo $id_usuario; ?>"class="link-perfil"><?php echo $nome; ?></a>
                                </h3>

                            </div>

                            <a href="chat_fim.php?id_conversa=<?php echo $id_conversa; ?>"class="btn-chat">Abrir Conversa</a>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php else: ?>

                <div class="sem-resultados">
                    <p>Você ainda não iniciou nenhuma conversa.Pesquise por serviços para começar a conversar!</p>
                    <a href="../home/home.php" class="btn-chat">Pesquisar Serviços</a>
                </div>

            <?php endif; ?>
            <div class="lista-conversas-acoes">
                <a href="../home/home.php" class="btn-voltar-conversas">Voltar</a>

            </div>

        </div>

    </main>

    <footer class="lista-conversas-footer">
        <p>&copy; 2026 - WorkMatch</p>
    </footer>

</body>

</html>
