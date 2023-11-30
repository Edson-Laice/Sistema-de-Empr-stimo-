<?php
// Conecte-se ao banco de dados ou inclua seu arquivo de conexão
include 'cf.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loan = $_POST['loan'];
    $garantiaTipo = $_POST['garantiaTipo'];
    $descricaoGarantia = $_POST['descricaoGarantia'];
    $statusGarantia = $_POST['statusGarantia'];
    $valorGarantia = $_POST['valorGarantia'];
    $dataAquisicao = $_POST['dataAquisicao'];
    $dataVencimento = $_POST['dataVencimento'];

    // Faça a validação dos dados recebidos, como garantir que os valores sejam números válidos e as datas estejam no formato correto.

    // Execute uma consulta SQL para inserir os dados no banco de dados
    $query = "INSERT INTO garantia (loan_id, tipo_garantia, descricao, status, valor, data_aquisicao, data_vencimento)
              VALUES ('$loan', '$garantiaTipo', '$descricaoGarantia', '$statusGarantia', '$valorGarantia', '$dataAquisicao', '$dataVencimento')";

    // Execute a consulta e verifique se foi bem-sucedida
    if ($conn2->query($query) === TRUE) {
        header("Location: loan_details.php?id=$loan");
    } else {
        echo "Erro ao adicionar garantia: " . $conn2->error;
    }
}

// Encerre a conexão com o banco de dados ou inclua seu arquivo de conexão
?>
