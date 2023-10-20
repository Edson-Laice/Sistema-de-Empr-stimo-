<?php
include 'cf.php';

$valorRestante = 0;
$loanId;
$paymentAmount = $_POST['paymentAmount'];
$parcelId = $_POST['parcelId'];



    $query2 = "SELECT parcelas.loan_id, parcelas.valor_parcela, payments.parcela_id, SUM(payments.valor_pagamento) AS total_pago
              FROM parcelas
              LEFT JOIN payments ON parcelas.id = payments.parcela_id
              WHERE parcelas.id = $parcelId";

    $result2 = $conn2->query($query2);

    if ($result2 && $result2->num_rows > 0) {
        $row = $result2->fetch_assoc();
        $loanId = $row['loan_id'];
        $valorParcela = $row['valor_parcela'];
        $totalPago = $row['total_pago'];
        echo $row['loan_id'];
        $valorRestante = $valorParcela - $totalPago;
    } else {
        echo "Parcela não encontrada.";
    }



if (isset($_POST['paymentAmount'])) {

    $query = "INSERT INTO payments (parcela_id, valor_pagamento) VALUES ($parcelId, $paymentAmount)";
    if ($conn2->query($query) === TRUE) {
        // Atualize o status_pagamento na tabela parcelas
        $updateQuery = "UPDATE parcelas SET status_pagamento = 'Pago' WHERE id = $parcelId";
        if ($conn2->query($updateQuery) === TRUE) {
            header("Location: loan_details.php?");
        } else {
            echo "Erro ao atualizar o status da parcela: " . $conn2->error;
        }

        // Verifique se todas as parcelas desse empréstimo foram pagas
        $query = "SELECT id FROM parcelas WHERE loan_id = $loanId AND status_pagamento = 'Não Pago'";
        $result = $conn2->query($query);

        if ($result->num_rows === 0) {
            // Todas as parcelas foram pagas, atualize o status do empréstimo
            $query = "UPDATE loan SET status = 'concluído' WHERE id = $loanId";
            if ($conn2->query($query) === TRUE) {
                echo "Empréstimo concluído com sucesso!";
            } else {
                echo "Erro ao atualizar o status do empréstimo: " . $conn2->error;
            }
        }
    } else {
        echo "Erro ao registrar o pagamento: " . $conn2->error;
    }
}
?>
