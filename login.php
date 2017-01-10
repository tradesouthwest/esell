<?php
if(!isset($_SESSION)){session_start();}
include 'header.php';
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

        <div id="mainview" class="col-lg-9">

<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    <form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <?php if(!isset( $_SESSION['eselluser_session']) ) { esc("<h2>Please Login</h2>"); } else { esc("You are now logged in."); } ?>
    <p><a href='./'>Back to home page</a></p>
<hr>

<div class="form-group">
    <p><input type="text" name="email" id="email" class="form-control input-lg" placeholder="Your email" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="1"></p>
</div>
<br>
<div class="form-group">
    <p><input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3"></p>
</div>

<div class="row">
    <div class="col-xs-9 col-sm-9 col-md-9">
        <p><a href='reset.php'>Forgot your Password?</a></p>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-xs-6 col-md-6">
        <p><input type="submit" name="submit_login" value="Login" class="btn btn-primary btn-block btn-lg" tabindex="5"></p>
    </div>
</div>
</form>
</div>
<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
<pre>
<?php
// debug only - shows logged in sessions
// display sessions (for debug)

display_sessions();
?>
</pre>
</div>

<?php
//process login form if submitted
if(isset($_POST['submit_login'])){

$email = $_POST['email'];
$password = md5($_POST['password']);
$active = (int)1;

$stmt = $pdo->prepare('SELECT * FROM tsw_members WHERE email = :email
                            AND password = :password AND active = :active');

$stmt->execute(array(
':email' => $email,
':password' => $password,
':active'   => $active
));
  if ($stmt->rowCount() > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $firstname = $row['firstname'];
    $idm       = $row['idm'];
    $email     = $row['email'];

        $email_stripped = alpha_only($email);
        $date_session   = date('mdY-Hi');
        $user_session   = $email_stripped;

            $_SESSION['eselluser_session'] = "$user_session$date_session";  // used for uploads identifier
            $_SESSION['firstname'] = $firstname;                       // for displaying name
            $_SESSION['user_id'] = $idm;                               // for user id fetching if needed

redirect('index.php');
} else {
esc('Wrong username or password.');
}


?>
<!-- alternate usage instead of redirect(or header)
<h1>You are Logged In</h1>
<h2><?php print($_SESSION['firstname']); ?></h2>
<a href='myaccount.php' class='btn btn-primary'>Logged In, Go to MyAccount</a>
<hr> -->
<?php
}
?>
        </div>

            <div class="col-lg-3 col-xs-3">

                <div class="panel panel-default">
                <div class="panel-heading">
                    <?php print( date('M-d-Y') ); ?>
                </div>
                <div class="panel-body">
<form action="" method="POST">
<input type="hidden" name="nonce" value="wxyz">
<input type="submit" value="Log Out" name="logmeout" class="btn btn-danger btn-lg"></form>
<?php
if (isset ( $_POST['logmeout']))
{
session_start();
unset($_SESSION["eselluser_session"]);
unset($_SESSION["user_id"]);
unset($_SESSION["firstname"]);

//logged out return to index page
echo 'You have cleaned session';
   redirect('index.php');
exit;
}
?>

                </div>
                </div>

            </div>

    </div>
</div>
<?php
include('footer.php'); ?>