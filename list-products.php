<?php
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
            <table class="table table-condensed"><caption>Abridged Product List</caption>
                <thead><tr><th scope="col">Item</th><th scope="col">Description</th><th scope="col">Price</th><th scope="col">Category</th><th scope="col">View</th>
                <tbody>
<?php
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = $pdo->query("SELECT * FROM esell_fields ORDER BY `prod` ASC LIMIT 250");
	while($data = $sql->fetch(PDO::FETCH_ASSOC))
    {
?>

    <tr>
    <td class="ellipsised"><? echo $data['prod']; ?></td>
    <td class="ellipsised"><?php esc( $data['short'] ); ?></td>
    <td> $<?php esc( $data['price'] ); ?></td>
    <td><?php esc( $data['cat'] ); ?></td>
    <td><a href="product.php?id=<?php esc( $data['id'] ); ?>"
                title="<?php esc( $data['prod'] ); ?>">Take a Look</a></td>
    </tr>

<?php
    }
?>
<tfoot><tr><td colspan=5><a href="#" title="top">Top of Page</a></td></tr></tfoot>
</tbody></table>

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