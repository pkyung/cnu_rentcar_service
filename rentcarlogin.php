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

$id = $_GET['id'] ?? '';
$pw = $_GET['pw'] ?? '';

try {
    $conn = new PDO($url, $username, $password);
} catch (PDOException $e) {
    echo("에러 내용: ".$e -> getMessage());
}

$stmt = $conn -> prepare("SELECT CNO, PASSWD, NAME FROM CUSTOMER WHERE CNO like ?");
$stmt -> execute(array($id));
$row = $stmt -> fetch(PDO::FETCH_ASSOC);
if ($row != null) {
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