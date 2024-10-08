<?php
session_start();
include 'config.php';

if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit();
}

$professor_id = $_SESSION['professor_id'];

$sql_professor = "SELECT nome FROM professor WHERE codigo='$professor_id'";
$result_professor = $conn->query($sql_professor);
$professor_nome = $result_professor->fetch_assoc()['nome'];

$turmas_id = isset($_GET['turmas_id']) ? $_GET['turmas_id'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $atividade = $_POST['atividade'];
    $data = $_POST['data'];
    $data_fim = $_POST['data_fim'];

    $sql = "INSERT INTO atividades (atividade, data, data_fim, turmas_codigo) VALUES ('$atividade', '$data', '$data_fim', '$turmas_id')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: listar_cursos.php?turmas_id=".$turmas_id);
        exit();
    } else {
        echo "Erro ao cadastrar atividade: " . $conn->error;
    }
}
?>

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
    
    <nav class="navbar navbar-custom">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 text-white">Bem-vindo(a), Professor(a) <a style="text-decoration: none; color:#87CEFA" href="listar_cursos.php"> <?php echo $professor_nome; ?>  </a></span>
            <a href="logout.php" class="btn btn-danger">Sair</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h3>Cadastrar atividade</h3>
        <div class="row justify-content-end">
            <div class="col-2">            
                <a href="listar_cursos.php" class="btn btn-primary mt-2">Voltar</a>
            </div>
        </div>
        <form method="post" action="cadastrar_atividades.php?turmas_id=<?php echo $turmas_id; ?>">
            <div class="mb-3">
                <label for="atividade" class="form-label">Atividade</label>
                <textarea name="atividade" class="form-control" required></textarea><br><br>
                <label for="data" class="form-label">Data de Início</label>
                <input type="date" name="data" required><br><br>
                <label for="data_fim" class="form-label">Data de Término</label>
                <input type="date" name="data_fim" required>
            </div>
            <button type="submit" class="btn btn-success">Cadastrar</button>
        </form>
        
    </div>
</body>
</html>
