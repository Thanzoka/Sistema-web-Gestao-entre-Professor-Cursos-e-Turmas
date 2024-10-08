<?php
session_start();
include 'config.php';

if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit();
}

$professor_id = $_SESSION['professor_id'];
$turmas_id = isset($_GET['turmas_id']) ? $_GET['turmas_id'] : '';

// Obter nome da turma
$sql_turmas = "SELECT turma FROM turmas WHERE codigo='$turmas_id'";
$result_turmas = $conn->query($sql_turmas);

if ($result_turmas && $result_turmas->num_rows > 0) {
    $turmas_nome = $result_turmas->fetch_assoc()['turma'];
} else {
    $turmas_nome = "Turma não encontrada";
}

// Obter nome do professor
$sql_professor = "SELECT nome FROM professor WHERE codigo='$professor_id'";
$result_professor = $conn->query($sql_professor);
$professor_nome = $result_professor->fetch_assoc()['nome'];

// Obter atividades
$sql = "SELECT * FROM atividades WHERE turmas_codigo='$turmas_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listar atividades</title>
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
        <h4>Atividades da turma: <?php echo $turmas_nome; ?></h4>
        <div class="row justify-content-end">
            <div class="col-3">
            <a href="cadastrar_atividades.php?turmas_id=<?php echo $turmas_id; ?>" class="btn btn-success mb-2">Cadastrar Atividade</a>
            <a href="listar_cursos.php" class="btn btn-primary mb-2">Voltar</a>
            </div>
        </div>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Atividades</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['codigo']."</td>";
                        echo "<td>".$row['atividade']."</td>";
                        echo "<td>".$row['data']."</td>";
                        echo "<td>".$row['data_fim']."</td>";
                        echo "<td><a href='update.php?atividades_id=".$row['codigo']."' class='btn bg-warning btn-sm'>Editar atividade</a> ";
                        echo "<a href='deletar_atividades.php?atividades_id=".$row['codigo']."' onclick='return confirm(`Tem certeza que deseja deletar esta atividade?`)' class='btn btn-danger btn-sm'>Deletar</a>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Nenhuma atividade cadastrada</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
    </div>
</body>
</html>