<?php
error_reporting(E_ERROR | E_PARSE);  
$page = $_GET['page'];
// echo $_SERVER['DOCUMENT_ROOT'];

if ($page == '') $page = 'home';

 if ($_SERVER['SERVER_NAME'] == '127.0.0.1') {
	$site_url 	= 'http://127.0.0.1:3031/index.php';
}
else {
  $site_url = 'https://sooann-solutions.com/';
}

session_start();

?>

<html>
  <head>
    <title>iSecure</title>
    <link href="https://fonts.googleapis.com/css?family=Merriweather|Playfair+Display|Raleway&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="description" content="Lee Soo Ann, risk manager. Helping both companies and individuals manage their risks. I'm able to give all rounded advice on risk, including Insurance, Will writing, Funeral service package, Health care, Travel and much more.">
    <meta name="og:description" content="Lee Soo Ann, risk manager. Helping both companies and individuals manage their risks. I'm able to give all rounded advice on risk, including Insurance, Will writing, Funeral service package, Health care, Travel and much more.">
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1:3031/css/style.css">
    <link rel="icon" href="../img/logo.png"/>
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  </head>
  
  <body>
	<?php ?> 
    <div class="masterbox">
    <?php
      include('header.php'); 
      include("$page.php");
      include('footer.php'); 
    ?>
    </div>
  </body>
</html>