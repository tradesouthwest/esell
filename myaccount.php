<?php
session_start();
//if (session_status() == PHP_SESSION_NONE) {}


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
    </div>
</div>




<div class="container bgj">
    <div class="row">
        <div id="mainview" class="col-lg-9">

            <?php include 'member.php'; ?>

        </div>

            <div id="right-sidebar" class="col-lg-3 col-xs-3">

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