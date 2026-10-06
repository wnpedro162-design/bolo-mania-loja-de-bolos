<?php

require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/categoria.php';

class ProdutoController
{
    public function index(): void
    {
        $this->check();

        $produtoModel = new Produto();
        $categoriaModel = new Categoria();

        $produtos = $produtoModel->listarComCategoria(false);

        $categorias = $categoriaModel->listarAtivas();

        $editar = null;

        if (isset($_GET['id'])) {

            $editar = $produtoModel->buscarPorId(
                (int)$_GET['id']
            );
        }

        require_once __DIR__ . '/../views/produtos.php';
    }

    public function salvar(): void
    {
        $this->check();

        $this->onlyAdmin();

        $id = (int)($_POST['id'] ?? 0);

        $categoriaId = (int)($_POST['categoria_id'] ?? 0);

        $nome = trim($_POST['nome'] ?? '');

        $descricao = trim($_POST['descricao'] ?? '');

        $descricao = $descricao === ''
            ? null
            : $descricao;

        if ($categoriaId <= 0 || $nome === '') {

            die("Dados inválidos.");
        }

        $produtoModel = new Produto();

        if ($id > 0) {

            // Atualizar produto
            $produtoModel->atualizar(
                $id,
                $categoriaId,
                $nome,
                $descricao
            );

            $this->salvarImagemDoProduto($id);

        } else {

            // Inserir produto
            $novoId = $produtoModel->inserir(
                $categoriaId,
                $nome,
                $descricao
            );

            $this->salvarImagemDoProduto($novoId);
        }

        header(
            "Location: index.php?controller=produto&action=index"
        );

        exit;
    }

    public function toggle(): void
    {
        $this->check();

        $this->onlyAdmin();

        $id = (int)($_GET['id'] ?? 0);

        $ativo = (int)($_GET['ativo'] ?? 1);

        if ($id <= 0) {

            die("ID inválido.");
        }

        $produtoModel = new Produto();

        $produtoModel->setAtivo(
            $id,
            $ativo === 1
        );

        header(
            "Location: index.php?controller=produto&action=index"
        );

        exit;
    }

    public function deletar(): void
    {
        $this->check();

        $this->onlyAdmin();

        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {

            die("ID inválido.");
        }

        $produtoModel = new Produto();

        $produtoModel->deletar($id);

        header(
            "Location: index.php?controller=produto&action=index"
        );

        exit;
    }

    // Upload da imagem do produto
    private function salvarImagemDoProduto(
        int $produtoId
    ): void
    {

        if (
            !isset($_FILES['imagem']) ||
            $_FILES['imagem']['error'] !== UPLOAD_ERR_OK
        ) {
            return;
        }

        // Limite 2MB
        if (
            ($_FILES['imagem']['size'] ?? 0)
            > 2 * 1024 * 1024
        ) {
            return;
        }

        $tmp = $_FILES['imagem']['tmp_name'];

        $mime = mime_content_type($tmp);

        $ext = match ($mime) {

            'image/jpeg' => 'jpg',

            'image/png' => 'png',

            'image/webp' => 'webp',

            default => null
        };

        if ($ext === null) {

            return;
        }

        $destDir =
            __DIR__ .
            '/../public/uploads/produtos/';

        if (!is_dir($destDir)) {

            mkdir($destDir, 0777, true);
        }

        // Remove imagens antigas
        foreach (['jpg', 'png', 'webp'] as $e) {

            $old = $destDir .
                $produtoId .
                '.' .
                $e;

            if (file_exists($old)) {

                unlink($old);
            }
        }

        $dest =
            $destDir .
            $produtoId .
            '.' .
            $ext;

        move_uploaded_file($tmp, $dest);
    }

    private function check(): void
    {
        if (!isset($_SESSION['usuario_id'])) {

            header(
                "Location: index.php?controller=auth&action=form"
            );

            exit;
        }
    }

    private function onlyAdmin(): void
    {
        if (
            ($_SESSION['perfil'] ?? '')
            !== 'admin'
        ) {

            die("Acesso negado.");
        }
    }
}