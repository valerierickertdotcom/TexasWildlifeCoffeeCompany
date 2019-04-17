<?php
// This program will be used to store email addresses into the mySQL database tables
// in order to build a customer email list for website notifications.
// Once actual site up, the email address will allow them to sign in and update
// the customer database with their personal information
//
// Built: April 2, 2017
// Author: Valerie Rickert

//define variables and initialize

$email = "";
$error_message = "";
$result = "";
$from = "";
$message = "";

require('config.php');

//table name
$tbl_name = temp_email_db;

//handle values sent from form-group but verify first

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = test_input($_POST["email"]);  //not required but a good idea
}

//declare function to strip unnecessary or hacked symbols from data

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
//looks good

// if email entered into page then

if(isset($_POST["email"])) {

// declare function to clean string of bad content

  function clean_string($string) {
    $bad = array("content-type","bcc:","to:","cc:","href");
    return str_replace($bad,"",$string);
  }

//Generate random confirmation Code for email entered.

  $confirm_code = md5(uniqid(rand()));

//First check if email already exists in table

  $sql0 = "SELECT * FROM $tbl_name WHERE email = '$email'";
  $db_result = mysqli_query($con, $sql0);

  if (!$db_result) {
// handle error in mysql
        die("QUERY FAILED" . mysqli_error($con));
    }
  else  {
      
// continue processing as query has executed successfully.
// check rowcount of select
      
      $rowcount = mysqli_num_rows($db_result);
      
      if ($rowcount > 0) {
      
          $result = "Your email has already been submitted.  Please check your inbox for the confirmation link.";
      }
      else {
//insert data into database if email entered is decent; confirmation code is
// generated with md5 hash routine.

          $sql = "INSERT INTO $tbl_name(email,confirm_code)VALUES('$email','$confirm_code')";
          $db_result = mysqli_query($con, $sql);

//if data successfully entered into database, send confirm link in email

          if (!$db_result) { // problem with table insert
              die("QUERY FAILED" . mysqli_error($con));
          }
          else {
// if call was successfull then send email confirmation
//send email to...
              $to = $email;

//Your subject
              $subject = "Your Confirmation Link for Texas Wildlife Coffee Company is here!";

// Header is at the top of the email as a title...  includes more info too.

              $header = "Welcome to Texas Wildlife Coffee Company!  Helping Save Wildlife One Sip at A Time!";

// adding reply to and from info for email. use next three lines if necessary.

//    $headers = 'From: webmaster@example.com' . "\r\n" .
//    'Reply-To: webmaster@example.com' . "\r\n" .
//    'X-Mailer: PHP/' . phpversion();

              $params = '-f"register@texaswildlifecoffee.com" -F"Registrar at Texas Wildlife Coffee Company"';

//The Message...
              $message = "Your confirmation link is here! \r\n";
              $message .= "\r\n";
              $message .= "Please click on the link below to activate your account: \r\n";
              $message .= "\r\n";
              $message .= "http://www.texaswildlifecoffee.com/confirmation.php?passkey=$confirm_code";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
              $message = wordwrap($message, 70, "\r\n");
//Send email
              $sentmail = mail($to,$subject,$message,$header,$params);
              
              //if the email was sent successfully, then send a thank you to the browser.
              
              if($sentmail) {
                  $result = "Thank you!  A confirmation link has been sent to your email address. Please check your inbox!";
                  //    echo $result;
              }
              else {
                  $result = "We were unable to send the Confirmation link to your email address.  Please verify that the email you specified is correct.";
                  //    echo $result;
              }  /* end of sentmail processing */

          } // end of email handling of sign-up for Texas Wildlife Coffee Company notifications - $db_result was good

      }  // end of handling insert of email address into database; rowcount was 0

    } /* checking if email already entered into database */

} /* if ISSET post email */
?>

<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Texas Parks,Texas,Texas Birds,Texas birds,Texas Wildlife Coffee Company,Texas Wildlife,wildlife,coffee,coffee beans,Coffee Company,coffee company,Wildlife Rehabilitation,
    Wildlife Center of Texas,Texas Wildlife Rehabilitation Coalition,TWRC,Medium Roast,Dark Roast,Light Roast,Horned Lizard,Horney Toad,Ocelot,Red Wolf,
    Ringtail,Golden-Cheeked Warbler,Golden-cheeked Warbler,Golden Cheeked Warbler,Golden cheeked Warbler,Birds of Texas,Eastern Flying Squirrel,
    Rock Squirrel,Central Texas Rock Squirrel,Timber Rattlesnake,rattlesnake,timber rattlesnake,Star Cactus,star cactus,Eastern Timber Rattlesnake,
    Mexican Free-tailed Bat,Mexican free tail bat,Mexican free-tailed Bat,Brazilian Free-tailed Bat,Texas Horned Lizard,Texas Ocelot,ringtail,
    Flying Squirrel,flying squirrel,Horned Toad,Texas Horned Toad,Texas Horny Toad,Horny Toad,horny toad,horned lizard,ocelot,Texas ocelot">

		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="Texas Wildlife Coffee Company - Helping Texas Wildlife One Sip At A Time">
		<meta name="author" content="Valerie Rickert, CCP">
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
	<!-- had navbar-inverse but am removing -->
	<header class="navbar navbar-default navbar-fixed-top bs-docs-nav" role="banner">
		<div class="container">
		<!-- Logo, Navigation, and Search bars! -->
		   	<div class="navbar-header">
		   		<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
		   			<span class="sr-only">Toggle navigation</span>
		   			<span class="icon-bar text-center"></span>
		   			<span class="icon-bar text-center"></span>
		   			<span class="icon-bar text-center"></span>
		   		</button>
		   		<!-- another help says not to use a span on the image; so remove class of col, etc even center-block -->
		   	<!--	<div class="navbar-brand"><a href="http://www.yolandaadamslive.com">
		   	<img class="yolanda-logo" src="http://www.valerierickert.com/YolandaAdamsCoffee/pics/YolandaLogo-small.png"></a>

				<h5 class="navbar-text yolanda-slogan pull-right">Wake Up With Yolanda!</h5>
				</div>
			-->
				<!-- class="col-xs-9 col-md-9 text-left"  -->

		   	</div>

			<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">

				<ul class="nav navbar-nav to-right text-center">
					<li class="active"><a href="signup_for_twcc.php">Home</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Shop</a></li>
					<li><a href="#">Blog</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
			</nav>

		</div>
	</header>


<div id="Home" class="container home-page clearfix">

<div class="row">

			<div class="col-xs-12">
					<div class="centered coffee-logo">

						<img class="text-center img-responsive" src="img/CoffeeLogolong.png" alt="Texas Wildlife Coffee Company Logo" title="Texas Wildlife Coffee Company">

					</div>
			</div> <!-- end of logo container -->

			<div class="col-xs-1 col-md-3"></div>

				<div class="col-xs-10 col-md-6">

					<div class="well text-center dream">
						<p class="lead">Coming Soon!</p>
						<p class="text-center twcc-p">Texas Wildlife Coffee Company</p>
						<p><img class="center-block coffee-img" src="img/Coffee_Cup_Clipart.png" alt="Coffee Cup" title="Coffee Cup"></p>
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
			<div class="col-md-1"></div>
			<div class="col-xs-12 col-md-10">
						<p class="twcc-text twcc-top text-justify">
							Life is always best lived with a fantastic cup of coffee.  Rich, warm,
							and satisfying, know that each sip of our coffee benefits Texas Wildlife.</p>
						<p class="twcc-text text-justify">Ten percent (10%) of our sales will directly benefit two Texas wildlife shelters:
							<ul class="twcc-text">
								<li><a href="http://www.wildlifecenteroftexas.org/" target="_blank" title="The Wildlife Center of Texas">The Wildlife Center of Texas</a></li>
								<li><a href="http://www.twrcwildlifecenter.org/" target="_blank" title="Texas Wildlife Rehabilitation Coalition (TWRC)">Texas Wildlife Rehabilitation Coalition (TWRC)</a></li>
							</ul>
						</p>
						<p class="twcc-text">Add your email to join our community and be the first to receive
						notice of our product launch. Stay tuned!</p>
			</div>
			<div class="col-md-1"></div>
		</div>
	<div class="col-xs-1 col-md-3"></div>
</div>

<div class="row"> <!-- house email here -->
	<div class="col-xs-1 col-md-3"></div>

	<div class="col-xs-10 col-md-6">
		<div class="col-md-1"></div>
		<div class="col-xs-12 col-md-10">
		<div class="email-twcc">
			<form name="email-sub" class="email" role="form" action="" method="post">
				<div class="form-group row text-left">
					<input class="form-control" type="email" id="email" name="email" placeholder="Your email address"
					title="Enter a valid email address" value="<?php echo htmlspecialchars($_POST['email']);?>"
					required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"/><br>

					<input class="send-button" type="submit" id="submit" name="submit" value="Send" title="Click to Send">
				</div>
				<div class="form-group row">
            <?php echo ($result !== null)?'<p class="text-success twcc-success text-left">'. $result . '</p>':'<p>&nbsp;</p>'; ?>

				</div>

			</form>
		</div>
		<div class="col-md-1"></div>
		</div>

	</div>

	<div class="col-xs-1 col-md-3"></div>

</div>

</div>  <!-- end of div for home page -->


<hr>
<footer class="footer">
		<!-- The footer must be OUTSIDE of the page container in order for it to position at the BOTTOM of the page!  -->
<!--
 <div class="col-xs-12 col-md-12 footer-div text-center text-muted"><a href="#">Privacy Policy</a> &middot; <a href="#">Terms and Conditions</a>
 </div>
 -->
 <div class="col-xs-12 col-md-12 center-block">
 	<img class="center-block visa-img" src="img/Visa_MC_AMEX_Discover_logos.png">
 </div>
 <hr>
 <div class="col-xs-12 col-md-12 footer-div ftr-div-2 text-muted text-center">
<!--
 <p><a href="#">Home</a> &middot; <a href="#">About</a> &middot; <a href="#">Shop</a> &middot; <a href="#">Blog</a> &middot; <a href="#">Contact</a></p>
 -->
 <p>&nbsp;</p>
 <p>Copyright &copy; 2017 &nbsp;&middot;&nbsp; Texas Wildlife Coffee Company &nbsp;&middot;&nbsp; All Rights Reserved</p>
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
