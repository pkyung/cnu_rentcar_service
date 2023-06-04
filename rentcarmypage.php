<?php


?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>cnu rentcar service - my page</title>
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
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
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            my page
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a id="cancel" class="dropdown-item" href="#">cancel</a></li>
            <li><a id="previous" class="dropdown-item" href="#">previous</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php
  session_start();
  $cname = $_SESSION['cname'];
?>
<br>
<h4><u><?=$cname ?></u> 님 환영합니다</h4>

<br>
<table class="table" id="seartable">
</table>
    
    <script src="rentcarcancle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>