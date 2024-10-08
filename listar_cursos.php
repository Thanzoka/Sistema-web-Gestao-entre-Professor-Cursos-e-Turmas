<?php
session_start();
include 'config.php';

if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit();
}

//define o nome da sessão pelo id do professor
$professor_id = $_SESSION['professor_id'];

//recupera o nome do professor de acordo com o id da sessão
$sql_professor = "SELECT nome FROM professor WHERE codigo='$professor_id'";
$result_professor = $conn->query($sql_professor);
$professor_nome = $result_professor->fetch_assoc()['nome'];

$sql = "SELECT * FROM cursos ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listar cursos</title>
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
            <span class="navbar-brand mb-0 h1 text-white">Bem-vindo(a), Professor(a) <?php echo $professor_nome; ?></span>
            <a href="logout.php" class="btn btn-danger">Sair</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h4>Cursos</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Curso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['codigo']."</td>";
                        echo "<td>".$row['curso']."</td>";
                        echo "<td><a href='cadastrar_turmas.php?cursos_id=".$row['codigo']."' class='btn btn-info btn-sm'>Cadastrar Turma</a>";
                        echo "<a href='listar_turmas.php?cursos_id=".$row['codigo']."' class='btn btn-sm btn-success'>Listar Turmas</a>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum curso cadastrado</td></tr>";
                }
                ?>
            </tbody>
        </table>        
    </div>
</body>
</html>