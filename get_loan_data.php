<?php
// Inclua o arquivo de conexão
include 'cf.php';

$page = $_GET['page'];
$rowsPerPage = $_GET['rowsPerPage'];

// Cálculo do limite e deslocamento com base na página e registros por página
$offset = ($page - 1) * $rowsPerPage;

// Consulta SQL para recuperar os dados da tabela `loan` com limite e deslocamento
$query = "SELECT * FROM `loan` LIMIT $offset, $rowsPerPage";
$result = $conn2->query($query);

$data = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$response = array(
    'data' => $data,
    'total_rows' => count($data)
);

header('Content-Type: application/json');
echo json_encode($response);
?>

