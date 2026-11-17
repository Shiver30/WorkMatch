<?php

session_start();

require_once "../conexao.php";
require_once "../funcoes/funcoes.php";

// ===============================
// LOGOUT
// ===============================

if (isset($_GET['logout'])) {

    logout();

    header("Location: ../index.php");
    exit;
}


verificarLogin();

// ===============================
// DADOS DO USUÁRIO
// ===============================

$nome_usuario = $_SESSION['usuario_nome'];
$id_usuario = $_SESSION['usuarios_id'];


$caminho_foto = "../imagens/padrao.png";

if ($id_usuario !== null) {

    $id_usuario = (int) $id_usuario;

    $sql = "SELECT usuario_img FROM usuarios WHERE usuarios_id = ?";

    $stmt = $conexao->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {

            $usuario = $resultado->fetch_assoc();

            if (!empty($usuario['usuario_img'])) {

                $caminho_foto = $usuario['usuario_img'];
            }
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>WorkMatch</title>

    <link rel="stylesheet" href="../css/css.css">
</head>


<body class="pagina-home">

    <header class="home-header">
        <div class="logo">WorkMatch</div>
        <a href="../index.php?logout=1" class="btn-sair">Sair</a>
    </header>

    <main class="home-main">

        <!-- USUÁRIO LOGADO -->
        <section class="usuario-area">

            <img src="<?= htmlspecialchars($caminho_foto) ?>" alt="Foto do usuário" class="foto-usuario">

            <div class="usuario-info">
                <h1>Olá, <?= htmlspecialchars($nome_usuario) ?>!</h1>
                <p>Você está logado no sistema.</p>
            </div>

        </section>

        <!-- MENU -->
        <section class="menu">

            <h2>Menu</h2>
            <a href="../cadastro/cadastro_servico.php">Cadastro de serviços</a>
            <a href="pesquisa_servico.php">Pesquisar Serviços</a>
            <a href="../chat/lista_conversas.php">Lista de conversas</a>
            <a href="perfil.php">Perfil</a>

        </section>

    </main>

    <footer class="home-footer">
        <?php require_once "../include/rodape.php"; ?>
    </footer>

</body>

</html>