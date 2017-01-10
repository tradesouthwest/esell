<?php
session_start();
if (!isset($_SESSION['eselluser_session']))
{
header('Location: ../login.php');
}
?>
<?php
/**
 * TSW Listing Nano Directory
 * Author: Larry Judd Oliver @tradesouthwest | http://tradesouthwest.com
 * Contributors in readme.md file
 * License in LICENSE.md file
 */
include_once '../inc/controls.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="<?php esc( $site_url ); ?>/lib/bootstrap.min.css">
  <link rel="stylesheet" href="<?php esc( $site_url ); ?>/style.css">
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
<link rel="shortcut icon" href="<?php esc( $site_url ); ?>/favicon.png">
<style>

body{
    font-family: 'Lato', sans-serif;
    background-color: rgb(255, 255, 255);
    margin-top: 50px;
    font-size: inherit;
    font-size: 1em;
    font-size: 16px;
}
span.textcenter {
    margin: 0 auto;
    position: relative;
    left: 41.5%;
    text-align: center;
}
/* Admin styles
======================================== */
.table.table-condensed tr {
padding-top: 2px;
padding-bottom: 2px;
}
#admin-nav-top {
    margin-top: .812em;
}
.det-list-anchor {
    min-width: 42px; height: 1.67em; padding: 1px 5px; background-image: linear-gradient(#efefef, #fcfcfc, #e4e4e4);
    margin:0; border: thin solid #ddd; border-radius:4px;
}
.det-list-container table {
    width: 100%;
}
.det-list-container thead tr th {
    border-right: 1px dotted white; padding-left: 3px; color: #000;
}

.det-list-container table td {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding: 0 10px;
}
.editForm .form-group {
    max-width: 98%;
    min-height: 82px;
    margin: 10px auto;
    box-shadow:  0 1px 1px rgba(0,0,0,.15);
    border-radius: 4px;
    border: 1px solid #ddd;
}
.editForm#editTheme .form-group {
min-height: 132px;
}
.det-list-container .cat-list-container .form-context {
max-width: 95%;
margin-bottom: 5px;
min-height:30px;
}
#submit_newcat {
position: relative;
top: 28px;
}
.help-block{
    padding-left: 8px;
}
input[type="text"]:focus {
    outline: none;
}
.editForm div.form-group input[type=""],
.editForm div.form-group input[type=text],
.editForm div.form-group input[type=url],
.editForm div.form-group input[type=email],
.editForm div.form-group input[type=number],
.editForm div.form-group radio {
    max-width: 91.67%;
    margin: 0 auto;
    padding: 3px;
    border-color: #aaa;
    background-color: #ffe;
    color: #111;
    font-size: 1.5rem;
}
.editForm .form-group#curr {
    min-height: 82px;
    margin: 10px auto;
    box-shadow:  0 1px 1px rgba(0,0,0,.15);
    border-radius: 4px;
    border: 1px solid #ddd;
    padding-left: 20px;
}
.editForm .form-group#curr input{
    text-align: right;
    letter-spacing: 1.72px;
    border-radius: 4px;
 max-width: 132px;
}
.editForm div.form-group span { padding-left: 12px; background: transparent; }
.editForm .bg-j {background-color: #ebeeef; }
.editForm input[readonly] { background: #fafafa !important; }
.editForm .form-group label.control-label{
padding-left: 30px;
}

#myFile {
margin-left: 20px;
}
#mySubmit{
padding-left: 30px;
}
.editForm .form-group#private {
min-height: 48px;
height: auto;
max-height: 48px;
padding-left: 20px;
background: #fcf3f3;
}

#det-panels label {
    height: 28px;
    width: 100%;
    padding: 3px 0 5px 0;
    margin-bottom: 10px;
    position: relative;
    top: 0;
    background:#fafafa;
    color: #678 !important;
    padding-left: 1em;
}
#det-panels #righthalf .form-group {
    min-height: 82px !important;
    margin: 10px auto;
}
#det-panels .form-group .col-sm-6 input {
    width: 98%;
}
#det-panels .form-group label .col-det-panel-6,
#det-panels #righthalf .form-group label .col-det-panel-6 {
    position: relative;
    left: 24%;
}
.marg-l1{margin-left: 1em;}
.sm-header{ text-shadow: 0 1px 1px #555; text-align: center;color: white;position: relative; top: -10px;
    background: #608f99; height: auto;padding: 0 8px 8px 8px; margin: 0 auto; box-shadow: 0 1px 1px #999; }
.no-well-top{ padding-top:0 !important;margin-top:0 !important;position: relative; top:-1px; }
.no-well-bottom{padding-bottom:0 !important;margin-bottom:0 !important; }
i.fa { color: #739993;background-color: #fafafa; padding: 2px; border-radius: 3px;box-shadow: 0 0 2px #888;margin-right: 5px; }
#noreply_radio .help-block i.fa { text-decoration: line-through !important; /* fa icons this not working */ }
.compress { max-width: 100px !important; text-align: right; }
.text-j { color: #777; }
.text-d { color: #000; }
.text-r { color: #900; }
.marg-r2 { position: relative; margin-left: 20%; text-decoration: underline; font-style: italic; }

.text-right { text-align: right !important; }
.text-center { text-align: center !important; }
.text-left { text-align: left !important; }
form#editPub select {background: none; background: transparent;}
form#editPub select option.bkg-success {background: green; color: white;}
form#editPub select option.bkg-danger{background: red; color: white;}
form#editPub select option.bkg-primary{background: blue; color: white;}

@media all and (max-width: 980px){
.editForm div.form-group input[type=""],
.editForm div.form-group input[type=text],
.editForm div.form-group input[type=url],
.editForm div.form-group input[type=email],
.editForm div.form-group input[type=number],
.editForm div.form-group radio {
    font-size: 1.67rem;
    padding: 2px 5px;
    }
}
#manage img.img-thumbnail {
max-height: 150px;
}
.table.table-condensed{font-size: 87.5%;}.table.table-condensed tbody > tr td{padding: 2px 2px; vertical-align: bottom;}
</style>

    <script src="<?php esc($site_url); ?>/lib/jquery.min.js"></script>
    <script src="<?php esc($site_url); ?>/lib/bootstrap.min.js"></script>

<title>Listing eSell eCommerce Admin Page</title>
<SCRIPT language="JavaScript" type="text/javascript">

var newwindow = ''
function popitup(url) {
if (newwindow.location && !newwindow.closed) {
    newwindow.location.href = url;
    newwindow.focus(); }
else {
    newwindow=window.open(url,'htmlname','width=404,height=316,resizable=1');}
}

function tidy() {
if (newwindow.location && !newwindow.closed) {
   newwindow.close(); }
}

// Based on JavaScript provided by Peter Curtis at www.pcurtis.com

</SCRIPT>

</head>
<body>

<?php
// gets the user level
$idm = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT idm, level FROM tsw_members WHERE idm = :idm");
$stmt->execute(array( ':idm' => $idm ));

    if ($stmt->rowCount() > 0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $is_memlevel = $row['level'];
        }
?>
    <nav class="navbar navbar-inverse navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="../index.php"><span id="navwhite">Stock Website</span></a> <a class="navbar-brand topnav" href="tel:4807404498"><i class="fa fa-phone fa-fw"></i> (555) 555-5555</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="../index.php">Home</a>
                    </li>
                    <li>
                        <a href="../admin/">Admin</a>
                    </li>
                    <li>
                        <a href="../catalog.php">Categories</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<div class="container">
    <div class="row">

        <header class="col-md-12 text-center">
        <h3 class="page-header">Admin Control Panel</h3>
        </header>

    </div>
</div>

<div class="container">
    <div class="row">

        <div class="col-md-12 col-sm-12">

                          <div class="det-list-container">



<?php include 'list-images.php'; ?>
           </div>

        </div>

    </div>
</div>
<?php include '../footer.php'; ?>