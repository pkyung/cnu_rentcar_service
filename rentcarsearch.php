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

// $stmt = $conn -> prepare("SELECT CNO, PASSWD, NAME FROM CUSTOMER WHERE CNO like ?");
// $stmt -> execute(array($id));
// $row = $stmt -> fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>cnu rentcar service - search</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="datestyle.css" rel="stylesheet">
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
            <a class="nav-link active" href="#">rentcar search</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="rentcarreturn.php">rentcar return</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="rentcarmypage.php">my page</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>
    <br>
    <form>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    <input name="type" type="checkbox" class="btn-check" id="btncheck1" value="전체" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btncheck1">전체</label>

                    <input  name="type" type="checkbox" class="btn-check" id="btncheck2" value="전기차" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btncheck2">전기차</label>

                    <input  name="type" type="checkbox" class="btn-check" id="btncheck3" value="소형" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btncheck3">소형</label>

                    <input  name="type" type="checkbox" class="btn-check" id="btncheck4" value="대형" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btncheck4">대형</label>

                    <input  name="type" type="checkbox" class="btn-check" id="btncheck5" value="SUV" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btncheck5">SUV</label>

                    <input  name="type" type="checkbox" class="btn-check" id="btncheck6" value="승합" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btncheck6">승합</label>
                    </div>
                </div>
                <div class="col">
                    <div class="input_date_box">
                        <span>대여 시작 : </span>
                        <input id="date1" type="date">
                        <span> ~ 대여 종료 : </span>
                        <input id="date2" type="date">
                    </div>
                </div>
                <div class="col-2">
                    <button id="search" type="button" class="btn btn-secondary">검색</button>
                </div>
            </div>
        </div>
    </form>
    <br><br><br>
    <table class="table" id="searchtable">
    </table>
    <script src="rentcarsearchtable.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>