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

    //pull category name, @uses `esell_catalog` col=@id
    //which matches `esell_fields` col=@cat
if( !function_exists('catName') {
    function catName($catid)
    {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $pdo->query("SELECT cat FROM esell_catalog WHERE id = '" . $catid . "'");
        foreach ( $sql as $data )
        {
            $catname = $data['cat'];
        }
        return $catname;
    }
}

    //pull product name, @uses `esell_fields` col=@id
    //which matches requests
if( !function_exists('prodPrice') {
    function prodPrice($prdid)
    {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $pdo->query("SELECT price, feature FROM esell_fields WHERE id = '" . $prdid . "'");
        foreach ( $sql as $data )
        {
            $price   = $data['price'];
            $feature = $data['feature'];
        }
        return array($price, $feature);
    }
}

?> 