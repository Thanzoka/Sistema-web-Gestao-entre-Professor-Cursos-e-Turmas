<?php
session_start();
include 'config.php';

if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit();
}

$professor_id = $_SESSION['professor_id'];
$cursos_id = isset($_GET['cursos_id']) ? $_GET['cursos_id'] : '';
$atividade_id = isset($_GET['atividades_id']) ? $_GET['atividades_id'] : '';

if (!$atividade_id) {
    die("Atividade não especificada.");
}

// Obter nome do curso
$sql_cursos = "SELECT curso FROM cursos WHERE codigo='$cursos_id'";
$result_cursos = $conn->query($sql_cursos);
if (!$result_cursos) {
    die("Erro ao consultar o curso: " . $conn->error);
}
$cursos_nome = $result_cursos->fetch_assoc()['curso'] ?? '';

// Obter nome do professor
$sql_professor = "SELECT nome FROM professor WHERE codigo='$professor_id'";
$result_professor = $conn->query($sql_professor);
if (!$result_professor) {
    die("Erro ao consultar o professor: " . $conn->error);
}
$professor_nome = $result_professor->fetch_assoc()['nome'] ?? '';

// Obter dados da atividade
$sql_atividade = "SELECT * FROM atividades WHERE codigo='$atividade_id'";
$result_atividade = $conn->query($sql_atividade);
if (!$result_atividade) {
    die("Erro ao consultar a atividade: " . $conn->error);
}
$atividade = $result_atividade->fetch_assoc();
if (!$atividade) {
    die("Atividade não encontrada.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar atividades</title>
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
            <span class="navbar-brand mb-0 h1 text-white">Bem-vindo(a), Professor(a)<a style="text-decoration: none; color:#87CEFA" href="listar_cursos.php"> <?php echo htmlspecialchars($professor_nome) ;?>  </a></span>
            <a href="logout.php" class="btn btn-danger">Sair</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h4>Editar atividade do curso: <?php echo htmlspecialchars($cursos_nome); ?></h4>
    </div>
    <form method="POST" action="atualizar.php">
        <input type="hidden" class="form-control" value="<?php echo htmlspecialchars($atividade['codigo']); ?>" name="atividades_id" required>
        
        <div class="mb-3">
            <label class="form-label">Atividade:</label>
            <textarea class="form-control" name="atividade" id="atividade" required><?php echo htmlspecialchars($atividade['atividade']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Data de início:</label>
            <input type="date"  value="<?php echo htmlspecialchars($atividade['data']); ?>" name="data" id="data" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Data de Término:</label>
            <input type="date" value="<?php echo htmlspecialchars($atividade['data_fim']); ?>" name="data_fim" id="data_fim" required>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn bg-secondary" style="color:white">ATUALIZAR</button>
        </div>
        <div class="row justify-content-end">       
            <div class="col-1">            
                <a href="listar_turmas.php" class="btn btn-primary mt-0">Voltar</a>
            </div>
        </div>
    </form>
</body>
</html>

<?php
$conn->close();
?>