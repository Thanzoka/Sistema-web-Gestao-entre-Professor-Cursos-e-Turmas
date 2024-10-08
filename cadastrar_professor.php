<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_admin.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$sql_usuario = "SELECT nome FROM usuario WHERE codigo='$usuario_id'";
$result_usuario = $conn->query($sql_usuario);
$usuario_nome = $result_usuario->fetch_assoc()['nome'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_professor = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $usuario_id = $_SESSION['usuario_id'];
    $usuario_nome = $_SESSION['nome'];

    $sql = "INSERT INTO professor (nome, email, senha, usuario_codigo) VALUES ('$nome_professor', '$email', '$senha', '$usuario_id')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: sucess.php");
    } else {
        echo "Erro ao cadastrar professor: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar professor(a)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #000;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-custom">
        <div class="container-fluid">
        <span class="navbar-brand mb-0 h1 text-white">Bem-vindo(a), admin <a style="text-decoration: none; color:#87CEFA" href="master.php"> <?php echo $usuario_nome; ?>  </a></span>
            <a href="logout.php" class="btn btn-danger">Sair</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h4>Cadastrar professor(a)</h4>
        <div class="row justify-content-end">
            <div class="col-2">            
            <a href="master.php" class="btn btn-primary mt-2">Voltar</a>
            </div>
        </div>
        <form method="post" action="cadastrar_professor.php">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" required>
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Cadastrar</button>
        </form>
        
    </div>
</body>
</html>