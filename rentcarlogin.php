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


// get 방식으로 id, pw받아온다
$id = $_GET['id'] ?? '';
$pw = $_GET['pw'] ?? '';

try {
    $conn = new PDO($url, $username, $password);
} catch (PDOException $e) {
    echo("에러 내용: ".$e -> getMessage());
}


   // rentcar 내역 중 현재 시간보다 작은 것들은 다 이전 기록에 넣음
   $sql1 = "INSERT INTO PREVIOUSRENTAL (LICENSEPLATENO, DATERENTED, DATERETURNED, PAYMENT, CNO)
   SELECT RC.LICENSEPLATENO, RC.DATERENTED, RC.RETURNDATE, ((RC.RETURNDATE - RC.DATERENTED) * CM.RENTRATEPERDAY) AS PAY, RC.CNO
   FROM RENTCAR  RC, CARMODEL CM 
   WHERE CM.MODELNAME = RC.MODELNAME
   AND RC.RETURNDATE < TO_DATE(SYSDATE, 'YY/MM/DD')";

   // rentcar 중 현재 시간보다 작은 것들은 다 삭제
   $sql2 = "UPDATE RENTCAR
   SET DATERENTED = NULL,
   RETURNDATE = NULL,
   CNO = NULL
   WHERE RETURNDATE < TO_DATE(SYSDATE, 'YY/MM/DD')";

   //reserve 중 현재 시간에 포함된 것 가져오기
   $sql3 = "UPDATE RENTCAR 
   SET 
   DATERENTED = (SELECT R.STARTDATE FROM RESERVATION R
                   WHERE R.LICENSEPLATENO = RENTCAR.LICENSEPLATENO
                   AND TO_DATE(STARTDATE) <= TO_DATE(SYSDATE, 'YY/MM/DD')),
   RETURNDATE = (SELECT R.ENDDATE FROM RESERVATION R 
                   WHERE R.LICENSEPLATENO = RENTCAR.LICENSEPLATENO
                   AND TO_DATE(STARTDATE) <= TO_DATE(SYSDATE, 'YY/MM/DD')),
   CNO = (SELECT R.CNO FROM RESERVATION R
                   WHERE R.LICENSEPLATENO = RENTCAR.LICENSEPLATENO
                   AND TO_DATE(STARTDATE) <= TO_DATE(SYSDATE, 'YY/MM/DD'))
   WHERE CNO IS NULL";

   $sql4 = "DELETE FROM RESERVATION
   WHERE STARTDATE < TO_DATE(SYSDATE, 'YY/MM/DD')";
   
   $stmt1 = $conn->prepare($sql1);
   $stmt1->execute();
   $stmt2 = $conn->prepare($sql2);
   $stmt2->execute();
   $stmt3 = $conn->prepare($sql3);
   $stmt3->execute();
   $stmt4 = $conn->prepare($sql4);
   $stmt4->execute();

   // id가 cno와 같은 것 가져오기
$stmt = $conn -> prepare("SELECT CNO, PASSWD, NAME FROM CUSTOMER WHERE CNO like ?");
$stmt -> execute(array($id));
$row = $stmt -> fetch(PDO::FETCH_ASSOC);
if ($row != null) {
    // passwd 같은지 확인하고 rentcarsearch.php 파일로 이동한다
    if ($row['PASSWD'] === $pw) {
        session_start();
        $_SESSION["cno"] = $row['CNO'];
        $_SESSION["cname"] = $row['NAME'];
        echo $row['PASSWD'];
        echo "<script>location.href='rentcarsearch.php'</script>";
    } else {
        echo "비밀번호가 틀렸습니다";
    }
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>cnu rentcar service - login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <br>
    <div class="center">
        <h2>로그인 페이지</h2>
    </div>

    <form>
        <div>
            <div class="form-floating mb-3">
                <input name="id" id="id" type="text" class="form-control" id="floatingInput" value="<?= $id ?>" placeholder="id">
                <label for="floatingInput">id</label>
            </div>
            <div class="form-floating">
                <input id="pw" name="pw" type="password" class="form-control" id="floatingPassword" value="<?= $pw ?>" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
        </div>
        <br>
        <div class="center">
            <button type="submit" class="btn btn-outline-secondary">로그인</button>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>