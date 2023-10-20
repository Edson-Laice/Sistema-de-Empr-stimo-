<?php
// Conexão com o banco de dados (substitua pelas suas configurações)
include 'cf.php';

if ($conn2->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn2->connect_error);
}

// Verifica se o parcelId foi passado na requisição
if (isset($_POST['parcelId'])) {
    $parcelId = $_POST['parcelId'];

    // Consulta para buscar informações da parcela e do devedor
    $query = "SELECT parcelas.*, borrower.firstname FROM parcelas JOIN loan 
    ON parcelas.loan_id = loan.id JOIN borrower ON loan.borrower_id = 
    borrower.borrower_id WHERE parcelas.id  = $parcelId";

    $result = $conn2->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $data = array(
            'borrowerName' => $row['borrower_name'],
            'parcelValue' => $row['valor_parcela'],
            'dueDate' => strftime("%d de %B de %Y", strtotime($row['data_vencimento'])),
            'penaltyAmount' => $row['multa']
        );

        // Envia os dados como JSON de volta para o JavaScript
        echo json_encode($data);
    } else {
        $errorData = array(
            'error' => 'Parcela não encontrada.'
        );
    
        // Envia o relatório de erro como JSON
        echo json_encode($errorData);
    }

    $conn->close();
} else {
    echo "ID da parcela não especificado na requisição.";
}
?>
