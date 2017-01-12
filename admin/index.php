<?php
if(!isset($_SESSION)){session_start();}
if (!isset($_SESSION['eselluser_session']))
{
header('Location: ../login.php');
}

include 'adminheader.php';
$pageis = "main";
?>
<title>eSell TSW eCommerce</title>
<meta name="description" content="restricted">
<meta name="robots" content="nofollow" />
<style>body{background: silver}.list-group-item span{color: green; font-size: 1.5em;}</style>
</head>
<body>
<?php
include 'adminmenutop.php';
include 'adminnavtop.php';
?>
<?php
/** get the product count
 * @param count()
 * @row id
 */
$numbproducts = '';
    $sql = ("SELECT count(*) FROM esell_fields");
    $result = $pdo->prepare($sql);
    $result->execute();
    $numbproducts = $result->fetchColumn();

/** get the category count
 * @param count()
 * @row id
 */
$numbcats = '';
    $sql = ("SELECT count(*) FROM esell_catalog");
    $resultb = $pdo->prepare($sql);
    $resultb->execute();
    $numbcats = $resultb->fetchColumn();


/** get the member count
 * @param count()
 * @row id
 */
$numbbsk = '';
    $sql = ("SELECT count(*) FROM esell_basket");
    $resultc = $pdo->prepare($sql);
    $resultc->execute();
    $numbbsk = $resultc->fetchColumn();

/** get the sold count
 * @param count()
 * @row id
 */
$numbsales = '';
    $sql = ("SELECT count(*) FROM esell_sold");
    $resultd = $pdo->prepare($sql);
    $resultd->execute();
    $numbsales = $resultd->fetchColumn();
?>




        <div class="container">
            <div class="row">
                <article class="col-lg-4 col-xs-12">

                <div class="panel panel-default">
                <div class="panel-heading">
                <h4>Manage Products</h4></div>
                <div class="panel-body">

<ul class="list-group">
<li class="list-group-item">Number of Products: <span><?php print( $numbproducts ); ?></span></li>
<li class="list-group-item">Number of Categories: <span><?php print( $numbcats ); ?></span></li>
</ul>
                </div>

                <div class="panel-footer">
<ul class="list-inline"><li><a href="inventory.php" title="product link" class="btn btn-warning btn-sm">Product</a></li><li><a href="stockitems.php" title="stock link" class="btn btn-warning btn-sm">Stock</a></li><li><a href="catalog.php" title="admin link" class="btn btn-info btn-sm">Category</a></li><li><a href="<?php print($site_url); ?>/uploads/image-list.php" title="images link" class="btn btn-primary btn-sm">Image Control</a></li></ul>
                </div>

                </div>
                </article>

                <article class="col-lg-4 col-xs-12">
                <div class="panel panel-default">
                <div class="panel-heading">
                <h4>Process Orders</h4></div>
                <div class="panel-body">

<ul class="list-group">
<li class="list-group-item">Number of Sales: <span><?php print( $numbsales ); ?></span></li>
<li class="list-group-item">Number of Orders Pending: <span><?php print( $numbbsk ); ?></span></li>
</ul>

                </div>
                <div class="panel-footer">
<ul class="list-inline">
<li><a href="soldprods.php" title="process link" class="btn btn-info btn-sm">Process Orders</a></li>
<li><a href="" title="admin link" class="btn btn-default btn-sm">Shipping</a></li>
<li><a href="soldhistory.php" title="admin link" class="btn btn-success btn-sm">Sales History</a></li></ul>
                </div>
                </div>
                </article>

                <article class="col-lg-4 col-xs-12">
                <div class="panel panel-default">
                <div class="panel-heading">
                <h4>Metrics</h4>
                </div>
                <div class="panel-body">

<p>Site Settings</p>
<ul><li>Site_title <?php print($site_title); ?></li>
<li>Site_slogan    <?php print($site_slogan); ?></li>
<li>Admin_email    <?php print($admin_email); ?></li>
<li>Public         <?php print($publish); ?></li>
<li>Site_url       <?php print($site_url); ?></li>
<li>Payment_url    <?php print($payment_url); ?></li>
<li>Tax_rate       <?php print($tax_rate); ?></li>
<li>Last Update    <?php print($updated); ?></li>
<li>Header clr     <?php print($headclr); ?></li>
<li>Site_bkg       <?php print($site_bkg); ?></li>
<li>Prod clr       <?php print($prodclr); ?></li>
<li>Text clr       <?php print($textclr); ?></li>
<li>Image_size     <?php print($img_size); ?></li>
<li>Address        <?php print($warehouse); ?></li>
</ul>
                </div>
                <div class="panel-footer">
<ul class="list-inline"><li><a href="" title="admin link" class="btn btn-default btn-sm">link</a></li><li><a href="" title="admin link" class="btn btn-default btn-sm">link</a></li><li><a href="configs-admin.php" title="admin link" class="btn btn-default btn-sm">Site Configuration</a></li></ul>
                </div>
                </div>
                </article>

            </div>
        </div>
<?php include('adminfooter.php'); ?>
