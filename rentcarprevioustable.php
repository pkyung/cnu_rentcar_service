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
                    <th>date rendted</th>
                    <th>datereturned</th>
                    <th>paymnet</th>
                </tr>
            </thead>
            <tbody>";


$stmt = $conn->prepare("SELECT RC.MODELNAME, P.LICENSEPLATENO, P.DATERENTED, P.DATERETURNED, P.PAYMENT
FROM PREVIOUSRENTAL P, RENTCAR RC
WHERE RC.LICENSEPLATENO = P.LICENSEPLATENO
AND P.CNO = :cno
ORDER BY P.DATERENTED DESC");
$stmt->execute(array(':cno' => $cno));
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result .= "<tr><td>" . $row["MODELNAME"] . "</td>";
    $result .= "<td>" . $row["LICENSEPLATENO"] . "</td>";
    $result .= "<td>" . $row["DATERENTED"] . "</td>";
    $result .= "<td>" . $row["DATERETURNED"] . "</td>";
    $result .= "<td>" . $row["PAYMENT"] . "</td></tr>";
}

$result .= "</tbody>";

echo $result;
?>

