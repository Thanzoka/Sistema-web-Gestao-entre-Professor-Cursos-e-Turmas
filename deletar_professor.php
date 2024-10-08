<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar professor</title>
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

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_admin.php");
    exit();
}

$professor_id = $_GET['professor_id'];

$sql = "SELECT * FROM turmas WHERE professor_codigo='$professor_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    header("Location: err.php");    
} else {
    $sql = "DELETE FROM professor WHERE codigo='$professor_id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: master.php");
    } else {
        echo "Erro ao deletar professor: " . $conn->error;
    }
}
?>
<div class="row">
    <div class="col-12 d-flex justify-content-center">
    <a href="master.php" class="btn btn-primary mb-2">Voltar</a>
</div>

</body>
</html>