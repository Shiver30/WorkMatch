<?php
session_start();
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";
verificarLogin();

$categoria = $_POST['categoria'] ?? '';
$termo = $_POST['nome'] ?? '';
$estado_id = (int) ($_POST['estado'] ?? 0);
$cidade_id = (int) ($_POST['cidade'] ?? 0);

$servicos = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servicos = buscarUsuariosPorLocal($conexao,$categoria,$termo,$estado_id,$cidade_id);
}

// Estados e cidades para os selects
$estados = listarEstados($conexao);

$cidades = [];
$resultadoCidades = mysqli_query($conexao, "SELECT * FROM cidade ORDER BY cidade_nome");

while ($cidade = mysqli_fetch_assoc($resultadoCidades)) {
    $cidades[] = $cidade;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkMatch - Pesquisar Serviços</title>

    <link rel="stylesheet" href="../css/css.css">
</head>

<body class="pagina-logada">

    <?php require_once "../include/navegacao.php"; ?>

    <main class="pesquisar-servicos-main">

        <div class="pesquisar-servicos-container">

            <h1>Pesquisar Serviços</h1>

            <p class="descricao">
                Escolha uma categoria para encontrar serviços disponíveis.
            </p>

            <!-- FORMULÁRIO -->
            <form method="POST" class="form-pesquisa">

                <div class="campo-pesquisa">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" placeholder="Nome do serviço" value="<?= htmlspecialchars($termo) ?>">
                </div>

                <select name="categoria">
                    <option value="">Todas as categorias</option>
                    <option value="Aulas Particulares" <?= $categoria === 'Aulas Particulares' ? 'selected' : '' ?>>Aulas Particulares</option>
                    <option value="Reformas e Reparos" <?= $categoria === 'Reformas e Reparos' ? 'selected' : '' ?>>Reformas e Reparos</option>
                    <option value="Cuidados Pessoais" <?= $categoria === 'Cuidados Pessoais' ? 'selected' : '' ?>>Cuidados Pessoais</option>
                    <option value="Eventos e Entretenimento" <?= $categoria === 'Eventos e Entretenimento' ? 'selected' : '' ?>>Eventos e Entretenimento</option>
                    <option value="Serviços Domésticos" <?= $categoria === 'Serviços Domésticos' ? 'selected' : '' ?>>Serviços Domésticos</option>
                    <option value="Tecnologia e Informática" <?= $categoria === 'Tecnologia e Informática' ? 'selected' : '' ?>>Tecnologia e Informática</option>
                    <option value="Saúde e Bem-estar" <?= $categoria === 'Saúde e Bem-estar' ? 'selected' : '' ?>>Saúde e Bem-estar</option>
                    <option value="Transporte e Mudanças" <?= $categoria === 'Transporte e Mudanças' ? 'selected' : '' ?>>Transporte e Mudanças</option>
                    <option value="Consultoria e Negócios" <?= $categoria === 'Consultoria e Negócios' ? 'selected' : '' ?>>Consultoria e Negócios</option>
                    <option value="Outros Serviços" <?= $categoria === 'Outros Serviços' ? 'selected' : '' ?>>Outros Serviços</option>
                </select>

                <select name="estado" id="estado">
                    <option value="">Todos os estados</option>

                    <?php foreach ($estados as $estado): ?>
                        <option value="<?= (int) $estado['estado_id'] ?>" <?= (int) $estado['estado_id'] === $estado_id ? 'selected' : '' ?>><?= htmlspecialchars($estado['estado_nome']) ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="cidade" id="cidade">
                    <option value="">Todas as cidades</option>
                </select>

                <button type="submit" class="btn-pesquisar">
                    Pesquisar
                </button>

            </form>

            <!-- RESULTADOS -->
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                <h2 class="resultado-titulo">
                    <?php if (!empty($categoria)): ?>
                        Serviços encontrados em:
                        <?= htmlspecialchars($categoria) ?>
                    <?php elseif (!empty($termo)): ?>
                        Serviços encontrados para:
                        <?= htmlspecialchars($termo) ?>
                    <?php else: ?>
                        Todos os serviços
                    <?php endif; ?>

                </h2>

                <?php listarServicos($servicos); ?>

            <?php endif; ?>

        </div>

    </main>

    <footer class="pesquisar-servicos-footer">
        <?php require_once "../include/rodape.php"; ?>
    </footer>

    <script>
        const cidades = <?= json_encode($cidades, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

        const campoEstado = document.getElementById("estado");
        const campoCidade = document.getElementById("cidade");
        const cidadeSelecionada = <?= (int) $cidade_id ?>;

        function carregarCidades(idEstado, idSelecionada) {
            campoCidade.innerHTML = '<option value="">Todas as cidades</option>';

            if (!idEstado) {
                campoCidade.disabled = true;
                return;
            }

            cidades.forEach(function(item) {
                if (item.cidade_estado_id == idEstado) {
                    const opcao = document.createElement('option');

                    opcao.value = item.cidade_id;
                    opcao.textContent = item.cidade_nome;

                    if (idSelecionada && item.cidade_id == idSelecionada) {
                        opcao.selected = true;
                    }

                    campoCidade.appendChild(opcao);
                }
            });

            campoCidade.disabled = false;
        }

        campoEstado.addEventListener("change", function() {
            carregarCidades(this.value, 0);
        });

        // Restaura as cidades depois de pesquisar
        carregarCidades(campoEstado.value, cidadeSelecionada);
    </script>

</body>

</html>