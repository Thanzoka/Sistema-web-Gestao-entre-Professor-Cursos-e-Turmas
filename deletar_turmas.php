<!DOCTYPE html>
<html>
<head>
    <title>Deletar Turmas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #000;
        }
    </style>
</head>
<body>
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit();
}

$professor_id = $_SESSION['professor_id'];
$turmas_id = $_GET['turmas_id'];

$sql = "SELECT * FROM atividades WHERE turmas_codigo='$turmas_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    header("Location: erro.php");    
} else {
    $sql = "DELETE FROM turmas WHERE codigo='$turmas_id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: listar_cursos.php");
    } else {
        echo "Erro ao deletar turma: " . $conn->error;
    }
}
?>
<div class="row">
    <div class="col-12 d-flex justify-content-center">
    <a href="listar_cursos.php" class="btn btn-primary mb-2">Voltar</a>
</div>

</body>
</html>