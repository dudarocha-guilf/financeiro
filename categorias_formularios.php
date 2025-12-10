<?php
require_once 'config.php';
require_once 'mensagens.php';

//verificar se o usuario esta logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location:login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'];

// Verificar se esta editando
$id_categoria = $_GET['id'] ?? null;
$categoria = null;

if ($id_categoria) {
    // Buscar categoria para editar
    $sql = "SELECT * FROM categoria WHERE id_categoria = :id_categoria AND id_usuario = :usuario_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_categoria', $id_categoria);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->execute();
    $categoria = $stmt->fetch();

    // Se não encontrou ou não pertence ao usuário, redireciona
    if (!$categoria) {
        set_mensagem('Categoria não encontrada.', 'erro');
        header('Location: categorias_listar.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias - Sistema Financeiro</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            background: #fdf6fa;
            color: #4a3b47;
            text-align: center;
        }

        h1 {
            font-size: 32px;
            margin-top: 25px;
            color: #c971a3;
            font-weight: 700;
        }

        h2 {
            font-size: 26px;
            color: #d288b8;
            margin-top: 20px;
            font-weight: 600;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 25px 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        nav a {
            text-decoration: none;
            color: #ffffff;
            background: #e8a6d4;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 500;
            transition: 0.3s;
        }

        nav a:hover {
            background: #d88abd;
        }

        form {
            background: #ffffff;
            max-width: 450px;
            margin: 30px auto;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 4px 12px rgba(199, 136, 183, 0.25);
            text-align: left;
        }

        form div {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 16px;
            color: #7d5c74;
            margin-bottom: 6px;
            font-weight: 500;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #e7c5d9;
            border-radius: 10px;
            background: #fff;
            font-size: 15px;
            outline: none;
            transition: 0.2s;
        }

        input:focus,
        select:focus {
            border-color: #d88abd;
            box-shadow: 0 0 6px rgba(216, 138, 189, 0.4);
        }

        button {
            background: #e8a6d4;
            color: #fff;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: 600;
        }

        button:hover {
            background: #d88abd;
        }

        a {
            color: #d88abd;
            font-weight: 500;
            text-decoration: none;
            transition: 0.3s;
        }

        a:hover {
            color: #b46f9e;
        }

        .topo {
            margin-top: 10px;
        }

        .topo p {
            font-size: 18px;
            color: #6e4a60;
        }

        .topo a { 
            background: none;
            color: #d88abd;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <h1>Sistema Financeiro</h1>

    <div>
        <p>Bem-Vindo, <strong><?php echo $usuario_nome ?></strong></p>
        <a href="logout.php">Sair</a>
    </div>

    <?php exibir_mensagem(); ?>

    <nav>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="categorias_listar.php">Categorias</a></li>
            <li><a href="transacoes_listar.php">Transações</a></li>
        </ul>
    </nav>

    <h2><?php echo $categoria ? 'Editar' : 'Nova'; ?> Categoria</h2>

    <form action="categorias_salvar.php" method="POST">
        <?php if ($categoria): ?>
            <input type="hidden" name="id_categoria" value="<?php echo $categoria['id_categoria']; ?>">
        <?php endif; ?>

        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome"
                value="<?php echo $categoria ? htmlspecialchars($categoria['nome']) : ''; ?>"
                required>
        </div>

        <div>
            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo" required>
                <option value="">Selecione...</option>
                <option value="receita" <?php echo ($categoria && $categoria['tipo'] === 'receita') ? 'selected' : ''; ?>>Receita</option>
                <option value="despesa" <?php echo ($categoria && $categoria['tipo'] === 'despesa') ? 'selected' : ''; ?>>Despesa</option>
            </select>
        </div>

        <div>
            <button type="submit">Salvar</button>
            <a href="categorias_listar.php">Cancelar</a>
        </div>
    </form>
</body>

</html>