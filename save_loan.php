<?php
// Inclua o arquivo de configuração do banco de dados
require_once 'class.php';

// Verifique se o formulário foi enviado
if (isset($_POST['save'])) {
    $db = new db_class();

    // Recolha os dados do formulário
    $borrower_id = $_POST['borrower_id'];

    if ($db->hasPendingOrApprovedLoan($borrower_id)) {
        // Em vez de um redirecionamento direto, você pode definir a mensagem em GET
        $message = "Encontramos um empréstimo pendente ou aprovado. Não é possível criar um novo empréstimo.";

        // Redirecione para a página "loan" com a mensagem em GET
        header("location: loan.php?message=" . urlencode($message));
        exit;
    } else {
        $loan_type_id = $_POST['loan_type_id'];
        $amount = $_POST['amount'];
        $interest_rate = $_POST['interest_rate'];
        $penalty = $_POST['penalty'];
        $duration_months = $_POST['duration_months'];

        // Chame a função de inserção do empréstimo
        $result = $db->insertLoan($borrower_id, $loan_type_id, $amount, $interest_rate, $penalty, $duration_months);

        if ($result) {
            // Redirecione para uma página de sucesso ou faça o que for necessário após a inserção bem-sucedida
            header("location: loan.php");
        } else {
            // Trate o erro, se houver, por exemplo, exibindo uma mensagem de erro
            echo "Erro ao inserir o empréstimo.";
        }
    }
}
