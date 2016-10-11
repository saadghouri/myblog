<!DOCTYPE html>
<html>
    <head>
        <title>My Blog</title>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="google-signin-client_id" content="144025262048-1v3rmpq6bmf8f7uiihr1k748aq1o070c.apps.googleusercontent.com">

        <!-- Favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('favicon.ico') ?>">

        <!-- Web Fonts -->
        <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,800&amp;subset=cyrillic,latin'>        
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
        <script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/angular.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/angular-ui.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/config.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/sheep-fund-controller.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/paging.js') ?>"></script>
        <script type="text/javascript" src="https://checkout.stripe.com/checkout.js"></script>
        <script>
            baseUrl = "hhttp://localhost:8888/myblog/";
        </script>
        <?php echo $html_head; ?>
    </head>
    <body ng-app="sheepFundApp" ng-controller="sheepFundController" ng-init="templateInit()">
        <div id="indexPageLoading" class="fullPageLoadClass smallSpinner" style="display: none;"></div><div id="initialPageLoader" class="smallSpinner"></div>
        <div id="fb-root"></div>
        <div class="wrapper">
            <div>
                <!--=== Header ===-->
                This is the header
                <!--=== End Header ===-->
            </div>

            <div id="content" style="margin-top: 60px;">
                <?php echo $content; ?>
            </div>

            <div class="clearfix footer-v4" id="footer">
                <div class="footer">
                    <div class="container">
                        <div class="row">
                            This is the footer
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--[if lt IE 9]>
                <script src="<?php echo base_url('assets/plugins/respond.js') ?>"></script>
                <script src="<?php echo base_url('assets/plugins/html5shiv.js') ?>"></script>
                <script src="<?php echo base_url('assets/js/plugins/placeholder-IE-fixes.js') ?>"></script>
                <![endif]-->
    </body>
</html>