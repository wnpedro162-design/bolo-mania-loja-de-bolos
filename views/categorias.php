<?php
$nomeUser = $_SESSION['nome'] ?? 'Usuário';
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Categorias</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/bolomania/public/assets/src/style.css">
</head>
<body>
<div class="container">
<div class="topbar">
<div class="brand">
<div class="badge"></div>
<div>
<h1>Categorias</h1>
<small>CRUD (admin)</small>
</div>
</div>
<div class="pill">
Olá, <strong><?= htmlspecialchars($nomeUser) ?></strong>
• <a href="/bolomania/index.php?controller=auth&action=logout">Sair</a>
</div>
</div>
<div class="grid" style="grid-template-columns: 1fr 2fr;">
<div class="card">
<h2><?= $editar ? "Editar Categoria #".(int)$editar['id'] : "Nova Categoria" ?></h2>
<form method="post" action="index.php?controller=categoria&action=salvar">
<input type="hidden" name="id" value="<?= $editar ? (int)$editar['id'] : 0 ?>">
<label>Nome</label>
<input class="input" type="text" name="nome" required
value="<?= $editar ? htmlspecialchars($editar['nome']) : '' ?>">
<div class="actions" style="margin-top:14px; display:flex; gap:10px;">
<button class="btn btn-primary" type="submit">Salvar</button>
<a class="btn" href="index.php?controller=categoria&action=index">Limpar</a>
</div>
</form>
<p class="muted" style="margin-top:12px; font-size:13px;">
Regra tradicional: categoria não é apagada. Se não usar, apenas <strong>inativa</strong>.
</p>
</div>
<div class="card">
<h2>Lista</h2>
<table class="table">
<thead>
<tr>
<th>ID</th>
<th>Nome</th>
<th>Status</th>
<th style="width:260px;">Ações</th>
</tr>
</thead>
<tbody>
<?php foreach ($categorias as $c): ?>
<tr>
<td>#<?= (int)$c['id'] ?></td>
<td><?= htmlspecialchars($c['nome']) ?></td>
<td>
<?= ((int)$c['ativo'] === 1)
? '<span class="tag ok">Ativa</span>'
: '<span class="tag off">Inativa</span>' ?>
</td>
<td>
<a class="btn" href="index.php?controller=categoria&action=index&id=<?= (int)$c['id']
?>">Editar</a>
<?php if ((int)$c['ativo'] === 1): ?>
<a class="btn btn-danger"
href="index.php?controller=categoria&action=toggle&id=<?= (int)$c['id'] ?>&ativo=0"
onclick="return confirm('Inativar esta categoria?')">Inativar</a>
<?php else: ?>
<a class="btn btn-success"
href="index.php?controller=categoria&action=toggle&id=<?= (int)$c['id']
?>&ativo=1">Ativar</a>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div style="margin-top:14px;">
<a class="btn" href="/bolomania/index.php?controller=auth&action=dashboard">Voltar ao
Dashboard</a>
</div>
</div>
</div>
</div>
</body>
</html>