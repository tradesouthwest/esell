<?php
// config.settings.php
// gets site settings to send to string
// TSW 2013
if( !class_exists('Database') ) {
require 'dbh.class.php';
}
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $pdo->query("SELECT * FROM esell_settings ORDER BY `id` DESC LIMIT 1");
		foreach ( $sql as $data )
{
if( !empty( $data['site_title'] ))  $site_title  = $data['site_title'];
if( !empty( $data['site_slogan'] )) $site_slogan = $data['site_slogan'];
if( !empty( $data['admin_email'] )) $admin_email = $data['admin_email'];
if( !empty( $data['publish'] ))     $publish     = $data['publish'];
if( !empty( $data['site_url'] ))    $site_url     = $data['site_url'];
if( !empty( $data['payment_url'] )) $payment_url = $data['payment_url'];
if( !empty( $data['tax_rate'] ))    $tax_rate    = $data['tax_rate'];
if( !empty( $data['updated'] ))     $updated     = $data['updated'];
if( !empty( $data['headclr'] ))     $headclr     = $data['headclr'];
if( !empty( $data['site_bkg'] ))    $site_bkg    = $data['site_bkg'];
if( !empty( $data['prodclr'] ))     $prodclr     = $data['prodclr'];
if( !empty( $data['textclr'] ))     $textclr     = $data['textclr'];
if( !empty( $data['img_size'] ))    $img_size    = $data['img_size'];
}
$warehouse = "1234 Any Street,<br> North Town, AL";

    //pull category name, @uses `esell_catalog` col=@id
    function catName($catid)
    {
    $pdo = Database::connect();
        $sql = $pdo->query("SELECT cat FROM esell_catalog WHERE id = '" . $catid . "'");
        foreach ( $sql as $data )
        {
            $catname = $data['cat'];
        }
        return $catname;
    }

    //pull product qnty left. @uses `esell_fields` col=@id.
    function prodQnty($prdid)
    {
    $pdo = Database::connect();

        $sql = $pdo->query("SELECT qnty FROM esell_fields WHERE id = '" . $prdid . "'");
        foreach ( $sql as $data )
        {
            $prdqnty = $data['qnty'];
        }
        return $prdqnty;
    }

    //pull product price. @uses `esell_fields` col=@id.
    function prodPrice($prdid)
    {
    $pdo = Database::connect();

        $sql = $pdo->query("SELECT price FROM esell_fields WHERE id = '" . $prdid . "'");
        foreach ( $sql as $data )
        {
            $prdprice = $data['price'];
        }   return $prdprice;
    }

    //pull product name. @uses `esell_fields` col=@id.
    function prodName($prdid)
    {
    $pdo = Database::connect();

        $sql = $pdo->query("SELECT price FROM esell_fields WHERE id = '" . $prdid . "'");
        foreach ( $sql as $data )
        {
            $prdname = $data['prod'];
        }   return $prdname;
    }

    //pull basket price, @uses `esell_basket` col=@id
    function totalSale($bskid)
    {
    $pdo = Database::connect();

        $sql = $pdo->query("SELECT price FROM esell_basket WHERE id = '" . $bskid . "'");
        foreach ( $sql as $data )
        {
            $bskprice   = $data['price'];
        }   return $bskprice;
    }

    //format dollar amount to display
    function frmPrc($prc) {
     return number_format($prc, 2);
    }

?> 