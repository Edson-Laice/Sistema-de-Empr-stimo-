<?php
// Inclua o arquivo de configuração do banco de dados
require_once 'class.php';

// Verifique se o formulário foi enviado
if (isset($_POST['save'])) {
    if ($_POST['loan_type_id'] == "" && $_POST['amount'] == "" && $interest_rate = $_POST['interest_rate'] == "" && $_POST['penalty'] == "" && $_POST['duration_months'] == "" && $_POST['user_id']) {
        header("location: loan.php?message=emty");
    } else {
        $db = new db_class();

        // Recolha os dados do formulário
        $borrower_id = $_POST['borrower_id'];

        // Verifique se o mutuário já possui um empréstimo aprovado ou pendente
        $existingLoanQuery = "SELECT status FROM loan WHERE borrower_id = $borrower_id AND (status = 'aprovado' OR status = 'pendente')";
        $existingLoanResult = $db->conn->query($existingLoanQuery);

        if ($existingLoanResult && $existingLoanResult->num_rows > 0) {
            // Se tiver, redirecione para a página de empréstimos
            header("location: loan.php?message=falid");
            exit; // Certifique-se de encerrar a execução do script após o redirecionamento
        }

        // Continue com a inserção do empréstimo
        $loan_type_id = $_POST['loan_type_id'];
        $amount = $_POST['amount'];
        $interest_rate = $_POST['interest_rate'];
        $penalty = $_POST['penalty'];
        $duration_months = $_POST['duration_months'];
        $user_id = $_POST['user_id'];

        // Chame a função de inserção do empréstimo
        $result = $db->insertLoan($borrower_id, $loan_type_id, $amount, $interest_rate, $penalty, $duration_months, $user_id);

        if ($result) {
            // Redirecione para uma página de sucesso ou faça o que for necessário após a inserção bem-sucedida
            header("location: loan.php?message=aproved");
        } else {
            // Trate o erro, se houver, por exemplo, exibindo uma mensagem de erro
            echo "Erro ao inserir o empréstimo.";
        }
    }
}
