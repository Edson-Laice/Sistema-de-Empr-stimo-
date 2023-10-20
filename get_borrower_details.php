<?php
// Inclua o arquivo de configuração do banco de dados
include 'cf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loanID = $_POST['loan_id'];

    // Crie uma instância da classe db_class
    $db = new db_class();

    // Chame a função getLoanById para obter os detalhes do empréstimo
    $loanDetails = $db->getLoanById($loanID);

    if ($loanDetails) {
        // Construa o conteúdo HTML para preencher o modal com os detalhes do empréstimo
        $html = '<h4>Detalhes do Empréstimo</h4>';
        $html .= '<div class="form-group">';
        $html .= '<label for="amount">Valor emprestado:</label>';
        $html .= '<input type="text" class="form-control" id="amount" name="amount" value="' . number_format($loanDetails['amount'], 2) . '">';
        $html .= '</div>';

        $html .= '<div class="form-group">';
        $html .= '<label for="interestRate">Taxa de juros:</label>';
        $html .= '<input type="text" class="form-control" id="interestRate" name="interestRate" value="' . $loanDetails['interest_rate'] . '">';
        $html .= '</div>';

        $html .= '<div class="form-group">';
        $html .= '<label for="penalty">Multa:</label>';
        $html .= '<input type="text" class="form-control" id="penalty" name="penalty" value="' . number_format($loanDetails['penalty'], 2) . '">';
        $html .= '</div>';

        $html .= '<div class="form-group">';
        $html .= '<label for="status">Status:</label>';
        $html .= '<select class="form-control" id="status" name="status">';
        $html .= '<option value="pendente" ' . ($loanDetails['status'] === 'pendente' ? 'selected' : '') . '>Pendente</option>';
        $html .= '<option value="aprovado" ' . ($loanDetails['status'] === 'aprovado' ? 'selected' : '') . '>Aprovado</option>';
        $html .= '<option value="concluído" ' . ($loanDetails['status'] === 'concluído' ? 'selected' : '') . '>Concluído</option>';
        $html .= '<option value="negado" ' . ($loanDetails['status'] === 'negado' ? 'selected' : '') . '>Negado</option>';
        $html .= '</select>';
        $html .= '</div>';

        echo $html;
    } else {
        echo 'Nenhum detalhe do empréstimo encontrado.';
    }
} else {
    echo 'Requisição inválida.';
}

?>
