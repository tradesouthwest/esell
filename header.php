<?php
require 'inc/controls.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="tradesouthwest">
    <link href="lib/bootstrap.rdc.css" rel="stylesheet" media="none" onload="if(media!='all')media='all'">
    <link href="style.css" rel="stylesheet" media="none" onload="if(media!='all')media='all'">
    <style>body{background: <?php if( isset( $site_bkg ) ) esc( $site_bkg ); ?> }
           header{background: <?php if( isset( $headclr ) ) esc( $headclr ); ?> }
    </style>
