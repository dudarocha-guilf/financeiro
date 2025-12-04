<?php
require_once 'config.php';

//verificar se o usuario esta logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location:login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'];
?>

<!DOCTYPE html>
<html lang="pt_br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index - SISTEMA FINANCEIRO</title>
</head>

<body>
    <h1>Sistema Financeiro</h1>

    <div>
        <p>Bem-Vindo, <strong><?php echo $usuario_nome?></strong></p>
    </div>
</body>

</html>