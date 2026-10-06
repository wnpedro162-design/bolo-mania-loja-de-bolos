<?php
$nome = $_SESSION['nome'] ?? 'Usuário';
$perfil = $_SESSION['perfil'] ?? 'vendedor';
?>

<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Bolo Mania - Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/bolomania/public/assets/css/style.css">
</head>

<body class="dashboard-body">

<div class="dashboard-container">

    <!-- TOPBAR -->
    <div class="topbar">

        <div style="display:flex; align-items:center; gap:10px;">
            <img src="/bolomania/imagem/logo.png" class="dashboard-logo">
            <h1 style="margin:0;">Bolo Mania</h1>
        </div>

        <div>
            Logado como <strong><?php echo htmlspecialchars($nome); ?></strong>
            (<?php echo htmlspecialchars($perfil); ?>)
            • <a href="/bolomania/index.php?controller=auth&action=logout">Sair</a>
        </div>

    </div>

    <!-- CARD -->
    <div class="card">

        <h2>Bem-vindo(a), <?php echo htmlspecialchars($nome); ?> 🍬</h2>

        <p>Escolha um módulo para continuar.</p>

        <div class="nav">
            <a href="/bolomania/index.php?controller=produto&action=index">Produtos</a>
            <a href="/bolomania/index.php?controller=entrada&action=index">Entradas</a>
            <a href="/bolomania/index.php?controller=venda&action=index">Vendas</a>
            <a href="/bolomania/index.php?controller=relatorio&action=index">Relatórios</a>
        </div>

        <div class="kpis">

            <div class="kpi">
                <div>Vendas (mês)</div>
                <div class="value">0</div>
            </div>

            <div class="kpi">
                <div>Entradas</div>
                <div class="value">0</div>
            </div>

            <div class="kpi">
                <div>Estoque baixo</div>
                <div class="value">0</div>
            </div>

            <div class="kpi">
                <div>Produtos</div>
                <div class="value">8</div>
            </div>

        </div>

    </div>

</div>

</body>
</html>