<?php
// helper simples para resolver imagem por ID sem usar banco
function imagemProdutoUrl(int $produtoId): string
{
$baseFs = __DIR__ . "/../public/uploads/produtos/";
$baseUrl = "/bolomania/public/uploads/produtos/";
foreach (['jpg','png','webp'] as $ext) {
if (file_exists($baseFs . $produtoId . '.' . $ext)) {
return $baseUrl . $produtoId . '.' . $ext;
}
}
return "/bolomania/imagem/produto_sem_foto.png";
}
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Produtos</title>
      <link rel="stylesheet" href="/bolomania/public/assets/css/style.css">

</head>
<body class="produtos-body">
<div class="header">
<div class="container header-inner">
<div>
<strong>Bolo Mania</strong>
<span class="badge">Produtos</span>

</div>
<div class="user">
Olá, <strong><?= htmlspecialchars($_SESSION['nome'] ?? 'Usuário') ?></strong>
<a class="btn btn-ghost" href="index.php?controller=auth&action=logout">Sair</a>
</div>
</div>
</div>
<div class="container grid">
<div class="card">
<h2><?= $editar ? "Editar Produto #".(int)$editar['id'] : "Cadastrar Produto" ?></h2>
<form method="post" action="index.php?controller=produto&action=salvar" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $editar ? (int)$editar['id'] : 0 ?>">
<div class="form-group">
<label>Categoria</label>
<select class="input" name="categoria_id" required>
<option value="">Selecione...</option>
<?php foreach ($categorias as $c): ?>
<option value="<?= (int)$c['id'] ?>"
<?= $editar && (int)$editar['categoria_id'] === (int)$c['id'] ? 'selected' : '' ?>>
<?= htmlspecialchars($c['nome']) ?>
</option>
<?php endforeach; ?>
</select>
</div>
<div class="form-group">
<label>Nome</label>
<input class="input" type="text" name="nome" required
value="<?= $editar ? htmlspecialchars($editar['nome']) : '' ?>">
</div>
<div class="form-group">
<label>Descrição (opcional)</label>
<textarea class="input" name="descricao" rows="3"><?= $editar ?
htmlspecialchars($editar['descricao'] ?? '') : '' ?></textarea>
</div>
<div class="form-group">
<label>Imagem do produto (opcional)</label>
<input class="input" type="file" name="imagem" accept="image/png, image/jpeg, image/webp">
<small class="muted">Formatos: JPG, PNG, WEBP (até 2MB). Salva como ID do produto.</small>
</div>
<div class="actions">
<button class="btn btn-primary" type="submit">Salvar</button>
<a class="btn" href="index.php?controller=produto&action=index">Limpar</a>
</div>
</form>
</div>
<div class="card">
<h2>Lista de Produtos</h2>
<table class="table">
<thead>
<tr>
<th>Imagem</th>
<th>ID</th>
<th>Nome</th>
<th>Categoria</th>
<th>Status</th>

<th style="width:220px;">Ações</th>
</tr>
</thead>
<tbody>
<?php foreach ($produtos as $p): ?>
<tr>
<td>
<img class="thumb" src="<?= imagemProdutoUrl((int)$p['id']) ?>" alt="produto">
</td>
<td>#<?= (int)$p['id'] ?></td>
<td><?= htmlspecialchars($p['nome']) ?></td>
<td><?= htmlspecialchars($p['categoria_nome']) ?></td>
<td>
<?= ((int)$p['ativo'] === 1) ? '<span class="tag ok">Ativo</span>' : '<span class="tag
off">Inativo</span>' ?>
</td>
<td>
<a class="btn" href="index.php?controller=produto&action=index&id=<?= (int)$p['id']
?>">Editar</a>
<?php if ((int)$p['ativo'] === 1): ?>
<a class="btn btn-danger"
href="index.php?controller=produto&action=toggle&id=<?= (int)$p['id'] ?>&ativo=0"
onclick="return confirm('Inativar este produto?')">Inativar</a>
<?php else: ?>
<a class="btn btn-success"
href="index.php?controller=produto&action=toggle&id=<?= (int)$p['id'] ?>&ativo=1">Ativar</a>
<?php endif; ?>
<a class="btn btn-danger"
href="index.php?controller=produto&action=deletar&id=<?= (int)$p['id'] ?>"
onclick="return confirm('⚠️ DELETAR permanentemente? Não há volta!')">Excluir</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</body>
</html>