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
$startdate = $_GET["startdate"];

try {
    $conn = new PDO($url, $username, $password);
} catch (PDOException $e) {
    echo("에러 내용: ".$e -> getMessage());
}
// licensePlateNo와 startdate를 찾아 해당 예약 정보를 취소한다
$stmt = $conn -> prepare("DELETE FROM reservation 
WHERE reservation.licenseplateno = :licensePlateNo
AND reservation.startdate = to_date(:startdate, 'YY/MM/DD')");
$stmt -> execute(array(':licensePlateNo' => $licensePlateNo, ':startdate' => $startdate));

echo "<script>alert('차량번호 : " . $licensePlateNo . ", 대여 시작 날짜 : " . $startdate . "에 대한 예약이 취소되었습니다')</script>";

?>