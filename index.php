<?php

define("PORTAL_DOMAIN", "rivetweb.bitrix24.ru");

header("Content-type: text/plain;charset=utf-8");

if (PORTAL_DOMAIN != $_REQUEST["DOMAIN"] || empty($_POST["AUTH_ID"])) {
	die("error: Access denied.");
}

echo "<pre>";

var_dump(
	$_REQUEST,
	dirname($_SERVER["PHP_SELF"])
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://" . PORTAL_DOMAIN . "/rest/user.current.json?auth=" . $_REQUEST["AUTH_ID"]);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);

print_r(json_decode($result));

return;

$bitrix24 = new Bitrix24([
	// client_id do aplicativo
	"CLIENT_ID" => "",

	// client_secret do aplicativo
	"CLIENT_SECRET" => "",

	"PATH" => dirname($_SERVER["PHP_SELF"]),

	// escopo do aplicativo
	//"SCOPE" => "crm,entity,user,calendar,log,im,disk",

	// protocolo utilizado. deve ser https
	"PROTOCOL" => "https",

	"PORTAL" => "example.bitrix24.ru",
]);

$bitrix24->setAccessToken($_POST["AUTH_ID"]);

$getBlogPosts = function ($next = 0) use ($bitrix24) {
	$params = [];
	if (!empty($next)) {
		$params["start"] = $next;
	}
	$res = $bitrix24->api("log.blogpost.get", $params);
	if (empty($res["result"])) {
		return;
	}
	$items = [];
	foreach ($res["result"] as $item) {
		$items[] = $item;
	}
	return [$items, !empty($res["next"])? $res["next"] : null];
};
?>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>

<iframe src="https://dohkotechnology.bitrix24.site/helpdesk/" width="100%" height="600px"></iframe>

<?php foreach ($getBlogPosts()[0] as $post) { ?>

	<div>
		<div>
			<b><?= $post["TITLE"] ?></b> <time><?= $post["DATE_PUBLISH"] ?></time>
		</div>
		<div>
			<?= $post["DETAIL_TEXT"] ?>
		</div>
	</div>
	<br>
	<hr>
	<br>

<?php } ?>

</body>
</html>
