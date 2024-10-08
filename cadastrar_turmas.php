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

$cursos_id = isset($_GET['cursos_id']) ? $_GET['cursos_id'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_turmas = $_POST['turma'];
    $cursos_codigo = $_POST['cursos_codigo'];
    $professor_id = $_SESSION['professor_id'];

    $sql = "INSERT INTO turmas (turma, cursos_codigo, professor_codigo) VALUES ('$nome_turmas', '$cursos_codigo', '$professor_id')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: sucesso.php");
    } else {
        echo "Erro ao cadastrar turma: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Turma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #000;
        }
        .oculto {
            display: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-custom">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 text-white">Bem-vindo(a), Professor(a) <a style="text-decoration: none; color:#87CEFA" href="listar_cursos.php"><?php echo htmlspecialchars($professor_nome); ?></a></span>
            <a href="logout.php" class="btn btn-danger">Sair</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h4>Cadastrar Turma</h4>
        <div class="row justify-content-end">
            <div class="col-2">            
                <a href="listar_cursos.php" class="btn btn-primary mt-2">Voltar</a>
            </div>
        </div>
        <form method="post" action="cadastrar_turmas.php?cursos_id=<?php echo $cursos_id ; ?>">
            <div class="mb-3">
                <label for="turma" class="form-label">Turma</label>
                <input type="text" name="turma" class="form-control" required>
            </div>
            <div class="mb-3 oculto">
                <label for="cursos_codigo" class="form-label">curso</label>
                <select name="cursos_codigo" class="form-control" required>
                    <?php
                    // Pega o nome e código do curso
                    $sql_cursos = "SELECT codigo, curso FROM cursos";
                    $result_cursos = $conn->query($sql_cursos);

                    if ($result_cursos->num_rows > 0) {
                        while($row = $result_cursos->fetch_assoc()) {
                            $selected = ($row['codigo'] == $cursos_id) ? 'selected' : '';
                            echo "<option value='" . ($row['codigo']) . "' $selected>" . ($row['curso']) . "</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhum curso encontrada</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Cadastrar</button>
        </form>
    </div>
</body>
</html>
