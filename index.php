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

// Buscar resumo financeiro

$sql_receitas = "SELECT SUM(valor) as total FROM transacao 
                 WHERE id_usuario = :usuario_id AND tipo = 'receita'";
$stmt_receitas = $conn->prepare($sql_receitas);
$stmt_receitas->bindParam(':usuario_id', $usuario_id);
$stmt_receitas->execute();
$total_receitas = $stmt_receitas->fetch()['total'] ?? 0;

$sql_despesas = "SELECT SUM(valor) as total FROM transacao 
                 WHERE id_usuario = :usuario_id AND tipo = 'despesa'";
$stmt_despesas = $conn->prepare($sql_despesas);
$stmt_despesas->bindParam(':usuario_id', $usuario_id);
$stmt_despesas->execute();
$total_despesas = $stmt_despesas->fetch()['total'] ?? 0;

$saldo = $total_receitas - $total_despesas;

// Buscar últimas transações
$sql_ultimas = "SELECT t.*, c.nome as categoria_nome 
                FROM transacao t 
                LEFT JOIN categoria c ON t.id_categoria = c.id_categoria 
                WHERE t.id_usuario = :usuario_id 
                ORDER BY t.data_transacao DESC, t.id_transacao DESC 
                LIMIT 5";
$stmt_ultimas = $conn->prepare($sql_ultimas);
$stmt_ultimas->bindParam(':usuario_id', $usuario_id);
$stmt_ultimas->execute();
$ultimas_transacoes = $stmt_ultimas->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt_br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index - SISTEMA FINANCEIRO</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@400;600&display=swap');

        body {
            background: #fdf6fb;
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 30px;
            color: #6a4e75;
            text-align: center;
        }

        h1 {
            text-align: center;
            font-family: "Playfair Display", serif;
            font-size: 36px;
            color: #d38cd3;
            margin-bottom: 5px;
        }

        h2 {
            text-align: center;
            margin-top: 35px;
            font-family: "Playfair Display", serif;
            color: #cc7ac9;
            font-size: 28px;
        }

        .welcome {
            text-align: center;
            margin-bottom: 15px;
            font-size: 17px;
        }

        a {
            color: #c36ac4;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 0;
            margin: 25px 0 40px 0;
        }

        nav a {
            background: #ffe8f8;
            padding: 10px 18px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(217, 165, 217, 0.3);
            transition: 0.3s;
        }

        nav a:hover {
            background: #ffdff3;
            box-shadow: 0 4px 14px rgba(200, 140, 200, 0.4);
        }

        /* CARDS */
        .cards {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .card {
            background: #ffffff;
            width: 260px;
            padding: 25px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(220, 150, 220, 0.18);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 24px rgba(210, 130, 210, 0.28);
        }

        .card h3 {
            font-family: "Playfair Display", serif;
            font-size: 22px;
            color: #c86cc8;
            margin-bottom: 8px;
        }

        .card p {
            font-size: 20px;
            font-weight: 600;
        }

        /* TABELA */
        table {
            width: 85%;
            margin: 20px auto;
            background: white;
            border-collapse: collapse;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 22px rgba(200, 150, 200, 0.15);
        }

        th {
            background: #fbe1fa;
            padding: 14px;
            color: #714c80;
            font-size: 16px;
        }

        td {
            padding: 14px;
            border-top: 1px solid #f4cbee;
        }

        tr:hover {
            background: #fff3fc;
        }

        p.center {
            text-align: center;
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

    <h2>Resumo Financeiro</h2>

    <div>
        <div>
            <h3>Receitas</h3>
            <p>R$ <?php echo number_format($total_receitas, 2, ',', '.') ?></p>
        </div>

        <div>
            <h3>Despesas</h3>
            <p>R$ <?php echo number_format($total_despesas, 2, ',', '.') ?></p>
        </div>
        <div>
            <h3>Saldo</h3>
            <p>R$ <?php echo number_format($saldo, 2, ',', '.') ?></p>
        </div>
    </div>

    <h2>Últimas Transações</h2>

    <?php if (count($ultimas_transacoes) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ultimas_transacoes as $transacao): ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($transacao['data_transacao'])); ?></td>
                        <td><?php echo htmlspecialchars($transacao['descricao']); ?></td>
                        <td><?php echo htmlspecialchars($transacao['categoria_nome'] ?? 'Sem categoria'); ?></td>
                        <td><?php echo ucfirst($transacao['tipo']); ?></td>
                        <td>R$ <?php echo number_format($transacao['valor'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><a href="transacoes_listar.php">Ver todas as transações</a></p>
    <?php else: ?>
        <p>Nenhuma transação cadastrada ainda.</p>
        <p><a href="transacoes_formulario.php">Cadastrar primeira transação</a></p>
    <?php endif; ?>
</body>

</html>