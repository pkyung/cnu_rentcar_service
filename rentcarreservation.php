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


try {
    $conn = new PDO($url, $username, $password);
} catch (PDOException $e) {
    echo("에러 내용: ".$e->getMessage());
}


$result = "<thead>
                <tr>
                    <th>model name</th>
                    <th>licensePlateno</th>
                    <th>start date</th>
                    <th>end date</th>
                    <th>reservedate</th>
                    <th>예약 취소</th>
                </tr>
            </thead>
            <tbody>";
// cno를 통해 예약 정보를 찾아 result에 저장하여 뿌린다
$stmt = $conn->prepare("SELECT R.LICENSEPLATENO, RC.MODELNAME, R.STARTDATE, R.ENDDATE, R.RESERVEDATE
FROM RESERVATION R, RENTCAR RC
WHERE R.LICENSEPLATENO = RC.LICENSEPLATENO
AND R.CNO = :cno
ORDER BY R.STARTDATE DESC");
$stmt->execute(array(':cno' => $cno));
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result .= "<tr><td>" . $row["MODELNAME"] . "</td>";
    $result .= "<td>" . $row["LICENSEPLATENO"] . "</td>";
    $result .= "<td>" . $row["STARTDATE"] . "</td>";
    $result .= "<td>" . $row["ENDDATE"] . "</td>";
    $result .= "<td>" . $row["RESERVEDATE"] . "</td>";
    $result .= "<td><a class='btn btn-outline-secondary' href='rentcarreservedelete.php?licensePlateNo={$row["LICENSEPLATENO"]}&startdate={$row["STARTDATE"]}'>예약 취소</a></td></tr>";
}

$result .= "</tbody>";

echo $result;
?>

