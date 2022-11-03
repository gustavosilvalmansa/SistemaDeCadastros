<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);
// Inicialize a sessão
session_start();
 
require "vendor/autoload.php";


// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    die;
}

$email = $_POST['email'];
$docNome = $_POST['docNome'];
$descNome = $_POST['descNome'];
$motivo = $_POST['motivo'];
$icp = $_POST['icp'];
$data = date("Y-m-d");

if(isset($_FILES['arquivo']['error']) && $_FILES['arquivo']['error']=='UPLOAD_ERR_OK'){
    $name    = basename($_FILES['arquivo']['name']);
    $ext     = end(explode('.', $name));
    $source = $move_to = "assinados/86521551000/meusAssinados/".preg_replace('/[^a-zA-Z0-9.-]/s', '_',$name);
    $info    = getimagesize($_FILES['arquivo']['tmp_name']);
    move_uploaded_file($_FILES['arquivo']['tmp_name'],$move_to);
}


// create new PDF document
$pdf = new setasign\Fpdi\TcpdfFpdi('P', 'mm', 'A4');

// set document information
$pdf->SetCreator('PDF_CREATOR');
$pdf->SetAuthor('Invia Sign');
$pdf->SetTitle('Assinatura de documento');
$pdf->SetSubject('Assinador Invia');
$pdf->SetKeywords('Invia, Assinador, Sign, documento, Assinatura');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 052', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/por.php')) {
	require_once(dirname(__FILE__).'/lang/por.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

/*
NOTES:
 - To create self-signed signature: openssl req -x509 -nodes -days 365000 -newkey rsa:1024 -keyout tcpdf.crt -out tcpdf.crt
 - To export crt to p12: openssl pkcs12 -export -in tcpdf.crt -out tcpdf.p12
 - To convert pfx certificate to pem: openssl pkcs12 -in tcpdf.pfx -out tcpdf.crt -nodes
*/
$pdf->AddPage();
$pages = $pdf->setSourceFile($source);
$page = $pdf->ImportPage(1);
$pdf->useTemplate( $page, 0, 0 );

/*for ($i = 1; $i <= $pages; $i++) {

    $pdf->AddPage();

    $pdf->importPage($i);
   
    $pdf->useTemplate($i);
}
*/

// set certificate file
$certificate ="file://".realpath("certificados\86521551000\cert.crt");//Cert CRT
$chavepriv ="file://".realpath("certificados\86521551000\cert.key"); //Private KEY
$cert_store = file_get_contents('certificados\86521551000\certificado.p12'); //CERTIFICADO ICP PATH

//Verifica se foi possivel ler o certificado
if (!$cert_store ) {
     echo "Error: Unable to read the cert file\n";
     exit;
}
     
//Pega dados do certificado
if (openssl_pkcs12_read($cert_store, $cert_info, "123456")) {
    //echo "Certificate Information\n"."<br>";
    $cert = $cert_info["cert"];
    $key = $cert_info["pkey"];
    $chain = $cert_info["extracerts"];
} else {
    echo "Error: Unable to read the cert store.\n";
    exit;
}


// set additional information
$info = array(
	'Name' => $_SESSION['nomecompleto'],
	'Location' => 'InviaSigner',
	'Reason' => 'Comprovando autenticidade',
	'ContactInfo' => 'invianf.com.br',
	);

// set document signature


/* NÃO ICP
$pdf->setSignature($certificate, $chavepriv, '123456', '', 2, '', 'A'); 
*/

//Assina  ICP PDF
$pdf->setSignature($cert, $key, '123456', '', 2, '', 'A'); 

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

// print a line of text
$text = 'This is a <b color="#FF0000">digitally signed document</b> using the default (example) <b>tcpdf.crt</b> certificate.<br />To validate this signature you have to load the <b color="#006600">tcpdf.fdf</b> on the Arobat Reader to add the certificate to <i>List of Trusted Identities</i>.<br /><br />For more information check the source code of this example and the source code documentation for the <i>setSignature()</i> method.<br /><br /><a href="http://www.tcpdf.org">www.tcpdf.org</a>';
$pdf->writeHTML($text, true, 0, true, 0);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// *** set signature appearance ***

// create content for signature (image and/or text)
$pdf->Image('dist/img/selo.jpg', 180, 60, 15, 15, 'JPG');

// define active area for signature appearance
$pdf->setSignatureAppearance(180, 60, 15, 15);


$nome_do_arquivo = $name."_".date("Y.m.d_H_i_s").".pdf";
$nomesemespaco = str_replace(" ", "", $nome_do_arquivo); 
$localizacao = "/home/gusta037/public_html/webpki/$empresa/assinado";
$salva_arquivo = $localizacao."/".$nomesemespaco;
$doc_url = "https://invianf.com.br/webpki/$empresa/assinado/$nomesemespaco";

//Close and output PDF document
$pdf->Output($salva_arquivo, 'I');

$stmt = $pdo->prepare("INSERT INTO tb_documentosassinados (desnome, desdescricao, desmotivo,boolicp,descaminho, dtassinatura)
VALUES (:desnome, :desdescricao, :desmotivo, :boolicp,:descaminho, :dtassinatura)");
$insert = $stmt->execute(array(
    ':desnome' => $docNome,
    ':desdescricao' => $descNome,
    ':desmotivo' => $motivo,
    ':boolicp' => $icp,
    ':descaminho' => $doc_url,
    ':dtassinatura'=>$data
  ));

if($insert){
    //header("location: meusAssinados.php?assinado=1");
 }

?>