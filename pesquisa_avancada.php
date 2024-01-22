<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <title>Relatórios</title>
</head>

<body>
    <style>
        table {
            border-collapse: collapse;
        }
    </style>


<?php
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
include_once('cf.php');

// Supondo que você tenha um arquivo para conexão com o banco de dados

// Recebe os parâmetros do formulário
$managerSelect = $_POST['managerSelect'];
$dataInicio = $_POST['dataInicio'];
$dataFim = $_POST['dataFim'];
$loanStatusSelect = $_POST['loanStatusSelect'];

// Consulta para obter os dados necessários 
$query = "SELECT 
            borrower.firstname,
            borrower.lastname,
            loan.user_id,
            MIN(loan.approval_date) AS approval_date,
            loan.amount AS saidas,
            loan.interest_rate AS taxas_juros,
            loan.completion_date,
            parcelas.valor_parcela,
            SUM(CASE WHEN parcelas.status_pagamento = 'Pago' THEN parcelas.valor_parcela ELSE 0 END) AS valor_pagamento,
            parcelas.status_pagamento,
            (parcelas.valor_parcela - IFNULL(SUM(CASE WHEN parcelas.status_pagamento = 'Pago' THEN parcelas.valor_parcela ELSE 0 END), 0)) AS saldo,
            parcelas.status AS tipo_credito,
            CASE 
                WHEN loan.status = 'aprovado' THEN 'Mora'
                WHEN loan.status = 'concluído' THEN 'Fechou'
                ELSE ''
            END AS situacao_cliente
          FROM 
            borrower
          INNER JOIN loan ON borrower.borrower_id = loan.borrower_id
          LEFT JOIN parcelas ON loan.id = parcelas.loan_id
          WHERE 
            loan.user_id IS NOT NULL AND
            (loan.approval_date BETWEEN ? AND ? OR ? = '')
          GROUP BY 
            borrower.firstname, borrower.lastname, loan.user_id, loan.amount, loan.interest_rate, loan.completion_date, parcelas.valor_parcela, parcelas.status_pagamento, loan.status
          ORDER BY
            loan.user_id";

$stmt = $conn2->prepare($query);

// Verifica se a preparação da consulta foi bem-sucedida
if ($stmt === false) {
    die('Erro na preparação da consulta: ' . $conn2->error);
}

// Ajusta os parâmetros de binding
$stmt->bind_param('sss', $dataInicio, $dataFim, $dataInicio);

// Executa a consulta
if (!$stmt->execute()) {
    die('Erro na execução da consulta: ' . $stmt->error);
}

// Obtém o resultado da consulta
$result = $stmt->get_result();

$currentBorrower = null;

while ($row = $result->fetch_assoc()) :
    $userId = $row['user_id'];

    if ($currentBorrower !== $userId) {
        // Nova tabela para um novo user_id
        if ($currentBorrower !== null) {
            // Fecha a tabela anterior se existir
            echo '</table>';
        }
        
        // Consulta para obter detalhes do usuário
        $userDetailsQuery = "SELECT firstname, lastname FROM user WHERE user_id = ?";
        $userDetailsStmt = $conn2->prepare($userDetailsQuery);
        $userDetailsStmt->bind_param('i', $userId);
        $userDetailsStmt->execute();
        $userDetailsResult = $userDetailsStmt->get_result();
        $userDetails = $userDetailsResult->fetch_assoc();

        // Exibir o nome do usuário na tabela
        $userName = $userDetails['firstname'] . ' ' . $userDetails['lastname'];
        echo "<h2>Gestor(a) $userName</h2>";
        echo '<table border="1">
            <tr>
                <th class="text-red">Cliente</th>
                <th>Data</th>
                <th>Saídas</th>
                <th>Taxas de Juros</th>
                <th>Prazo</th>
                <th>Entradas</th>
                <th>Total de Parcelas Pagas</th>
                <th>Saldo</th>
                <th>Tipo de Crédito</th>
                <th>Situação do Cliente</th>
            </tr>';
        $currentBorrower = $userId;
    }
?>
    <tr>
        <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
        <td><?php echo $row['approval_date']; ?></td>
        <td><?php echo number_format($row['saidas'], 2) . ' MT'; ?></td>
        <td><?php echo $row['taxas_juros'] . '%'; ?></td>
        <td><?php echo $row['completion_date']; ?></td>
        <td><?php echo number_format($row['valor_pagamento'], 2) . ' MT'; ?></td>
        <td><?php echo $row['status_pagamento']; ?></td>
        <td><?php echo number_format($row['saldo'], 2) . ' MT'; ?></td>
        <td><?php echo $row['tipo_credito']; ?></td>
        <td><?php echo $row['situacao_cliente']; ?></td>
    </tr>
<?php endwhile; ?>

<?php
// Certifique-se de fechar a última tabela fora do loop
if ($currentBorrower !== null) {
    echo '</table>';
}
?>
    <br>
    <br>
    <?php
    // Consulta para o total de vendas com nome do usuário
    $totalVendasQuery = "SELECT 
    user.user_id,
    user.firstname,
    user.lastname,
    SUM(loan.amount) AS total_vendas
FROM 
    user
INNER JOIN loan ON user.user_id = loan.user_id
GROUP BY 
    user.user_id, user.firstname, user.lastname";

    // Prepara e executa a consulta para o total de vendas
    $totalVendasStmt = $conn2->prepare($totalVendasQuery);
    $totalVendasStmt->execute();
    $totalVendasResult = $totalVendasStmt->get_result();
    ?>

    <!-- Tabela para o total de vendas -->
    <table border="1">
        <tr>

            <th>Gerente</th>
            <th>Total de Vendas</th>
        </tr>

        <?php while ($totalVendasRow = $totalVendasResult->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $totalVendasRow['firstname'] . ' ' . $totalVendasRow['lastname']; ?></td>
                <td><?php echo number_format($totalVendasRow['total_vendas'], 2) . ' MT'; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <br><br>

    <?php
    // Consulta para o valor pago
    $valorPagoQuery = "SELECT 
    user.user_id,
    user.firstname,
    user.lastname,
    SUM(CASE WHEN parcelas.status_pagamento = 'Pago' THEN parcelas.valor_parcela ELSE 0 END) AS total_pago
FROM 
    user
INNER JOIN loan ON user.user_id = loan.user_id
LEFT JOIN parcelas ON loan.id = parcelas.loan_id
GROUP BY 
    user.user_id, user.firstname, user.lastname";

    // Prepara e executa a consulta para o valor pago
    $valorPagoStmt = $conn2->prepare($valorPagoQuery);
    $valorPagoStmt->execute();
    $valorPagoResult = $valorPagoStmt->get_result();
    ?>

    <!-- Tabela para o valor pago -->
    <table border="1">
        <tr>

            <th>Gerente</th>
            <th>Valor Pago</th>
        </tr>

        <?php while ($valorPagoRow = $valorPagoResult->fetch_assoc()) : ?>
            <tr>

                <td><?php echo $valorPagoRow['firstname'] . ' ' . $valorPagoRow['lastname']; ?></td>
                <td><?php echo number_format($valorPagoRow['total_pago'], 2) . ' MT'; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>


    <br>
    <br>
    
    <?php
$sql = "SELECT 
borrower.firstname,
borrower.lastname,
MIN(loan.approval_date) AS approval_date,
loan.amount AS saidas,
loan.interest_rate AS taxas_juros,
parcelas.status,
loan.completion_date,
SUM(parcelas.valor_parcela) AS valor_parcela_total,
SUM(CASE WHEN parcelas.status_pagamento = 'Pago' THEN parcelas.valor_parcela ELSE 0 END) AS valor_pago_total,
CASE 
    WHEN loan.status = 'aprovado' THEN 'Mora'
    WHEN loan.status = 'concluído' THEN 'Fechou'
    ELSE ''
END AS situacao_cliente
FROM 
borrower
INNER JOIN loan ON borrower.borrower_id = loan.borrower_id
LEFT JOIN parcelas ON loan.id = parcelas.loan_id
LEFT JOIN payments ON parcelas.id = payments.parcela_id
WHERE 
loan.user_id IS NOT NULL AND
(loan.approval_date BETWEEN ? AND ? OR ? = '')
GROUP BY 
borrower.firstname, borrower.lastname, loan.amount, loan.interest_rate, loan.completion_date, loan.status
ORDER BY
borrower.firstname, borrower.lastname;";

$stmt = $conn2->prepare($sql);
$stmt->bind_param('sss', $dataInicio, $dataFim, $dataInicio);
$stmt->execute();
$result = $stmt->get_result();
?>
<p> <strong> Balanco final referente ao dias <?php echo strftime("%d de %B de %Y", strtotime($dataInicio)) .' a '. strftime("%d de %B de %Y", strtotime($dataFim)) ?> </strong></p>
<table border="1">
    <tr>
        <th>Nome</th>
        <th>Data de Aprovação</th>
        <th>Saidas</th>
        <th>Taxas Juros</th>
        <th>Prazo</th>
        <th>Valor Total</th>
        <th>Valor Pago</th>
        <th>Saldo</th>
        <th>Tipo Crédito</th>
        <th>Situação Cliente</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
            <td> <strong> <?php echo $row['approval_date']; ?></strong></td>
            <td><?php echo number_format($row['saidas'], 2) . ' MT'; ?></td>
            <td><?php echo number_format($row['taxas_juros'], 2) . ' %'; ?></td>
           
            <?php 
             $completionDate = new DateTime($row['completion_date']);
             $currentDate = new DateTime();
     
             // Calcula a diferença em meses
             $interval = $completionDate->diff($currentDate);
             $differenceInMonths = $interval->y * 12 + $interval->m;
     
             // Exibe a diferença em meses
            
            ?>
             <td><?php  echo $differenceInMonths . ' meses';?></td>
           
            <td><?php echo number_format($row['valor_parcela_total'], 2) . ' MT'; ?></td>
            <td><?php echo number_format($row['valor_pago_total'], 2) . ' MT'; ?></td>
            <td><?php echo number_format($row['valor_parcela_total'] - $row['valor_pago_total'], 2) . ' MT'; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['situacao_cliente']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>


</body>

</html>