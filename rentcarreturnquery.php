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

$licensePlateNo = $_GET["licensePlateNo"];
$daterented = $_GET['daterented'];
$returndate = $_GET['returndate'];
$payment = $_GET['payment'];

try {
    $conn = new PDO($url, $username, $password);
} catch (PDOException $e) {
    echo("에러 내용: ".$e -> getMessage());
}

$stmt = $conn -> prepare("UPDATE RENTCAR SET DATERENTED=NULL, RETURNDATE=NULL, CNO=NULL WHERE LICENSEPLATENO = :licensePlateNo");
$stmt -> execute(array(':licensePlateNo' => $licensePlateNo));

$stmt = $conn -> prepare("INSERT INTO PREVIOUSRENTAL(LICENSEPLATENO, DATERENTED, DATERETURNED, PAYMENT, CNO) VALUES(:licensePlateNo, TO_DATE(:daterented), TO_DATE(:returndate), :payment, :cno)");
$stmt -> execute(array(':daterented' => $daterented, ':returndate' => $returndate, ':licensePlateNo' => $licensePlateNo, ':cno' => $cno, ":payment" => $payment));

echo "<script>alert('" . $payment . " 원 결제가 완료되었습니다')</script>";

?>