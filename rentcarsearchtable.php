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
                    <th>예약</th>
                </tr>
            </thead>
            <tbody>";

for ($i = 0; $i < count($arr); $i++) {
    if ($arr[$i] == '전체') {
        $stmt = $conn->prepare("SELECT DISTINCT T.LICENSEPLATENO AS LICENSEPLATENO, CM.MODELNAME AS MODELNAME, CM.VEHICLETYPE AS VEHICLETYPE, CM.RENTRATEPERDAY AS RENTRATEPERDAY, CM.FUEL AS FUEL, CM.NUMBEROFSEATS AS NUMBEROFSEATS
        FROM (
            SELECT RC.LICENSEPLATENO, RC.MODELNAME
            FROM RENTCAR RC FULL OUTER JOIN RESERVATION R
            ON RC.LICENSEPLATENO = R.LICENSEPLATENO
            WHERE ((TO_DATE(:date1) < R.STARTDATE OR TO_DATE(:date2) > R.ENDDATE)
            OR R.STARTDATE IS NULL)
            AND ((TO_DATE(:date1) < RC.DATERENTED OR TO_DATE(:date2) > RC.RETURNDATE)
            OR RC.DATERENTED IS NULL)
        ) T, CARMODEL CM
        WHERE CM.MODELNAME = T.MODELNAME");
        $stmt->execute(array(':date1' => $date1, ':date2' => $date2));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result .= "<tr><td>" . $row["LICENSEPLATENO"] . "</td>";
            $result .= "<td>" . $row["MODELNAME"] . "</td>";
            $result .= "<td>" . $row["VEHICLETYPE"] . "</td>";
            $result .= "<td>" . $row["RENTRATEPERDAY"] . "</td>";
            $result .= "<td>" . $row["FUEL"] . "</td>";
            $result .= "<td>" . $row["NUMBEROFSEATS"] . "</td>";
            $result .= "<td><a class='btn btn-outline-secondary' href='rentcarreserveinsert.php?licensePlateNo={$row["LICENSEPLATENO"]}&date1={$date1}&date2={$date2}'>예약</a></td></tr>";
        }
    } else {
        $stmt = $conn->prepare("SELECT DISTINCT T.LICENSEPLATENO AS LICENSEPLATENO, CM.MODELNAME AS MODELNAME, CM.VEHICLETYPE AS VEHICLETYPE, CM.RENTRATEPERDAY AS RENTRATEPERDAY, CM.FUEL AS FUEL, CM.NUMBEROFSEATS AS NUMBEROFSEATS
        FROM (
            SELECT RC.LICENSEPLATENO, RC.MODELNAME
            FROM RENTCAR RC FULL OUTER JOIN RESERVATION R
            ON RC.LICENSEPLATENO = R.LICENSEPLATENO
            WHERE ((TO_DATE(:date1) < R.STARTDATE OR TO_DATE(:date2) > R.ENDDATE)
            OR R.STARTDATE IS NULL)
            AND ((TO_DATE(:date1) < RC.DATERENTED OR TO_DATE(:date2) > RC.RETURNDATE)
            OR RC.DATERENTED IS NULL)
        ) T, CARMODEL CM
        WHERE CM.MODELNAME = T.MODELNAME
        AND CM.VEHICLETYPE = :arr");
        $stmt->execute(array(':date1' => $date1, ':date2' => $date2, ':arr' => $arr[$i]));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result .= "<tr><td>" . $row["LICENSEPLATENO"] . "</td>";
            $result .= "<td>" . $row["MODELNAME"] . "</td>";
            $result .= "<td>" . $row["VEHICLETYPE"] . "</td>";
            $result .= "<td>" . $row["RENTRATEPERDAY"] . "</td>";
            $result .= "<td>" . $row["FUEL"] . "</td>";
            $result .= "<td>" . $row["NUMBEROFSEATS"] . "</td>";
            $result .= "<td><a class='btn btn-outline-secondary' href='rentcarreserveinsert.php?licensePlateNo={$row["LICENSEPLATENO"]}&date1={$date1}&date2={$date2}'>예약</a></td></tr>";
        }
    }
}
$result .= "</tbody>";

echo $result;
?>

