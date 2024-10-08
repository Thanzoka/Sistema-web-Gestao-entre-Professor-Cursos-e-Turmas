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
    $nome_curso = $_POST['curso'];

    $sql = "INSERT INTO cursos (curso) VALUES ('$nome_curso')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: sucesso_cursos.php");
    } else {
        echo "Erro ao cadastrar curso: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Curso</title>
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
        <h4>Cadastrar Curso</h4>
        <div class="row justify-content-end">
            <div class="col-2">            
            <a href="master.php" class="btn btn-primary mt-2">Voltar</a>
            </div>
        </div>
        <form method="post" action="cadastrar_curso_admin.php">
            <div class="mb-3">
                <label for="curso" class="form-label">Curso</label>
                <input type="text" name="curso" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Cadastrar</button>
        </form>
        
    </div>
</body>
</html>