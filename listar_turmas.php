<?php
session_start();
include 'config.php';

if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit();
}

$cursos_id = $_GET['cursos_id'];
$professor_id = $_SESSION['professor_id'];

// Obter nome do curso
$sql_cursos = "SELECT curso FROM cursos WHERE codigo='$cursos_id'";
$result_cursos = $conn->query($sql_cursos);
$cursos_nome = $result_cursos->fetch_assoc()['curso'];

//recupera o nome do professor de acordo com o id da sessão
$sql_professor = "SELECT nome FROM professor WHERE codigo='$professor_id'";
$result_professor = $conn->query($sql_professor);
$professor_nome = $result_professor->fetch_assoc()['nome'];

$sql = "SELECT * FROM turmas WHERE professor_codigo='$professor_id' AND cursos_codigo='$cursos_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listar turmas</title>
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
        <span class="navbar-brand mb-0 h1 text-white">Bem-vindo(a), Professor(a)<a style="text-decoration: none; color:#87CEFA" href="listar_cursos.php"> <?php echo $professor_nome; ?>  </a></span>
            <a href="logout.php" class="btn btn-danger">Sair</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h4>Curso: <?php echo $cursos_nome; ?></h4>
        <div class="row justify-content-end">       
            <div class="col-1">            
                <a href="listar_cursos.php" class="btn btn-primary mt-0">Voltar</a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Turma</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['codigo']."</td>";
                        echo "<td>".$row['turma']."</td>";
                        echo "<td><a href='listar_atividades.php?turmas_id=".$row['codigo']."' class='btn btn-info btn-sm'>Ver atividades</a> ";
                        echo "<a href='deletar_turmas.php?turmas_id=".$row['codigo']."' onclick='return confirm(`Tem certeza que deseja deletar esta turma?`)' class='btn btn-danger btn-sm'>Deletar</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhuma turma cadastrada</td></tr>";
                }
                ?>
            </tbody>
        </table>        
    </div>
</body>
</html>