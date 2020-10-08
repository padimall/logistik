<?php 

include('../../assets/phpqrcode/qrlib.php');

        
$param = $_GET['id']; // remember to sanitize that - it is user input!
ob_start("callback");
$codeText = $param;
$debugLog = ob_get_contents();
ob_end_clean();
QRcode::png($codeText);