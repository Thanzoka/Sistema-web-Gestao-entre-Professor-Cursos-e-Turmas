<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_admin.php");
    exit();
}

//define o nome da sessão pelo id do admin
$usuario_id = $_SESSION['usuario_id'];

//recupera o nome do admin de acordo com o id da sessão
$sql_usuario = "SELECT nome FROM usuario WHERE codigo='$usuario_id'";
$result_usuario = $conn->query($sql_usuario);
$usuario_nome = $result_usuario->fetch_assoc()['nome'];

$sql = "SELECT * FROM professor WHERE usuario_codigo='$usuario_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listar professores</title>
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
            <span class="navbar-brand mb-0 h1 text-white">Bem-vindo(a), admin <?php echo $usuario_nome; ?></span>
            <a href="logout.php" class="btn btn-danger">Sair</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h4>Professores</h4>
        <div class="row justify-content-end">
            <div class="col-2">            
            <a href="cadastrar_professor.php" class="btn btn-success mb-2">Cadastrar Professor</a>
            </div>
            <div class="col-2">            
            <a href="cadastrar_curso_admin.php" class="btn btn-success mb-2">Cadastrar Curso</a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Professor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['codigo']."</td>";
                        echo "<td>".$row['nome']."</td>";
                        echo "<td><a href='deletar_professor.php?professor_id=".$row['codigo']."' onclick='return confirm(`Tem certeza que deseja deletar este professor?`)' class='btn btn-danger btn-sm'>Deletar</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum professor(a) cadastrado(a)</td></tr>";
                }
                ?>
            </tbody>
        </table>        
    </div>
</body>
</html>