<?php
    include 'components/authentication.php';
    $sql = "SELECT * FROM user where user_username='$user_username'";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database)); 
    $rws = mysqli_fetch_array($result);
    
    
    require('award/fpdf/force_justify.php');
    
     $name = $rws["user_firstname"];
     $lname = $rws["user_lastname"];
     $father= $rws["user_fathername"];
     $dob= $rws["user_dob"];
     $college= $rws["user_college"];
date_default_timezone_set('Asia/Calcutta');
     $date = date('d/m/Y h:i:s a', time());
     $serial= $rws["user_id"];
     $joiningdate= $rws["user_joiningdate"];
     $deadline= $rws["user_deadline"];
     $roll= $rws["user_username"];
     $duration= $rws["user_duration"];
     $topics= $rws["user_assn"];
     $email = $rws["user_email"];


    $pdf = new FPDF('L');
    $pdf -> AddPage();
    $pdf->Image('award/INTERNSHIP CERTIFICATE FORMAT.jpg', -2, -1,300,0);
    $pdf->SetDrawColor(0,80,180);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,30,"                $serial",0,20);
    $pdf->Ln(70);
    $pdf->SetFont('Arial','B',25);
    $pdf->Cell(0,6,"$name $lname",0,1,'C');
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,50,"Joined On: $joiningdate and Completed On: $deadline",0,0,'C');
    $pdf->Ln(35);
    $pdf->Cell(50,20,"                            $date",20,10);

// email stuff (change data below)
$to = $email; 
$from = "info@advocatespedia.com"; 
$subject = "Certificate of Internship"; 
$message = "
<p>To</p>

<p>$name</p>
<p>$college</p>
<p>Roll Number: $roll</p>

<p>Dear $name</p>

<p>I am delighted & excited to inform you that your certificate has been granted.</p>


<p>Congratulations!</p>


<p>Please see the attachment.</p>

<p>Adv. Faiyaz Khalid</p>
<p>President</p>
<p>Advocates Pedia Foundation</p>



";
// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
$filename = "$name.pdf";

// encode data (puts attachment in proper format)
$pdfdoc = $pdf->Output("", "S");
$attachment = chunk_split(base64_encode($pdfdoc));

// main header
$headers  = "From: ".$from.$eol;
$headers .= "MIME-Version: 1.0".$eol; 
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

// no more headers after this, we start the body! //

$body = "--".$separator.$eol;
$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
$body .= "This mail is regarding Certificate of Internship.".$eol;

// message
$body .= "--".$separator.$eol;
$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$body .= $message.$eol;

// attachment
$body .= "--".$separator.$eol;
$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
$body .= "Content-Transfer-Encoding: base64".$eol;
$body .= "Content-Disposition: attachment".$eol.$eol;
$body .= $attachment.$eol;
$body .= "--".$separator."--";

// send message
mail($to, $subject, $body, $headers);

$filename="award/internshipcertificate/$roll.pdf";
$pdf->Output($filename,'F');


header("location: award-recommendation.php");
?>


      

<?php include 'components/authentication.php' ?>
<?php include 'components/session-check.php' ?>


<?php 
    if($_GET["request"]=="profile-update" && $_GET["status"]=="success"){
        $dialogue="Your profile update was successful! ";
    }
    else if($_GET["request"]=="profile-update" && $_GET["status"]=="unsuccess"){
        $dialogue="Your profile update was not at all successful! ";
    }
    else if($_GET["request"]=="login" && $_GET["status"]=="success"){
        $dialogue="Welcome back again! ";
    }
?>

<?php          
    $sql = "SELECT * FROM user where user_username='$user_username'";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database)); 
    $rws = mysqli_fetch_array($result);
?>  



