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
    </div>
</div>




<div class="container bgj">
    <div class="row">

        <div id="mainview" class="col-lg-9">

<?php
if( isset( $_GET['id']))
{
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT );
$cat = filter_input(INPUT_GET, 'cat', FILTER_SANITIZE_STRING );
?>

<table class="table"><tbody>
<tr><td colspan=4><?php print($cat); ?> List</td></tr>
<tr><td colspan=4><ul class="list-inline"><li>Sub Categories</li>

<?php
$sql = "SELECT * FROM esell_catalog WHERE `cat_ref` = :id";

	$q = $pdo->prepare($sql);
	$q->execute(array(':id' => $id));
    while($data = $q->fetch(PDO::FETCH_ASSOC))
    {
?>
<li><a href="catalog.php?id=<?php esc( $data['id'] ); ?>&cat=<?php esc($data['cat']); ?>" title="category <?php esc($data['cat']); ?>"><?php esc ( $data['cat'] ); ?></a></li>
<?php
    }
?>

</ul></td></tr>

<?php
    $sql = "SELECT * FROM esell_fields WHERE `cat` = :id";

		$q = $pdo->prepare($sql);
		$q->execute(array(':id' => $id));
        while($data = $q->fetch(PDO::FETCH_ASSOC))
        {
?>

<tr>
<td><span class="ellipsised"><? echo $data['prod']; ?></span> </td>
    <td> $<?php esc( $data['price'] ); ?> </td>
        <td><img src="<?php esc( $data['location'] ); ?>"
            alt="no img" class="img-responsive catthumbnail" height="42"/></td>
            <td><a class="btn btn-link" href="product.php?id=<?php esc( $data['id'] ); ?>"
                title="<?php esc( $data['prod'] ); ?>">Take a Look</a></td>
</tr>

<?php
        }
?>

<tr><td colspan=4><a href="#" title="top">Top of Page</a></td></tr>
</tbody></table>

<?php
}
?>


        </div>

            <div class="col-lg-3 col-xs-3">
                <div id="right-sidebar">
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
</div>
<?php
include('footer.php'); ?>