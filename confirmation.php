<?php

require('config.php');

//initialize variables

$db_result = "";
$message = "";
$result = "";

//Passkey that was received from Link
$passkey = $_GET['passkey'];
$tbl_name1 = temp_email_db;
$tbl_name2 = registered_members;

//Retrieve data from table where row matches the passkey
$sql1 = "SELECT * FROM $tbl_name1 WHERE confirm_code = '$passkey'";
$db_result = mysqli_query($con, $sql1);

//debug. output result of select
//$message = "Database result is " .$db_result;
//echo "<script type='text/javascript'>alert('$message');</script>";
    
//If query is successful using encryped passkey supplied...
    
if (!$db_result) {
    die("QUERY FAILED" . mysqli_error($con));
}
else {

//Count how many rows have that passkey - should be only 1; zero means illegal email address

  $count = mysqli_num_rows($db_result);

//add alert message box to debug as program is executed

//if passkey found in database (only 1 should be there), then retrieve data from table temp_email_db

  if ($count == 1) {
    $rows = mysqli_fetch_array($db_result);
    $email = $rows['email'];


//Insert data from temp_email_db into table "registered_members"
    $sql2 = "INSERT IGNORE INTO $tbl_name2(email) VALUES ('$email')";
    $db_result2 = mysqli_query($con, $sql2);
      
      if (!db_result2) {
          die("QUERY FAILED" . mysqli_error($con));
      }
      else { /* all is good ... continue */
          $result = "Congratulations!  Your account has been activated.  Thank you for joining our community.  We will keep you posted.";
          //  echo $result;
          
          //Wrap up processing and delete information from the temp_email_db.
          
          $sql3 = "DELETE FROM $tbl_name1 WHERE confirm_code = '$passkey'";
          $db_result3 = mysqli_query($con, $sql3);
      }

  } /* done processing the email address from the temp-email-db table */

//If passkey is not found, then display message 'Wrong Confirmation Code'
  else { /* another result so send a message to user */
    $result = "This email address may already registered.  Thank you!";
//  echo $result;
  }

} /* checking on $db_result */
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="TexasWildlifeCoffee.com - Helping Texas Wildlife One Sip At A Time">
		<meta name="author" content="Valerie Rickert, CCP">
    <meta name="keywords" content="Texas Wildlife Coffee Company,Texas Wildlife,wildlife,coffee,coffee beans,Coffee Company,Wildlife Rehabilitation,
    Wildlife Center of Texas,Texas Wildlife Rehabilitation Coalition,TWRC,Medium Roast,Dark Roast,Light Roast,Horned Lizard,Horney Toad,Ocelot,Red Wolf,
    Ringtail,Golden-Cheeked Warbler,Golden-cheeked Warbler,Golden Cheeked Warbler,Golden cheeked Warbler,Birds of Texas,Eastern Flying Squirrel,
    Rock Squirrel,Central Texas Rock Squirrel,Timber Rattlesnake,rattlesnake,timber rattlesnake,Star Cactus,star cactus,Eastern Timber Rattlesnake,
    Mexican Free-tailed Bat,Mexican free tail bat,Mexican free-tailed Bat,Brazilian Free-tailed Bat,Texas Horned Lizard,Texas Ocelot,ringtail,
    Flying Squirrel,flying squirrel,Horned Toad,Texas Horned Toad,Texas Horny Toad,Horny Toad,horny toad,horned lizard,ocelot,Texas ocelot">

		<link href="https://fonts.googleapis.com/css?family=Lobster+Two:700italic" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet" type="text/css">

		<title>Texas Wildlife Coffee Company</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<!-- Font Awesome libraries -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css ">

    <link rel="stylesheet" href="stylesheets/styles.css">



</head>

<body>


<div id="Home" class="container home-page clearfix">

<div class="row">

			<div class="col-xs-12">
					<div class="centered coffee-logo">

						<img class="text-center img-responsive" src="img/CoffeeLogolong.png" alt="Texas Wildlife Coffee Logo">

					</div>

			</div> <!-- end of logo container -->

			<div class="col-xs-1 col-md-3"></div>

				<div class="col-xs-10 col-md-6">

					<div class="well text-center dream">
						<p class="lead">Coming Soon!</p>
						<p class="text-center twcc-p">Texas Wildlife Coffee Company</p>
						<p><img class="center-block coffee-img" src="img/Coffee_Cup_Clipart.png" alt="Coffee Cup"></p>
						<p class="text-center twcc-slogan"><br>"Helping Texas Wildlife One Sip At A Time"</p>


					</div>

				</div>

	<div class="col-xs-1 col-md-3"></div>

</div>  <!-- end of row  -->

<div class="row">


</div>  <!-- end of row -->

<div class="row">
	<div class="col-xs-1 col-md-3 "></div>

		<div class="col-xs-10 col-md-6">
			<p>&nbsp;</p>
      <?php echo ($result !== null)?'<p class="text-success text-center twcc-success">'. $result . '</p>':'<p>&nbsp;</p>'; ?>
			<p class="text-center"><a href="http://www.texaswildlifecoffee.com">Return to website</a>.</p>
		</div>
	<div class="col-xs-1 col-md-3"></div>
</div>

</div>  <!-- end of div for home page -->


<hr>
<footer class="footer">
		<!-- The footer must be OUTSIDE of the page container in order for it to position at the BOTTOM of the page!  -->
<!--
 <div class="col-xs-12 col-md-12 footer-div text-center text-muted"><a href="yolanda_coffee_privacy_policy.html">Privacy Policy</a> &middot; <a href="yolanda_coffee_terms_and_conditions.html">Terms and Conditions</a>
 </div>
 -->
 <div class="col-xs-12 col-md-12 center-block">
 	<img class="center-block visa-img" src="img/Visa_MC_AMEX_Discover_logos.png">
 </div>
 <hr>
 <div class="col-xs-12 col-md-12 footer-div ftr-div-2 text-muted text-center">
<!--
 <p><a href="yolanda_coffee_index.html">Home</a> &middot; <a href="#">Shop</a> &middot; <a href="yolanda_coffee_about.html">About</a> &middot; <a href="yolanda_coffee_contact.php">Contact</a></p>
 -->
 <p>&nbsp;</p>
 <p>Copyright &copy; 2017 &nbsp;&middot;&nbsp; Texas Wildlife Coffee Company&nbsp;&middot;&nbsp;All Rights Reserved</p>
 <p class="footer-p">Website by <a href="http://www.valerierickert.com" target="_blank">ValerieRickert.com</a></p>
  </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js "></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js "></script>

</body>
</html>
