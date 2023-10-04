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

try {
    $conn = new PDO($url, $username, $password);
} catch (PDOException $e) {
    echo("에러 내용: ".$e -> getMessage());
}
session_start();
$cno = $_SESSION["cno"];
$cname = $_SESSION["cname"];

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>cnu rentcar service - return</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
  <!--
    navigation bar
-->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">cnu rentcar service</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
          <a class="nav-link" href="rentcarsearch.php">rentcar search</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="rentcarreturn.php">rentcar return</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="rentcarmypage.php">my page</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin.php">root page</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <br>

  <h4><u><?=$_SESSION['cname'] ?></u> 님 결제를 진행해주세요</h4>

  <table class="table" id="returntable">
    <thead>
      <tr>
        <th>licensePlateno</th>
        <th>model Name</th>
        <th>vehicle Type</th>
        <th>daterented</th>
        <th>returndate</th>
        <th>rent rate</th>
        <th>반납</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // cno를 통해 해당 고객의 대여 정보를 검색하여 뿌린다
        $stmt = $conn -> prepare("SELECT RC.LICENSEPLATENO AS LICENSEPLATENO, CM.MODELNAME AS MODELNAME, CM.VEHICLETYPE AS VEHICLETYPE, RC.DATERENTED AS DATERENTED, RC.RETURNDATE AS RETURNDATE, CM.RENTRATEPERDAY * (RC.RETURNDATE - RC.DATERENTED) AS RENTRATE
        FROM RENTCAR RC JOIN CARMODEL CM
        ON CM.MODELNAME = RC.MODELNAME
        WHERE CNO = :cno");
        $stmt -> execute(array($cno));
        while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
      ?>
      <tr>
        <td>
          <?= $row['LICENSEPLATENO']?>
        </td>
        <td>
          <?= $row['MODELNAME'] ?>
        </td>
        <td>
          <?= $row['VEHICLETYPE'] ?>
        </td>
        <td>
          <?= $row['DATERENTED'] ?>
        </td>
        <td>
          <?= $row['RETURNDATE'] ?>
        </td>
        <td>
          <?= $row['RENTRATE'] ?>
        </td>
        <td>
          <!--
            버튼을 누르면 rentcarreturnquery.php로 이동하여 반납 쿼리를 실행한다
        -->
          <a href='rentcarreturnquery.php?licensePlateNo=<?= $row['LICENSEPLATENO'] ?>&daterented=<?= $row['DATERENTED'] ?>&returndate=<?= $row['RETURNDATE'] ?>&payment=<?= $row['RENTRATE'] ?>' class="btn btn-outline-secondary">결제</a>
        </td>
      </tr>
        <?php
        }
        ?>
    </tbody>
  </table>
    

    <script src="rentcarcancle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>