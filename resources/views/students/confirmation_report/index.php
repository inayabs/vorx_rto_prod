<?php 

date_default_timezone_set("Asia/Singapore");

// include autoloader
require_once 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

function pdf_create($html, $filename, $paper, $orientation, $stream=TRUE){
	$dompdf = new DOMPDF();
	$dompdf -> set_paper ($paper, $orientation);
	$dompdf -> load_html ($html);
	$dompdf -> render();
	$dompdf -> stream ($filename.".pdf", array("Attachment" => false));
}

$filename = 'eti_document' ;
$dompdf = new DOMPDF();

// ETI Documents
$html = file_get_contents('confirmation-report.php'); // Sampling
// $html = file_get_contents('parallel_enrolment_verification_form.php'); // Parallel Enrolment Verification Form
// $html = file_get_contents('international_student_enrolment_form.php'); // International Student Enrolment Form
// $html = file_get_contents('rpl_application_form.php'); // RPL Application Form
// $html = file_get_contents('application_for_release_letter.php'); // Application for release Letter
// $html = file_get_contents('credit_transfer_application_form.php'); // Credit Transfer Application Form
// $html = file_get_contents('application_for_deferment_suspension_cancellation_withdrawal.php'); // Application for Deferment Suspension Cancellation Withdrawal
// $html = file_get_contents('payment_authorisation_form.php'); // Payment Authorization Form
// $html = file_get_contents('pre_training_review.php'); // Pre-Training Review
// $html = file_get_contents('lln_test.php'); // Language, Literacy and Numeracy (LLN) Test

pdf_create ($html, $filename, 'A4', 'landscape');

?>