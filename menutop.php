    <nav class="navbar navbar-inverse navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="index.php"><span id="navwhite">Stock Website</span></a> <a class="navbar-brand topnav" href="tel:4807404498"><i class="fa fa-phone fa-fw"></i> (555) 555-5555</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php esc($site_url); ?>/index.php">Home</a>
                    </li>
                    <li>
                        <a href="<?php esc($site_url); ?>/myaccount.php">My Account</a>
                    </li>
                <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Store <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php esc($site_url); ?>/catalog.php">Categories</a></li>
                    <li><a href="<?php esc($site_url); ?>/list-products.php">Product List</a></li>
                    <li><a href="<?php esc($site_url); ?>/about.php">About Us</a></li>
                    <li><a href="<?php esc($site_url); ?>/contact.php">Contact Us</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php esc($site_url); ?>/myaccount.php">My Purchases</a></li>
                    <li><a href="<?php esc($site_url); ?>/registration.php">Create an Account</a></li>
                    <li><a href="<?php esc($site_url); ?>/login.php">LogIn/LogOut</a></li>
                </ul>
                </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="clearfix"></div>
