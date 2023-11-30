<?php
// Inclua o arquivo de configuração do banco de dados
include 'cf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loanID = $_POST['id'];
    $status = $_POST['status'];
    $parcelType = $_POST['parcelType'];

    // Consulta SQL para buscar as informações do empréstimo com base no ID
    $loanQuery = "SELECT * FROM loan WHERE id = $loanID";
    $loanResult = $conn2->query($loanQuery);

    if ($status === 'negado') {
        // Atualize apenas o status e não realize as outras operações
        $query = "UPDATE loan SET status = '$status' WHERE id = $loanID";

        if ($conn2->query($query) === TRUE) {
            header("Location: loan.php");
        } else {
            echo 'Erro ao atualizar o status do empréstimo: ' . $conn2->error;
        }
    } else {
        if ($loanResult && $loanResult->num_rows > 0) {
            $loanRow = $loanResult->fetch_assoc();
    
            // Obtém a data de aprovação (approval_date) para uso posterior
            $approvalDate = date('Y-m-d');
    
            // Calcula a data de conclusão (completion_date) com base no approval_date e duration_months
            $completionDate = date('Y-m-d', strtotime($approvalDate . ' +' . $loanRow['duration_months'] . ' months'));
    
            // Consulta SQL para atualizar o status, approval_date e completion_date do empréstimo
            $query = "UPDATE loan SET status = '$status', approval_date = '$approvalDate', completion_date = '$completionDate' WHERE id = $loanID";
    
            if ($conn2->query($query) === TRUE) {
                
            } else {
                echo 'Erro ao atualizar o status do empréstimo: ' . $conn2->error;
            }
    
            // Verifique o status e insira parcelas com base no tipo selecionado
            if ($status === 'aprovado' && $parcelType === 'Diário') {
                // Insira parcelas diárias
    
                // Cálculos para o valor total e o valor das parcelas diárias
                $valorTotal = $loanRow['amount'] * (1 + ($loanRow['interest_rate'] / 100));
                $durationMonths = $loanRow['duration_months'];
                $dias = $durationMonths * 30; // Supondo que um mês tem 30 dias
                $valorParcela = $valorTotal / $dias;
    
                // Loop para inserir parcelas diárias
                for ($i = 1; $i <= $dias; $i++) {
                    $dataVencimento = date('Y-m-d', strtotime($approvalDate. ' +' . $i . ' days'));
                    $insertQuery = "INSERT INTO parcelas (loan_id, borrower_ref, loan_type_id, valor_total, status, valor_parcela, data_vencimento, status_pagamento, multa, status_multa)
                        VALUES ($loanID, {$loanRow['ref']}, {$loanRow['loan_type_id']}, $valorTotal, 'Diário', $valorParcela, '$dataVencimento', 'Não Pago', 0, 'Não Multado')";
                    $conn2->query($insertQuery);
                }
            } elseif ($status === 'aprovado' && $parcelType === 'Semanal') {
                // Insira parcelas semanais
    
                // Cálculos para o valor total e o valor das parcelas semanais
                $valorTotal = $loanRow['amount'] * (1 + ($loanRow['interest_rate'] / 100));
                $durationMonths = $loanRow['duration_months'];
                $semanas = $durationMonths * 4; // Supondo que um mês tem 4 semanas
                $valorParcela = $valorTotal / $semanas;
    
                // Loop para inserir parcelas semanais
                for ($i = 1; $i <= $semanas; $i++) {
                    $dataVencimento = date('Y-m-d', strtotime($approvalDate. ' +' . ($i * 7) . ' days'));
                    $insertQuery = "INSERT INTO parcelas (loan_id, borrower_ref, loan_type_id, valor_total, status, valor_parcela, data_vencimento, status_pagamento, multa, status_multa)
                        VALUES ($loanID, {$loanRow['ref']}, {$loanRow['loan_type_id']}, $valorTotal, 'Semanal', $valorParcela, '$dataVencimento', 'Não Pago', 0, 'Não Multado')";
                    $conn2->query($insertQuery);
                }
            } elseif ($status === 'aprovado' && $parcelType === 'Mensal') {
                // Insira parcelas mensais
    
                // Cálculos para o valor total e o valor das parcelas mensais
                $valorTotal = $loanRow['amount'] * (1 + ($loanRow['interest_rate'] / 100));
                $durationMonths = $loanRow['duration_months'];
                $valorParcela = $valorTotal / $durationMonths;
    
                // Loop para inserir parcelas mensais
                for ($i = 1; $i <= $durationMonths; $i++) {
                    $dataVencimento = date('Y-m-d', strtotime($approvalDate. " +$i months"));
                    $insertQuery = "INSERT INTO parcelas (loan_id, borrower_ref, loan_type_id, valor_total, status, valor_parcela, data_vencimento, status_pagamento, multa, status_multa)
                        VALUES ($loanID, {$loanRow['ref']}, {$loanRow['loan_type_id']}, $valorTotal, 'Mensal', $valorParcela, '$dataVencimento', 'Não Pago', 0, 'Não Multado')";
                    $conn2->query($insertQuery);
                }
            }
            header("Location: loan_details.php?id=$loanID");
        } else {
            echo 'Empréstimo não encontrado.';
        }
    }

    
}
?>
