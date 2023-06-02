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
$arr = $_POST["arr"];
$date1 = $_POST["date1"];
$date2 = $_POST["date2"];

try {
    $conn = new PDO($url, $username, $password);
} catch (PDOException $e) {
    echo("에러 내용: ".$e->getMessage());
}


$result = "<thead>
                <tr>
                    <th>licensePlateno</th>
                    <th>model Name</th>
                    <th>vehicle Type</th>
                    <th>rent Rate Per Day</th>
                    <th>fuel</th>
                    <th>number of seats</th>
                </tr>
            </thead>
            <tbody>";

for ($i = 0; $i < count($arr) - 1; $i++) {
    $stmt = $conn->prepare("SELECT R.LICENSEPLATENO AS LICENSEPLATENO, CM.MODELNAME AS MODELNAME, CM.VEHICLETYPE AS VEHICLETYPE, CM.RENTRATEPERDAY AS RENTRATEPERDAY, CM.FUEL AS FUEL, CM.NUMBEROFSEATS AS NUMBEROFSEATS FROM CARMODEL CM, RENTCAR R WHERE CM.MODELNAME = R.MODELNAME AND CM.VEHICLETYPE LIKE ?");
    $stmt->execute(array($arr[$i]));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result .= "<tr><td>" . $row["LICENSEPLATENO"] . "</td>";
        $result .= "<td>" . $row["MODELNAME"] . "</td>";
        $result .= "<td>" . $row["VEHICLETYPE"] . "</td>";
        $result .= "<td>" . $row["RENTRATEPERDAY"] . "</td>";
        $result .= "<td>" . $row["FUEL"] . "</td>";
        $result .= "<td>" . $row["NUMBEROFSEATS"] . "</td></tr>";
    }
}
$result .= "</tbody></table>";

echo $result;
?>