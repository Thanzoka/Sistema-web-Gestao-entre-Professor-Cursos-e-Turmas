<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE email='$email' AND senha='$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $_SESSION['usuario_id'] = $usuario['codigo'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header("Location: master.php");
    } else {
        header("Location: admin_login.php");
    }
}
?>