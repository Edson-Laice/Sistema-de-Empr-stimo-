<?php
require_once 'class.php';

if (isset($_POST['save'])) {
    $db = new db_class();
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $contact_no = $_POST['contact_no'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $tax_id = $_POST['tax_id'];
    $data_nascimento = $_POST['data_nascimento'];
    $nacionalidade = $_POST['nacionalidade'];
    $naturalidade = $_POST['naturalidade'];
    $provincia = $_POST['provincia'];
    $estado_civil = $_POST['estado_civil'];
    $sexo = $_POST['sexo'];
    $profissao = $_POST['profissao'];
    $residencia = $_POST['residencia'];
    $bairro = $_POST['bairro'];
    $av_rua = $_POST['av_rua'];
    $casa_flat_n = $_POST['casa_flat_n'];
    $quarteirao = $_POST['quarteirao'];
    $bi_passaport_n = $_POST['bi_passaport_n'];
    $emissor = $_POST['emissor'];
    $data_emissao = $_POST['data_emissao'];
	var_dump($_POST);
    $db->save_borrower(
        $firstname,
        $middlename,
        $lastname,
        $contact_no,
        $address,
        $email,
        $tax_id,
        $data_nascimento,
        $nacionalidade,
        $naturalidade,
        $provincia,
        $bi_passaport_n,
        $emissor,
        $data_emissao,
        $estado_civil,
        $sexo,
        $profissao,
        $residencia,
        $bairro,
        $av_rua,
        $casa_flat_n,
        $quarteirao,
    );

    header("location: borrower.php");
}
?>
