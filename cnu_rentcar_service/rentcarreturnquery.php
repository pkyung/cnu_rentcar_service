<?php
$tns = "
(DESCRIPTION=
    (ADDRESS_LIST=
        (ADDRESS=(PROTOCOL=TCP)(HOST=localhost)(PORT=1521))
    )
    (CONNECT_DATA=
        (SERVICE_NAME=XE)
    )
)
";
$url = "oci:dbname=".$tns.";charset=utf8";
$username = 'd202102682';
$password = 'wp4wldur4';

session_start();
$cno = $_SESSION['cno'];
$cname = $_SESSION['cname'];

$licensePlateNo = $_GET["licensePlateNo"];
$daterented = $_GET['daterented'];
$returndate = $_GET['returndate'];
$payment = $_GET['payment'];

try {
    $conn = new PDO($url, $username, $password);
} catch (PDOException $e) {
    echo("에러 내용: ".$e -> getMessage());
}
// rentcar 날짜 정보와 대여 정보를 null로 바꾼다
$stmt = $conn -> prepare("UPDATE RENTCAR SET DATERENTED=NULL, RETURNDATE=NULL, CNO=NULL WHERE LICENSEPLATENO = :licensePlateNo");
$stmt -> execute(array(':licensePlateNo' => $licensePlateNo));

// 이전 대여 정보에 해당 결제 정보를 넣는다
$stmt = $conn -> prepare("INSERT INTO PREVIOUSRENTAL(LICENSEPLATENO, DATERENTED, DATERETURNED, PAYMENT, CNO) VALUES(:licensePlateNo, TO_DATE(:daterented), TO_DATE(:returndate), :payment, :cno)");
$stmt -> execute(array(':daterented' => $daterented, ':returndate' => $returndate, ':licensePlateNo' => $licensePlateNo, ':cno' => $cno, ":payment" => $payment));

echo "<script>alert('" . $payment . " 원 결제가 완료되었습니다')</script>";

?>
<?php
// 메일 보내는 과정
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer-master/src/Exception.php';
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
//SMTP::DEBUG_OFF = off (for production use)
//SMTP::DEBUG_CLIENT = client messages
//SMTP::DEBUG_SERVER = client and server messages
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
//Use `$mail->Host = gethostbyname('smtp.gmail.com');`
//if your network does not support SMTP over IPv6,
//though this may cause issues with TLS

//Set the SMTP port number:
// - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
// - 587 for SMTP+STARTTLS
$mail->Port = 465;

//Set the encryption mechanism to use:
// - SMTPS (implicit TLS on port 465) or
// - STARTTLS (explicit TLS on port 587)
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

//Whether to use SMTP authentication
$mail->SMTPAuth = true;
$mail->CharSet    = "EUC-KR";
$mail->CharSet = PHPMailer::CHARSET_UTF8;
$mail->Encoding   = "base64";
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = '2dmsrud2002@gmail.com';

//Password to use for SMTP authentication
$mail->Password = 'kogwilkqubuminhj';

//Set who the message is to be sent from
//Note that with gmail you can only use your account address (same as `Username`)
//or predefined aliases that you have configured within your account.
//Do not use user-submitted addresses in here
$mail->setFrom('2dmsrud2002@naver.com', 'cnu rentcar service');

//Set who the message is to be sent to
$mail->addAddress('2dmsrud2002@naver.com', $cname);

//Set the subject line
$mail->Subject = ('cnu rentcar service 반납 결제 완료 메일');

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($daterented . '~' . $returndate.'동안 '. $payment . '원 결제 완료되었습니다');


//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}

//Section 2: IMAP
//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}