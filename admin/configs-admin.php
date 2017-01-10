<?php
include 'adminheader.php';
$pageis = "main";
?>
<title>eSell TSW eCommerce</title>
<meta name="description" content="restricted">
<meta name="robots" content="nofollow" />
<style>table > tbody > tr td:first-child {border-bottom: 1px solid #ddd;}</style>
</head>
<body>
<?php
include 'adminmenutop.php';
include 'adminnavtop.php';
?>

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-xs-12">

<?php
/* schema= `id`, `site_title`, `site_slogan`, `admin_email`, `publish`, `site_url`, `payment_url`, `updated`, `headclr`, `site_bkg`, `prodclr`, `textclr`, `img_size`, `tax_rate` */

if ( isset( $_POST['submit_configs'] ))
{
//avoid not-nulls on first setup
$site_title = ''; $site_slogan = ''; $admin_email = ''; $publish = ''; $site_url = ''; $payment_ur = ''; $tax_rate = ''; $updated = ''; $headclr = ''; $site_bkg = ''; $prodclr = ''; $textclr = ''; $img_size = '';
//grab fields
if( !empty( $_POST['site_title'] ))  $site_title        = $_POST['site_title'];
if( !empty( $_POST['site_slogan'] )) $site_slogan      = $_POST['site_slogan'];
if( !empty( $_POST['admin_email'] )) $admin_email     = $_POST['admin_email'];
if( !empty( $_POST['publish'] ))     $publish        = $_POST['publish'];
if( !empty( $_POST['site_url'] ))    $siteurl       = $_POST['site_url'];
if( !empty( $_POST['payment_url'] )) $payment_url  = $_POST['payment_url'];
if( !empty( $_POST['tax_rate'] ))    $tax_rate    = $_POST['tax_rate'];
                                  $updated       = date('m-d-Y H:i:s');
if( !empty( $_POST['headclr'] ))  $headclr      = $_POST['headclr'];
if( !empty( $_POST['site_bkg'] )) $site_bkg    = $_POST['site_bkg'];
if( !empty( $_POST['prodclr'] ))  $prodclr    = $_POST['prodclr'];
if( !empty( $_POST['textclr'] ))  $textclr   = $_POST['textclr'];
if( !empty( $_POST['img_size'] )) $img_size = $_POST['img_size'];

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "INSERT INTO esell_settings
(site_title, site_slogan, admin_email, publish, site_url, payment_url, tax_rate, updated, headclr, site_bkg, prodclr, textclr, img_size )
VALUES (:site_title, :site_slogan, :admin_email, :publish, :siteurl, :payment_url, :tax_rate, :updated, :headclr,
:site_bkg, :prodclr, :textclr, :img_size )";
$stmt = $pdo->prepare($query);

$params = array(
    "site_title"  => $site_title,
    "site_slogan" => $site_slogan,
    "admin_email" => $admin_email,
    "publish"     => $publish,
    "siteurl"     => $siteurl,
    "payment_url" => $payment_url,
    "tax_rate"    => $tax_rate,
    "updated"     => $updated,
    "headclr"     => $headclr,
    "site_bkg"    => $site_bkg,
    "prodclr"     => $prodclr,
    "textclr"     => $textclr,
    "img_size"    => $img_size,
    );

$inserted = $stmt->execute($params);

            if($inserted)
            {
            echo "<h4>You have Successfully Configured the Settings for this eCommerce Website.</h4>";
            echo "<a class=\"menutop\" href=\"index.php\">Back to Store Manager</a>";
            echo "<BR>";
            }
                else
                {
                echo "ERROR - inserting category name into db failed";
                }
}
?>
<?php
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $sql = $pdo->query("SELECT * FROM esell_settings ORDER BY `id` DESC LIMIT 1");
		foreach ( $sql as $data ) {
if( !empty( $data['site_title'] )) $site_title   = $data['site_title'];
if( !empty( $data['site_slogan'] )) $site_slogan = $data['site_slogan'];
if( !empty( $data['admin_email'] )) $admin_email = $data['admin_email'];
if( !empty( $data['publish'] ))     $publish     = $data['publish'];
if( !empty( $data['site_url'] ))    $siteurl     = $data['site_url'];
if( !empty( $data['payment_url'] )) $payment_url = $data['payment_url'];
if( !empty( $data['tax_rate'] ))    $tax_rate    = $data['tax_rate'];
if( !empty( $data['updated'] ))     $updated     = $data['updated'];
if( !empty( $data['headclr'] ))     $headclr     = $data['headclr'];
if( !empty( $data['site_bkg'] ))    $site_bkg    = $data['site_bkg'];
if( !empty( $data['prodclr'] ))     $prodclr     = $data['prodclr'];
if( !empty( $data['textclr'] ))     $textclr     = $data['textclr'];
if( !empty( $data['img_size'] ))    $img_size    = $data['img_size'];

}
?>
 <h4>Intitial Setup Parameters</h4>
<form id="do_admin" name="do_admin" method="post" action="">
<fieldset><legend>These are your last inputted values. Over-write to update</legend>
<table><tbody>
<tr><td>site_title</td>
<td><input name="site_title" id="site_title" type="text" value="<?php esc( $site_title ); ?>"/></td></tr>

<tr><td>site_slogan</td>
<td><input name="site_slogan" id="site_slogan" type="text" value="<?php esc( $site_slogan  ); ?>"/></td></tr>

<tr><td>admin_email</td>
<td><input name="admin_email" id="admin_email" type="email" value="<?php esc( $admin_email  ); ?>" /></td></tr>

<tr><td>publish (1 for yes, 0 for no)</td>
<td><input name="publish" id="publish" type="text" value="<?php esc( $publish  ); ?>" /></td></tr>

<tr><td>site_url -NO trailing slash</td>
<td><input name="site_url" id="site_url" type="url" value="<?php esc( $siteurl  ); ?>" /></td></tr>

<tr><td>payment_url</td>
<td><input name="payment_url" id="payment_url" type="text" value="<?php esc( $payment_url ); ?>" /></td></tr>

<tr><td>Retail Tax Rate for your State/City/County total</code></td>
<td><input name="tax_rate" id="tax_rate" type="text"
                            value="<?php esc( $tax_rate  ); ?>" /></td></tr>
<tr><td>
            <h4>Site Template Parameters (style)</h4></td><td></td></tr>

<tr><td>header color </td><td><input
name="headclr" id="headclr" type="text" value="<?php esc( $headclr  ); ?>" /> </td></tr>

<tr><td>website background color (color around outer edges around web page)</td><td><input
name="site_bkg" id="site_bkg" type="text" value="<?php esc( $site_bkg  ); ?>" /> </td></tr>

<tr><td>middle section background color (area where products appear)</td><td><input
name="prodclr" id="prodclr" type="text" value="<?php esc( $prodclr  ); ?>" /> </td></tr>

<tr><td>text color for middle section (contrast to background color)</td><td><input
name="textclr" id="textclr" type="text" value="<?php esc( $textclr  ); ?>" /> </td></tr>

<tr><td>thumbnail size (pixels for the height, width will be proportional)</td><td><input
name="img_size" id="img_size" type="text" value="<?php esc( $img_size  ); ?>" /> </td></tr>

<tr><td>Date of last style change(s). (New Date auto-updated)</td><td><input
name="updated" id="updated" type="date" value="<?php if( !empty( $updated)) esc( $updated  ); ?>"> </td></tr>

<tr><td></td><td><input type="submit"
name="submit_configs" value="Enter Settings" /></td></tr>
</tbody></table>
</fieldset>
</form><br><hr><br>
            <h5><a class="btn btn-link" href="index.php">Display Admin Panel</a></h5><br>
            <h6>for more info on HTML color names visit: http://www.html-color-names.com/</h6>
            <p>Prefer color names; spelling is critical. No HTML markup only valid CSS.</p>
        </div>



<div class="col-lg-4 col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
<h4>Update Products</h4></div>
<div class="panel-body">
<?php
if (isset( $_POST['submit_delet']))
{
    $sql = "SELECT count(*) FROM esell_settings";
    $result = $pdo->prepare($sql);
    $result->execute();
    $numbsettings = $result->fetchColumn();

    if( ( $numbsettings < 2 ) )
    {
    print("There is only one configuration - you must have at least one. Possible solution would be to create a new configuration settings then remove this one.");
    } else

        {
        $id = $_POST['id'];
        // Delete
        $stmt = $pdo->prepare("DELETE FROM esell_settings WHERE id = ?");
        $deleted = $stmt->execute([$id]);
        // if successfully deleted
        if($deleted){

        echo "<div class=\"alert alert-danger\">";
        echo "Deleted Successfully";
        echo "</div>";
        echo "<p><a class=\"btn btn-link\" href=\"index.php\">Return to Control Panel</a></p>";
        }
        else
            {
            print("could not remove item");
            }
        }
// close connection
//$pdo = null;
}
?>
<?php

    $sql = "SELECT count(*) FROM esell_settings";
    $result = $pdo->prepare($sql);
    $result->execute();
    $numbsettings = $result->fetchColumn();
?>

<table class="table table-condensed small">
<caption>Lastest 50 configurations - There are <?php print( $numbsettings ); ?></caption>
<thead><tr><th>id</th><th>config date</th><th>sitename</th><th>site_bkg</th><th> [ - ] </th></tr></thead>
<tbody>
<?php
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->query('SELECT * FROM esell_settings ORDER BY `id` DESC LIMIT 50');
    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
?>
<tr>
<td class="tiny"><? esc( $row['id'] ); ?></td>
    <td class="ellipsised"><? esc( $row['site_title'] ); ?></td>
        <td><? esc( $row['site_bkg'] ); ?></td>
            <td><? esc( $row['updated'] ); ?></td>
                <td><form action="" method="POST">
                    <input type="hidden" name="id" value="<?php esc( $row['id'] ); ?>">
                    <input type="submit" name="submit_delet" value="delete" class="btn btn-danger btn-xs">
                    </form></td>
</tr>
<?php
// close while loop
}
?>
</tbody>
</table>
</div>
<div class="panel-footer">
<a href="index.php" title="admin">Admin home</a> | <a href="../index.php" title="site home">Site Home</a>
</div>
</div>

</div>

            </div>
        </div>
<?php
include('adminfooter.php'); ?>