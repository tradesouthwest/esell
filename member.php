<?php
if (isset($_SESSION['eselluser_session']))
{
?>

<p><a href='./'>Back to My Account page</a> | <a href="myaccount.php?change=change">Change Password</a> | <a href="myaccount.php?reset=reset">Forgot Password</a></p>
<hr>

<div class="col-lg-6 col-xs-12">

    <div class="panel panel-default">
        <div class="panel-heading"><h4>Account Information and Updates</h4></div>
            <div class="panel-body">

            <?php if( isset( $_GET['msgb'])){ ?>

                <p class="alert alert-info"><?php print ($_GET['msgb']); ?></p>

            <?php } ?>
            <?php if ( isset( $_SESSION['escooktmpname'] ) )
                { esc("You have made a current selection. Would you like to review this?
                <p><a href=\"#myPurch\" title=\"top\" class=\"btn btn-default\">View</a>"); } ?>
        </div>
        <div class="panel-footer">
            <a href="#" title="top" class="btn btn-link">Top</a>
        </div>
    </div>

</div>

<div class="col-lg-6 col-xs-12">

    <div class="panel panel-default">
        <div class="panel-heading"><h4>My Account</h4></div>
            <div class="panel-body">
    <?php
    $idm = $_SESSION['user_id'];        //id of member

    $sql = "SELECT * FROM tsw_members
            WHERE idm = ?";
	$q = $pdo->prepare($sql);
    $q->execute(array($idm));
	$data = $q->fetch(PDO::FETCH_ASSOC);

        $idm         = $data['idm'];
        $firstname  = $data['firstname'];
        $lastname  = $data['lastname'];
        $username = $data['username'];
        $email   = $data['email'];
        $prods  = $data['prods'];
    ?>

        <ul>
        <li><?php esc( $firstname ); ?> <?php esc( $lastname ); ?></li>
        <li><?php esc( $username ); ?></li>
        <li><?php esc( $email ); ?></li>
        <li><?php esc( $prods ); ?></li>
        <li><?php esc( $idm ); ?></li>
        </ul>

        <pre>
        <?php
        // debug only - shows logged in sessions
        // display sessions (for debug)

        //display_sessions();
        ?>

        </pre>
        </div>
        <div class="panel-footer">
            <form action="" method="POST">
            <input type="hidden" name="nonce" value="wxyz1234">
            <input type="submit" value="Log Out" name="logmeout" class="btn btn-danger btn-lg"></form>

            <?php
            if (isset ( $_POST['logmeout']))
            {
            // Initialize the session.
            // If you are using session_name("something"), don't forget it now!
            session_start("eselluser_session");

            // Unset all of the session variables.
            $_SESSION = array();

                // If it's desired to kill the session, also delete the session cookie.
                // Note: This will destroy the session, and not just the session data!
                if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                    setcookie(
                    session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                    );
                }

                // Finally, destroy the session.
                session_destroy();

                //logged out return to index page
                redirect('index.php');
                exit;
                }
                ?>

        </div>
    </div>

</div>

<section class="col-lg-12">
<div id="reset">

<?php if(isset( $_GET['reset']) )
    { ?>

    <form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h2>Forgot Password</h2>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Enter Email of Account" tabindex="1">
                    </div>
                </div>
            </div>
                <hr>
            <div class="row">
                <div class="col-xs-6 col-md-6">
                    <input type="submit" name="submit-new" value="Reset Password" class="btn btn-primary btn-block btn-lg" tabindex="3">
                </div>
            </div>
    </form>

    <?php
    } ?>
    <?php //include 'tsw_reset.php'; ?>

    </div>
    <div id="change">
    <?php if(isset( $_GET['change']) )
        { ?>
        <form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h2>Change Password</h2>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <input type="password" name="old_password"
                            class="form-control" placeholder="Enter current password"
                                tabindex="1" autofocus>
                    </div>
                </div>
            </div>
                <hr>
            <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <p><label for="password">New Password:</label><br>
                    <input required name="new_password" type="password" class="form-control inputpass"
                        minlength="4" maxlength="16"  id="pass1" /> <span class="req"> *</span></p>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <p><label for="password">Confirm Password:</label><br>
                    <input required name="confirm_password" type="password" class="form-control inputpass"
                      minlength="4" maxlength="16" placeholder="Enter again to confirm"  id="pass2"
                          onkeyup="checkPass(); return false;" /> <span class="req"> *</span>
                    <span id="confirmMessage" class="confirmMessage"></span></p>
                </div>
            </div>
                <hr>
            <div class="row">
                <div class="col-xs-6 col-md-6">
                    <input type="submit" name="submit-change" value="Reset Password"
                        class="btn btn-primary btn-block btn-lg" tabindex="3">
                </div>
            </div>
        </form>
    <?php
        } ?>
        <?php //include 'tsw_change.php'; ?>
    </div>
</section>

<?php //ends if-logged in and eselluser_session is set
    } else {
?>

<?php if( isset( $_GET['msgb'])){ ?>

<p class="alert alert-info"><?php print ($_GET['msgb']); ?></p>

<?php } ?>

<h2>My Account - Current Activity</h2>
<p>Would you like to create an Account with us?</p>
<a href="registration.php" title="new members sign up here" class="btn btn-primary">Registration</a>

<?php
}
?>

<div id="myPurch"></div>
<table class="table">
<thead><tr><th>Item Number</th><th>Qnty.</th><th>Product</th><th>Price</th><th>[+]</th></tr></thead>
<tbody>
<tr><td colspan=4>Currently there are no products ready for purchasing <u>as an Account Holder</u>.<br>Use the Registration link if you would like to create an Account.</td>

<?php
    //$sale_id = $_SESSION["escooktmpname"];



    $sql = $pdo->query(" SELECT * FROM esell_basket
                         WHERE sale_id = '" . $_SESSION['escooktmpname'] . "' ");
	 if( $sql->rowCount() > 0)
    {
	   while($data = $sql->fetch(PDO::FETCH_ASSOC))
     {
?>

<tr>
    <td><?php     esc($data['id'] . '' .    $data['prodid']); ?></td>
        <td><?php     esc($data['qnty']); ?></td>
            <td><?php     esc($data['prod']); ?></td>
                <td><?php esc( frmPrc($data['price'])); ?></td>
                    <td>

                    <?php //loop for all products in esell_basket where $stats= 0 is sold!
                    if( $data['keeps'] > 0 )
                    { ?>

                    <form action="purchasing.php" method="POST">
                        <input type="hidden" name="basket_id" value="<?php esc($data['id']); ?>">
                        <input type="submit" name="submit_purchase" value="Purchase Now"
                            class="btn btn-warning"></form>

              <?php } else
                        { ?>

                        <p>Recently Purchased <a href="product.php?id=<?php esc($data['prodid']); ?>"
                        title"View Purchase" class="btn btn-default">View Item</a></p>
                  <?php }
                   ?></td></tr>

<?php
        }
    } else { esc("<tr><td colspan=4>There are no products ready to purchase at this time.</td></"); }
?>

</tbody>
<tfoot><tr><td colspan="4"><a href="#" title="Top of Page">Top of Page</a></td></tr></tfoot>
</table>

<form action="" method="POST"><input class="btn btn-default" type="submit" name="killcook" value="Remove All Items in Basket"></form>

<?php if ( isset( $_POST['killcook'] )) {
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
redirect("myaccount.php");
exit;
}
?>

<hr>

<?php display_sessions(); ?>


<?php
/**
 * ===== for_activation only =====
 */

if (isset($_GET['username']) && isset($_GET['active']) )
{
$username  = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING );
$active = filter_input(INPUT_GET, 'active', FILTER_SANITIZE_STRING );
$default = (int)1;

   // find row where username is not activated
   $stmt = $pdo->prepare("SELECT username, active, email FROM tsw_members
                          WHERE username = :username AND active = :default
                         ");
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':default', $default);
    $stmt->execute();
        if ($stmt->rowCount() > 0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $email = $row['email'];
        }

    // query to validate username and email match
    $stmt = $pdo->prepare("UPDATE tsw_members
                           SET active = :active
                           WHERE username = :username AND email = :email
                          ");
    $stmt->bindValue(':active', $active);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);

    if ($stmt->execute())
    {

?>
<div class="col-lg-6 col-xs-12">
    <h1>Project Registration Complete<h1>
    <h3>Thank you </h3>
    <p>Email confirmed and account activated.</p>
    <p><?php date_default_timezone_set('America/New_York'); $dateformat = date_create()->format('Y-m-d'); echo $dateformat; ?></p>
    <hr>
    <p><a class="btn btn-lg btn-primary" href="myaccount.php" role="button">Let's Start</a></p>
    <hr>
</div>
<div class="col-lg-6 col-xs-12">

    <div class="panel panel-default">
        <div class="panel-heading"><h4>Account</h4></div>
            <div class="panel-body">
            <a class="btn btn-primary btn-lg" href="index.php" title="view store">View Store Home Page</a>
        </div>
        <div class="panel-footer">
            <a href="myaccount.php" title="top" class="btn btn-link">My Account</a>
        </div>
    </div>

</div>

<?php
    } else {
        echo "<p>This email has already been used for a Registration.</p>";
        echo "<p>Please try another email address.</p>";
       //close instance of $dbh
        }      //$dbh = null;

}
?>