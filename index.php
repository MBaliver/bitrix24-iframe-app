<?php

define("PORTAL_DOMAIN", "rivetweb.bitrix24.ru");

header("Content-type: text/html; charset=utf-8");

if (PORTAL_DOMAIN != $_REQUEST["DOMAIN"] || empty($_POST["AUTH_ID"])) {
    die("error: Access denied.");
}

?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>

<iframe src="https://www.google.com.br/" width="100%" height="800px" frameborder="0"></iframe>

</body>
</html>
