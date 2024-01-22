<?php
function numero($numero)
{
    $fmt = new NumberFormatter('pt_BR', NumberFormatter::SPELLOUT);
    return $fmt->format($numero);
}
include 'cf.php';
require_once 'session.php';
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

$nameCompany = "";
$refCompany = "";
$pca = "";
$Bi = "";
$borrower = "";
$natural = "";
$bairro = "";
$quarteirao = "";
$contacto = "";
$profissao = "";
$casa = "";
$valor = "";
$taxaDeJuros = "";
$multa = "";
$valorTotal = "";
$data = "";
$loanID = "";

if(isset($_GET['borrower']))
$borrower = $_GET['borrower'];

if(isset($_GET['Bi']))
$Bi = $_GET['Bi'];

if(isset($_GET['natural']))
$natural = $_GET['natural'];

if(isset($_GET['bairro']))
$bairro = $_GET['bairro'];

if(isset($_GET['quarteirao']))
$quarteirao = $_GET['quarteirao'];

if(isset($_GET['contacto']))
$contacto = $_GET['contacto'];

if(isset($_GET['profissao']))
$profissao = $_GET['profissao'];

if(isset($_GET['casa_n']))
$casa = $_GET['casa_n'];

if(isset($_GET['valor']))
$valor = $_GET['valor'];

if(isset($_GET['taxadejuros']))
$taxaDeJuros = $_GET['taxadejuros'];

if(isset($_GET['multa']))
$multa = $_GET['multa'];

if(isset($_GET['data']))
$data = $_GET['data'];

if(isset($_GET['loanID']))
$loanID = $_GET['loanID'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Impressão</title>
</head>
<style>
        body {
            text-align: justify; /* Centraliza o texto */
            line-height: 1.5;
            font-size: 12pt;
            background-color: black;
            
        }
        .pt{
            text-align: center;
        }
    </style>
<body>

     
<nav style="text-align: center;" >
<img style="width: 110px;" src="image/Imagem1.png" alt="" srcset=""> 
</nav>
<p class="pt">Money Trust Microcrédito, E.I</p>
<p class="pt">Cidade de Maputo</p>
<p style="text-align: center;"><strong>CONTRATO DE EMPRÊSTIMO</strong></p>

<p>PARTES</p>
 <p> <strong>MONEY TRUST MICROCREDITO, E.I</strong>, com N/Refª 1427/DRL/60.17.2/2022,
  Sede Operativa no Bairro de Bagamoyo Av de Moçambique Celula f . Q3 casa no 672, 
  Maputo Cidade representado pelo seu Director Geral <strong>Rodrigues Alberto Jamine</strong> , de nacionalidade
   Moçambicana, natural de Solane Bilene Provincia de Gaza,
  com poderes suficientes para o presente acto, doravante denominado <strong>MUTUANTE (Credor)</strong> . </p>
<p>E</p>

<p> A Senhora <?php echo $borrower; ?> Portador do Passporte Nº <?php echo $Bi;?>, Natural de 
<?php echo $natural;?> residente no Bairro de <?php echo $bairro?> Quarteirão <?php echo $quarteirao?>, Casa n°<?php echo $casa;?> Distrito Municipal 
 Matola , telemóveis: <?php echo $contacto?> Exerce funções de <?php echo $profissao?>, conta própria, desde 2013, tem receitas
  líquidas de 9.000,00MT mensalmente. Daqui em diante designado (a) por <strong>MUTUÁRIO</strong> </p> 

<p> <strong> (Devedor/a)</strong></p>  

<p>É celebrado o contracto mútuo com cobertura legal do art.1142° do Código Civil vigente, 
nos termos regido pelos seguintes artigos: </p>

<p style="text-align: center;"><strong>Artigo 1°</strong></p> 
<p style="text-align: center;"><strong>(Objecto)</strong></p> 
 
<p>O presente contrato tem por objecto regular a concessão de empréstimo á Devedor(a)
 nas condições descritas no presente contrato de financiamento é com a finalidade de investimento no negócio.</p>

 <p style="text-align: center;"><strong>Artigo 2°</strong></p> 
<p style="text-align: center;"><strong>(Montagem e taxa de juro) </strong></p>

<p>O valor concedido é de <?php echo number_format($valor, 2);  $extenso = numero($valor);?> (<?php echo $extenso;?>), à taxa de juro Mensal de <?php echo $taxaDeJuros;?>%, sendo que,
 em caso de incumprimento do plano de pagamentos, para além da taxa supra, será cobrado, sobre os
  montantes devidos, uma penalização correspondente a <?php echo $multa;?>% de juros diários. </p>
  <p style="text-align: center;"><strong>Artigo 3°</strong></p> 
<p style="text-align: center;"><strong>(Duração e Modalidade de pagamento) </strong></p> 

<p>O contrato entra em vigor a partir da data da disponibilização do capital 
    pelo credor ao (a) devedor(a) e extingue-se com o pagamento integral do capital e juros.  </p>

<p>O (A) devedor(a) compromete-se a fazer o pagamento da dívida em 30 (dias) prestações Mensal
     conforme plano de pagamentos a seguir que indica o valor de prestação e respectiva data de vencimento. </p>

<p><strong>PLANO DE PAGAMENTOS</strong></p> 

<p>Plano Semanal, Prestações Mensal, Capital Juros, Total Valor </p>
<p>Data de desembolso: <?php echo $data; ?> <?php echo number_format($valor, 2); ?> MT + <?php  $soma = $valor * ( $taxaDeJuros / 100); echo  number_format($soma, 2);?> MT = <?php $tl = $valor + $soma; echo number_format($tl, 2)?> MT</p>
<p>Valor desembolsado <?php echo number_format($valor, 2); ?> MT </p>
<p>Taxa de juro <?php echo $taxaDeJuros;?>% </p>
<p>Despesas de Preparo 3%, sendo no mínimo 200.00Mts</p> 
<p>Seguro 0,00 </p>
<p><strong> Total:</strong> <?php echo number_format($tl, 2);?> MT</p>
<p>Os pagamentos serão efectuados por:</p> 

<p>a)Deposito ou Transferência, creditando a conta número 806259830, NIB 000100000080625983057 em 
nome da  <strong> MONEY TRUST MICROCRÉDITO EI</strong>, domiciliada no Millennium Bim;</l> </p>

<p>b) O talão deve ser enviado as instalações do credor ou por E-mail: jamine1970gmail.com </p>

<p>c)  Todos pagamentos feitos pelo (a) devedor (a), estão sujeitos a emissão de recibo pelo credor. </p>
<br>
<p style="text-align: center;"><strong> Artigo 4° </strong><p> 
<p style="text-align: center;"> <strong> (Cancelamento antecipado) </strong></p>

<p>São permitidos pagamentos parciais ou total antes do prazo final acordado, sem quaisquer penalização e ou redução do valor devido. </p>

<p style="text-align: center;"> <strong> Artigo 5° </strong> </p>
<p style="text-align: center;"> <strong>  (Garantias)  </strong> </p>
    
<p>a)Como garantia de pagamento pontual e integral dos valores devidos derivados do presente empréstimo. </p>
<p>b)O Devedor(a) coloca à disposição do Credor, sob forma de penhor que é parte integrante deste Contrato, os SEGUINTES bens: </p>

<?php 
    $query2 = "SELECT * FROM garantia WHERE loan_id = $loanID";
    $result2 = $conn2->query($query2);

    if($result2 && $result2->num_rows > 0)
    {
        while($row = $result2->fetch_assoc())
        {
            ?>
                <li style="list-style: decimal;"><?php echo $row['descricao'];?> <strong> Valor: </strong> <?php echo number_format($row['valor'], 2). 'MT';?></li>
            <?php
        }
    }else
    {
        ?>
        <p style="color:red;">Nenhuma garantia encontrada para este empréstimo.</p>
        <?php
    }
?>


<p>.O Devedor (a) autoriza ao Credor e ou seus representantes a efectuarem visitas de verificação
 dos bens dados de garantia para este financiamento, durante a vigência do crédito e durante os
  dias laborais, de segunda-feira ao sábado, entre as horas normais de expediente.  </p>

<p>a)Caso se verifique ausência de um ou mais bens alistados como garantia do presente empréstimo,
     o devedor acorda em os substituir, imediatamente, por quaisquer outros de valor igualou superior
      aos bens em falta. </p>
<p>b)Para substituição dos bens ausentes, o devedor, autoriza ao credor a recorrer ao seu património. </p>
<p>c)O Devedor é o fiel depositário dos bens alistados e identificados nos números 1° e 2°, e desde já, 
autoriza o Credor a Proceder a execução e a venda dos mesmos caso se verifique um ou mais atrasos no
 pagamento de quaisquer valores devidos derivados do presente Empréstimo. </p>
<p>d)O Devedor concede plenos poderes ao Credor para transferir dados de garantia, 
do local habitual para quaisquer outros lugares que o Credor entender, proceder à 
venda dos bens pelo preço que julgar conveniente, e se fazer pagar, sem necessidade de 
recorrer a quaisquer instâncias jurídicas, policias e ou outras de administração da Justiça.</p> 
<p>e)Os bens dados de Garantias poderão ser confiscados e vendidos após 05 (cinco) dias de 
    Incumprimento, e o montante resultante de venda reverter-se-á a favor do Credor, na sua totalidade. </p>
<p>f)O devedor será notificado pela venda dos bens, sendo que, caso o valor da venda dos bens
     confiscados não ser suficiente para saldar o valor da divida (capital e juro), o Devedor, 
     autoriza, ao Credor a confiscar outros bens pela diferença e os mesmo poderão ser vendidos após 
     05 (cinco) dias a contar da data da Confiscação. </p>

<p> <strong> Único:</strong></p> 
<p>Considera-se incumprimento o não pagamento total ou parcial das prestações vencidas, acrescidas 
    de juros de mora, calculados nos termos deste contrato, a partir de um (01) dia depois de qualquer
     data de pagamento. 
<p>Nestas condições, o Credor recorrerá à execução dos bens de garantia prestadas irrevogavelmente. </p>

<p style="text-align: center;"> <strong> Artigo 6° </strong></p>
<p style="text-align: center;"> <strong> (Despesas)  </strong></p>

<p>1. São por conta do devedor as seguintes despesas: </p> 
<p>A.Despesas de preparo – 3% do valor desembolsado, sendo o mínimo cobrável de 200.00MT </p>
<p>B.Seguro de morte ou invalidez total- 0.0% do valor desembolsado </p>
<p>2. Será cobrado ao cliente em mora 10% do valor em dívida como honorários do 
    advogado sempre que este intervir na recuperação do crédito. </p>

    <p style="text-align: center;"> <strong> Artigo 7° </strong></p>
<p style="text-align: center;"> <strong> (Notificações)  </strong></p>

<p>Quaisquer notificações ou comunicação formal ao abrigo deste contrato, podem ser 
    efectuadas por carta enviada ao domicilio das partes ou por E-mail e ou por SMS para números das partes.</p> 

    <p style="text-align: center;"> <strong> Artigo 8° </strong></p>
<p style="text-align: center;"> <strong> (Resolução de conflitos)   </strong></p> 

<p>Quaisquer litígios que surgir de execução do presente contrato, serão resolvidos
     amigavelmente entre as partes. Na ausência de entendimento recorrer-se- á ao Tribunal
      Judicial da Cidade de Maputo. </p>
      <p style="text-align: center;"> <strong> Artigo 9° </strong></p>
<p style="text-align: center;"> <strong> (Caducidade)  </strong></p>
 
<p>O presente contrato será considerado extinto, única e exclusivamente, após o pagamento integral dos valores devidos, de acordo com o conceituado no presente contrato. </p>
<p>Assinado em Maputo em <?php $release_date = date('Y-m-d'); echo strftime("%d de %B de %Y", strtotime($release_date)); ?>, em dois exemplares, em língua Portuguesa de igual fé, devidamente assinados, reconhecida e carimbado pelo Credor(a), sendo um exemplar para cada uma das partes. </p>
      <p style="text-align:center;"> <strong> O Credor </strong></p>                                       
<p style="text-align:center;">_______________________   </p>                                               

<p style="text-align:center;"> <strong>O Devedor</strong></p>  
<p style="text-align: center;">_______________________  </p> 

    <script>
         window.onload = function() {
            window.print();
        };

        // Adiciona um ouvinte para o evento afterprint
        window.addEventListener('afterprint', function() {
            // Fecha automaticamente a janela após a impressão
            window.close();
        });
    </script>

</body>
</html>
