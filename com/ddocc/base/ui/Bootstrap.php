<?php

namespace com\ddocc\base\ui;

class Bootstrap extends BasePage {

    public function __construct() {
        parent::__construct();
    }

    public function Header() {
        if (!isset($this->TitleBar)) {
            $this->TitleBar = $this->Title;
        }
        echo '<!DOCTYPE html> <html lang="en"> <head>
    <meta charset="utf-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>' . PROJECT . ' - ' . $this->Title . '</title>
    <link href="' . SITEURL . 'content/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="' . SITEURL . 'content/lib/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="' . SITEURL . 'content/lib/bootstrap/css/datepicker3.css" rel="stylesheet">
    <link href="' . SITEURL . 'content/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="' . SITEURL . 'content/css/site.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->    
    <script src="' . SITEURL . 'content/lib/jquery/jquery-1.12.1.min.js"></script>
    <script src="' . SITEURL . 'content/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="' . SITEURL . 'content/lib/bootstrap/js/bootstrap-datepicker.js"></script>
    <script src="' . SITEURL . 'content/lib/bootstrap/js/html-table-search.js"></script>
    <script src="' . SITEURL . 'content/lib/rmariuzzo/jquery.checkboxes-1.0.6.min.js"></script>
  </head> <body> 
<div class="container-fluid main1">  
';
    }

    public function Footer() {
        echo '</div>
    <script src="' . SITEURL . 'content/js/site.js"></script>
  </body>
</html>';
    }

    public function Menu() {
        echo '<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid"> <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
          </button> <a class="navbar-brand" href="' . Url('home.index') . '">' . PROJECT . '</a>
        </div> <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">' . $this->menutext . '
          </ul><ul class="nav navbar-nav navbar-right"> 
          
<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
          aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="' . Url('site-user.profile') . '"><div class="text-center small">
                
 ' . $this->su->Fullname() . '  <br />   
 ' . $this->su->role_name . '  <br />            
<img src="' . SITEURL . 'content/images/avatar.png" 
                class="img-responsive img-thumbnail" style="width:50%" />
</div>
                
</a></li> 
            <li><a href="' . Url('site-user.setting') . '">Settings</a></li>
            <li><a href="' . Url('account.logout') . '">Logout</a></li>                
          </ul> </li> 

          <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
          aria-haspopup="true" aria-expanded="false"><i class="fa fa-info-circle"></i><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="' . UrlID('info', 'about') . '">About</a></li>
            <li><a href="' . UrlID('info', 'contact') . '">Contact</a></li>
            <li><a href="' . UrlID('info', 'help') . '">Help</a></li>
          </ul> </li>  
          
          </ul> </div><!--/.nav-collapse --> </div> </nav>';
    }

    function __destruct() {
        $this->Footer();
    }

    public function PageHeader($title = '', $title_mini = '', $crumbs = 1) {
        if ($title_mini != '') {
            $title_mini = ' <small>' . $title_mini . '</small>';
        }
        if ($title == '') {
            $title = $this->Title;
        }
        $txt = '<div class="row"> <div class="col-md-12">
        <div class="page-header"> <h1>' . $title . $title_mini . '</h1>
        </div> </div> </div>';
        echo $txt;
        if ($crumbs == 1) {
            $this->BreadCrumb();
        }
    }

}
