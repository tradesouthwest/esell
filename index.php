<?php
// https://tradesouthwest.github.io/esell/
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
                <a href="<?php print($site_url); ?>/index.php" title="esell by TSW">
                <img id="homelogo" src="favicon.png" alt="logo"
                    class="img-responsive thumbnail" /></a>
            </figure>
        </header>

    </div>
</div>




<div class="container bgj">
    <div class="row">

        <div id="mainview" class="col-lg-9 col-md-12">

            <div id="homelist" class="col-lg-4 col-xs-12 homeview">

        <ul class="list-unstyled">


        <?php
        $statement = $pdo->query("SELECT * FROM esell_catalog
                                WHERE cat_path = 0 ORDER BY `cat` ASC LIMIT 50");
            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
            echo '<li class="'.$class.'"><a href="catalog.php?id=';
            echo $row['id'];
            echo '">';
            echo $row['cat'] . "</a></li>"; $parent = $row['id'];

                foreach($pdo->query("SELECT * FROM esell_catalog
                                WHERE cat_path = 1 AND cat_ref = $parent order by cat ASC") as $data)
		        {
                echo '<li class="marg-l2"><a href="catalog.php?id=';
                echo $data['id'];
                echo '">';
                echo $data['cat'] . "</a></li>";
                }
            }
        ?>

        </ul>
            </div>


            <?php include 'home-view.php'; ?>

        </div>




            <div id="right-sidebar" class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <div>
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