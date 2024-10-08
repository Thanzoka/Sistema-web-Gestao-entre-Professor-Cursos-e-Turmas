<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST["atividades_id"];
    $atividade = $_POST["atividade"];
    $data = $_POST["data"];
    $data_fim = $_POST["data_fim"];

    if (!empty($atividade) && !empty($data) && !empty($data_fim)) {
        
        $sql = "UPDATE atividades SET atividade = ?, data = ?, data_fim = ? WHERE codigo = ?";
        if ($stmt = $conn->prepare($sql)) {
            
            $stmt->bind_param("sssi", $atividade, $data, $data_fim, $codigo);

            if ($stmt->execute()) {
                header("Location: sucesso_editar.php");
                exit();
            } else {
                echo "Erro ao atualizar atividade: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro ao preparar a consulta: " . $conn->error;
        }
    } else {
        echo "TODOS OS CAMPOS DEVEM SER PREENCHIDOS!";
        header("refresh:2;url=listar_cursos.php");
        exit();
    }
}

$conn->close();
?>
