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
$cname = $_SESSION['cname'];

try {
    $conn = new PDO($url, $username, $password);
    if ($cname != 'root') {
        echo "<script>alert('접근불가능한 페이지입니다')</script>";
        echo '<script>location.href="../cnu_rentcar_service/rentcarsearch.php"</script>';
        
    }
} catch (PDOException $e) {
    echo("에러 내용: ".$e -> getMessage());
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
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
          <a class="nav-link" href="rentcarreturn.php">rentcar return</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="rentcarmypage.php">my page</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">root page</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<br>
<h4> 통계 자료</h4>
<br>

<h5>예약 중인 차량 내역</h5>
<table class="table">
<thead>
      <tr>
        <th>model name</th>
        <th>licensePlateNo</th>
        <th>daterented</th>
        <th>returndate</th>
        <th>name</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $stmt = $conn -> prepare("SELECT R.MODELNAME, R.LICENSEPLATENO, R.DATERENTED, R.RETURNDATE, C.NAME
        FROM RENTCAR R JOIN RESERVATION RS
        ON R.CNO = RS.CNO
        JOIN CUSTOMER C
        ON R.CNO = C.CNO
        ORDER BY DATERENTED DESC");
        $stmt -> execute(array());
        while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
      ?>
      <tr>
        <td>
          <?= $row['MODELNAME']?>
        </td>
        <td>
          <?= $row['LICENSEPLATENO'] ?>
        </td>
        <td>
          <?= $row['DATERENTED'] ?>
        </td>
        <td>
          <?= $row['RETURNDATE'] ?>
        </td>
        <td>
          <?= $row['NAME'] ?>
        </td>
      </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<br>
<h5>모델 별 예약 횟수</h5>
<table class="table">
<thead>
      <tr>
        <th>model name</th>
        <th>예약 횟수</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $stmt = $conn -> prepare("SELECT NVL(MODELNAME,'전체') MODELNAME, COUNT(MODELNAME) COUNT
        FROM RENTCAR C  LEFT OUTER JOIN RESERVATION R 
        ON C.LICENSEPLATENO = R.LICENSEPLATENO
         LEFT OUTER JOIN PREVIOUSRENTAL PR
        ON C.LICENSEPLATENO = PR.LICENSEPLATENO
        GROUP BY ROLLUP(MODELNAME)");
        $stmt -> execute(array());
        while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
      ?>
      <tr>
        <td>
          <?= $row['MODELNAME']?>
        </td>
        <td>
          <?= $row['COUNT'] ?>
        </td>
      </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<br>
<br>
<h5>고객들이 애용하는 차량 랭킹</h5>
<table class="table">
<thead>
      <tr>
        <th>model name</th>
        <th>많이 쓴 차량 랭킹</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $stmt = $conn -> prepare("SELECT R.MODELNAME, ROW_NUMBER() OVER(ORDER BY COUNT(R.MODELNAME) DESC) AS RANK
        FROM RENTCAR R LEFT OUTER JOIN RESERVATION RS
        ON R.LICENSEPLATENO = RS.LICENSEPLATENO
        LEFT OUTER JOIN PREVIOUSRENTAL P
        ON R.LICENSEPLATENO = P.LICENSEPLATENO
        GROUP BY R.MODELNAME");
        $stmt -> execute(array());
        while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
      ?>
      <tr>
        <td>
          <?= $row['MODELNAME']?>
        </td>
        <td>
          <?= $row['RANK'] ?>
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