<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar atividades</title>
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

$atividades_id = $_GET['atividades_id'];



if ($result->num_rows > 0) {
    header("Location: erro_atividades.php");    
} else {
    $sql = "DELETE FROM atividades WHERE codigo='$atividades_id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: listar_cursos.php");
    } else {
        echo "Erro ao deletar turma: " . $conn->error;
    }
}
?>
<div class="row">
    <div class="col-12 d-flex justify-content-center">
    <a href="listar_atividades.php" class="btn btn-primary mb-2">Voltar</a>
</div>

</body>
</html>