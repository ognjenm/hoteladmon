<?php session_start();
include_once 'GmailOath.php';
include_once 'Config.php';
$oauth =new GmailOath($consumer_key, $consumer_secret, $argarray, $debug, $callback);
$getcontact_access=new GmailGetContacts();



$request_token=$oauth->rfc3986_decode($_GET['oauth_token']);
$request_token_secret=$oauth->rfc3986_decode($_SESSION['oauth_token_secret']);
$oauth_verifier= $oauth->rfc3986_decode($_GET['oauth_verifier']);

$contact_access = $getcontact_access->get_access_token($oauth,$request_token, $request_token_secret,$oauth_verifier, false, true, true);

$access_token=$oauth->rfc3986_decode($contact_access['oauth_token']);
$access_token_secret=$oauth->rfc3986_decode($contact_access['oauth_token_secret']);
$contacts= $getcontact_access->GetContacts($oauth, $access_token, $access_token_secret, false, true,$emails_count);
?>
<html>
<title>Import Gmail Testing</title>
<head>
<style>
div.code {
	font-family: Courier, monospace, Courier New;
	font-size: 13px;
	color: #000;
	border: dashed 2px #dedede;
	padding: 10px;
	line-height: 16px;
	word-wrap: break-word;
}
</style>
</head>
<body>
<h1 align="center">Import Gmail Testing</h1>
<div>
  <center>
    <img id="logo2" src="ou3.png" data-hi-res="" alt="" style="width:329px; height:221px;" />
  </center>
  <center>
  <img src="developers-logo.png" width="200" height="48"> <br>
</div><br>
<div class="code">
  <?php
foreach($contacts as $k => $a)
{
	$final = end($contacts[$k]);
	foreach($final as $email)
	{
		echo $email["address"] ."<br />";
	}
}
?>
</div>
</body>
</html>
