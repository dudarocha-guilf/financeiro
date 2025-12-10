<?php
require_once 'config.php';
require_once 'mensagens.php';

// Se já estiver logado, redireciona para o index
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema Financeiro</title>

     <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        body {
            background: #fff5fb;
            /* rosa bem clarinho */
            font-family: "Poppins", sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 60px;
            color: #5c4066;
        }

        h1 {
            color: #c85ac7;
            font-weight: 600;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }

        .mensagem {
            width: 360px;
            margin-bottom: 15px;
            text-align: center;
        }

        form {
            width: 360px;
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        label {
            font-weight: 500;
            color: #6a4c73;
        }

        input {
            width: 100%;
            padding: 11px;
            border: 1.6px solid #e8cae9;
            border-radius: 10px;
            font-size: 14px;
            background: #fffaff;
        }

        input:focus {
            border-color: #d47ed4;
            box-shadow: 0 0 5px rgba(212, 126, 212, 0.4);
            outline: none;
        }

        button {
            background: #d47ed4;
            border: none;
            padding: 11px;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: 0.25s;
        }

        button:hover {
            background: #bf69bf;
        }

        p {
            margin-top: 18px;
            font-size: 14px;
            color: #775b80;
        }

        a {
            color: #c257c4;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Sistema Financeiro Pessoal</h1>
    <h2>Cadastro de Usuário</h2>
    
    <?php exibir_mensagem(); ?>
    
    <form action="registrar.php" method="POST">
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        
        <div>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required minlength="6">
        </div>
        
        <div>
            <label for="confirmar_senha">Confirmar Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" required minlength="6">
        </div>
        
        <div>
            <button type="submit">Cadastrar</button>
        </div>
    </form>
    
    <p>Já tem conta? <a href="login.php">Faça login aqui</a></p>
</body>
</html>