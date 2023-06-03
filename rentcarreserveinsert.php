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

$date1 = $_GET["date1"];
$date2 = $_GET["date2"];

try {
    $conn = new PDO($url, $username, $password);
} catch (PDOException $e) {
    echo("에러 내용: ".$e -> getMessage());
}

$stmt = $conn -> prepare("INSERT INTO RESERVATION(LICENSEPLATENO, RESERVEDATE, STARTDATE, ENDDATE, CNO) VALUES(:licensePlateNo, TO_DATE(SYSDATE, 'YYYY.MM.DD'), :date1, :date2, :cno)");
$stmt -> execute(array(':date1' => $date1, ':date2' => $date2, ':licenstPlateNo' => $licensePlateNo, ':cno' => $cno));

echo "<script>alert(" . $date1 . " ~ " . $date2 . ")</script>";

?>