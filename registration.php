<?php
include 'header.php';
//session_start in head
?>
<title><?php print( $site_title ); ?></title>
<meta name="description" content="<?php print($site_slogan); ?>">

</head>
<body>
<?php
include 'menutop.php';
?>
<div class="container">
    <div class="row">
        <header class="page-head">
            <div class="col-xs-9">
                <h1><?php print( $site_title ); ?></h1>
            </div>
            <figure class="col-xs-3 pull-right">
                <a href="" title="esell by TSW">
                <img id="homelogo" src="favicon.png" alt="logo"
                    class="img-responsive thumbnail" /></a>
            </figure>
        </header>
    </div>
</div>




<div class="container bgj">
    <div class="row">
        <div id="mainview" class="col-lg-9">
<?php
/**
 * TSW Login
 * Copyright 2015 - Tradesouthwest
 * file name: tsw_register
 */

if( isset( $_POST['submit_reg'] ) )
{

    $username         = $_POST['username'];
    $password         = md5($_POST['password']);
    $phonenumber      = $_POST['phonenumber'];
    $firstname        = $_POST['firstname'];
    $lastname         = $_POST['lastname'];
    $email            = $_POST['email'];
    $dateregistered   = $_POST['dateregistered'];
    $active           = 0;

    // check database for duplicate email
    $query = $pdo->prepare("SELECT email FROM tsw_members
                            WHERE email = :email
                               ");
    $query->bindValue(':email', $email);
    $query->execute();
    if($query->rowCount() > 0)
    {
        ?><p>This email has already been registered.</p>
          <p>Please choose a new email. <a class="btn btn-default" href='#' onclick='history.go(-1)'>Go Back</a></p><?php
    } else {

        // get the thank you message
        //print('<p>Thank you for registering.</p>');

// new query to insert data

$sql = ("INSERT INTO tsw_members ( username, password, phonenumber, firstname, lastname, email, dateregistered, active  )
         VALUES ( :username, :password, :phonenumber, :firstname, :lastname, :email, :dateregistered, :active )
        ");

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username',       $username);
$stmt->bindValue(':password',       $password);
$stmt->bindValue(':phonenumber',    $phonenumber);
$stmt->bindValue(':firstname',      $firstname);
$stmt->bindValue(':lastname',       $lastname);
$stmt->bindValue(':email',          $email);
$stmt->bindValue(':dateregistered', $dateregistered);
$stmt->bindValue(':active',         $active);
//$stmt->bindValue(':level',        $level);

    //Execute the statement and insert the new account.
    $insert = $stmt->execute();

    //If the signup process is successful.
    if( $insert !==false ) {

    $server     = $server_name;
	$uri        = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $host       = $_SERVER['HTTP_HOST'];
	$sendemails = array('$server_email', $email);
	foreach ($sendemails as $sendemail) {

	$message =
"You are almost finished. You MUST complete your activation and registion  with $server. Please click on the activation link below to complete the process:\n\n
First Name: $firstname \n
Last Name: $lastname \n
User Email: $email \n
____________________________________________
*** ACTIVATION LINK ***** \n
Activation Link: http://$host$uri/myaccount.php?username=$_POST[username]&active=1 \n\n
_____________________________________________
Thank you. This is an automated response. PLEASE DO NOT REPLY.
";

	mail( $sendemail, " Registration", $message,
    "From: \"Auto-Response\" <notifications@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion());
	unset($_SESSION['ckey']);
        }
	echo("<h2>You are almost complete!</h2><p>Next step is to validate your email</p><p>An activation link has been sent to your email address with an activation link...<br>
              Be sure to check your spam folders. Validation process may take a few minutes.</p> <br><hr>
             ");

        echo "<hr>Your registration is processed</h2>";
        echo "<BR>";
        echo "Data entered - ";
        echo date("m/d/y");
        echo "<BR>";
        echo "<p>If this is YOUR CORRECT email: ";
        echo "<span class='valid'>";
        echo $email;
        echo "</span> You will receive a confirmation ONLY if your information is valid.</p>";


    } else { echo "There was a problem entering your information."; $errors = $stmt->errorInfo();
    echo($errors[2]); }

    } // ends check dup emails
?>
        </div>

            <div class="col-lg-3 col-xs-3">

                <div class="panel panel-default">
                <div class="panel-heading">
                    <?php print( date('M-d-Y') ); ?>
                </div>
                <div class="panel-body">

                    <?php include 'sidebar-right.php'; ?>

                </div>
                </div>

            </div>

    </div>
</div>
<?php
include('footer.php'); ?>
<?php
exit;
} // ends if reg_submit
?>


    <form action="" method="post" id="fileForm" class="well" role="form">
        <fieldset>
            <legend>Valid information is required to register. <span class="req"><small> required *</small></span></legend>

	    <p><span class="req">* </span><label for="phonenumber">Phone Number: </label><br>
            <input required type="text" name="phonenumber" id="phone" class="form-control phone" maxlength="28" onkeyup="validatephone(this);" placeholder="not used for marketing"/> </p>

            <p><span class="req">* </span><label>First name:</label><br>
            <input class="form-control" type="text" name="firstname" id = "txt" onkeyup = "Validate(this)" required /></p>
<div id="errFirst"></div>

            <p><span class="req">* </span><label>Last name:</label><br>
            <input class="form-control" type="text" name="lastname" id = "txt" onkeyup = "Validate(this)" placeholder="hyphen or single quote OK" required /> </p>
<div id="errLast"></div>

            <p><span class="req">* </span><label for="email">Email Address: <small>This will be your login user name</small></label><br>
            <input class="form-control" required type="text" name="email" id = "email"  onchange="email_validate(this.value);" />  </p>
<div class="status" id="status"></div>

  <p><span class="req">* </span><label>User name:</label><br>
            <input class="form-control" type="text" name="username" id = "txt" onkeyup = "Validate(this)" placeholder="minimum 6 letters" required /> </p>
<div id="errLast"></div>

            <p><span class="req">* </span><label for="password">Password:</label><br>
            <input required name="password" type="password" class="form-control inputpass" minlength="4" maxlength="16"  id="pass1" /> </p>
            <p><span class="req">* </span><label for="password">Password:</label><br>
            <input required name="password" type="password" class="form-control inputpass" minlength="4" maxlength="16" placeholder="Enter again to validate"  id="pass2" onkeyup="checkPass(); return false;" />
<span id="confirmMessage" class="confirmMessage"></span></p>

            <?php //$date_entered = date('m/d/Y H:i:s'); ?>
            <input type="hidden" value="<?php echo $date_entered; ?>" name="dateregistered">
            <input type="hidden" value="0" name="activate" />
<hr>
<input type="checkbox" required name="terms" onchange="this.setCustomValidity(validity.valueMissing ? 'Please indicate that you accept the Terms and Conditions' : '');" id="field_terms">
                      <label for="terms">I agree with the <a href="terms.php" title="You may read our terms and conditions by clicking on this link">terms and conditions</a> for Registration.</label><span class="req">* </span>

                      <p><input class="btn btn-success" type="submit" name="submit_reg" value="Register"></p>

                      <h5>You will receive an email to complete the registration and validation process. </h5>
                      <h5>Be sure to check your spam folders. Member validation process may take a few minutes.</h5>


          </fieldset>
      </form>
<script type="text/javascript">
  document.getElementById("field_terms").setCustomValidity("Please indicate that you accept the Terms and Conditions");
</script>
        </div>

            <div class="col-lg-3 col-xs-3">

                <div class="panel panel-default">
                <div class="panel-heading">
                    <?php print( date('M-d-Y') ); ?>
                </div>
                <div class="panel-body">

                    <?php include 'sidebar-right.php'; ?>

                </div>
                </div>

            </div>

    </div>
</div>
<?php
include('footer.php'); ?>