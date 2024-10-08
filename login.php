<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM professor WHERE email='$email' AND senha='$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $professor = $result->fetch_assoc();
        $_SESSION['professor_id'] = $professor['codigo'];
        $_SESSION['professor_nome'] = $professor['nome'];
        header("Location: listar_cursos.php");
    } else {
        header("Location: index.php");
    }
}
?>