<?php
namespace com\ddocc\base\entity;
use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\Gizmo;
use com\ddocc\cms\entity\CmsArticle;
use com\ddocc\base\ui\Bootstrap;

class Page extends Bootstrap {

    var $Title;
    var $TitleBar;
    var $TitleMini;
    var $su;
    var $lite;
    var $Layout;
    var $MenuText;

    public function __construct( ) {

    }

    public function Header()
    {
        if(! isset($this->TitleBar))
        {
            $this->TitleBar = $this->Title;
        }

        if($this->Layout == 'admin')
        {
            $sr = new SiteRole();
            $sr->role_id = 1;
            $sr->Load();
            $this->MenuText = $sr->GetMenu();
        }
        include_once(SITELOC . 'layout/'.$this->Layout . '.php');
    }

    public function Footer() {
        include_once(SITELOC . 'layout/'.$this->Layout . '_foot.php');
    }

    public function FooterSite() {
        $txt = '</body>
</html>
';
        echo $txt;

    }

    public function BreadCrumb() {
        $txt = '';
        echo $txt;

    }

    public function PaintArticle($article_name) {
         $art = new CmsArticle();
        $art->article_name = $article_name;
        $art->LoadByName();
        echo Gizmo::SafeHTMLDecode($art->article_content);
    }

    public function Alert($ibox) {

        if ($ibox->msg == '')
            return;
        echo '<div class="alert alert-' . $ibox->css . ' alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    ' . $ibox->msg . '</div>';
    }

    public function BodyStart() {
        
        $txt = '<div class="container">
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
     
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="' . SITEURL . '">Home</a></li>             
                
'.$this->Menu().'
    </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="' . SITEURL . 'Apps/User/Profile.php">My Profile</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Info <b class="caret"></b></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="' . SITEURL . 'Pages/Info/about.php">About Us</a></li>
                        <li><a href="' . SITEURL . 'Pages/Info/faqs.php">FAQs</a> </li>
                        <li><a href="' . SITEURL . 'Pages/Info/help.php">Help</a> </li>
                        <li><a href="' . SITEURL . 'Pages/Info/sitemap.php">SiteMap</a></li>
                        <li><a href="' . SITEURL . 'Pages/Info/contact.php">Contact Us</a></li>
                    </ul>
                </li>
                <li><a href="' . SITEURL . 'Account/logout.php"> <i class="glyphicon glyphicon-log-out"></i></a></li>
            </ul>
       </div>
        <!-- /.navbar-collapse -->
   
</nav>




 </div>
 



<div class="container" style=" margin-top: 60px; ">
<div class="row">
        <div class="col-md-4">
             <img src="' . SITEURL . 'content/images/logo.png" class="img-responsive" alt="vendor-tracker" />
                 

        </div>

        <div class="col-md-8"> 
</div>
    </div>             
  </div>  


        <div class="container mymain" style="">
        
  ';        
        echo $txt;
    }

    public function BodyEnd() {
        $txt = '
           

        </div> ';
        echo $txt;
    }

    public function BreadCrumb2() {
        if($this->lite == 0) {
            return '';
        }
        return '<ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Examples</a></li>
                        <li class="active">Blank page</li>
                    </ol>';
    }

    public function Menu() {
        if($this->lite == 0) {
            return 'ss';
        }
        $r = new Role();
        $r->RoleId = $this->su->RoleId;
        $r->Load(); 
        return $r->Paint();
    }

    public function Messages() {
        if($this->lite == 0) {
            return '';
        }
        return ' <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="../../img/avatar3.png" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>';
    }

    public function Notices() {
        if($this->lite == 0) {
            return '';
        }
        return '<!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users warning"></i> 5 new members joined
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-cart success"></i> 25 sales made
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-person danger"></i> You changed your username
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>';
    }

    public function Profile() {
        if($this->lite == 0) {
            return '';
        }
        return '<!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>' . $this->su->FullName() . ' <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-maroon">
                                    <img src="' . $this->su->Avatar() . '" class="img-circle" alt="User Image" />
                                    <p>
                                        ' . $this->su->FullName() . '
                                        <small>member since ' . $this->su->JoinDate() . '</small>
                                    </p>
                                </li>
                                
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="' . SITEURL . 'account/logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>';
    }

    public function SideBar() {
        if($this->lite == 0) return;
        return '<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="' . $this->su->Avatar() . '" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, ' . $this->su->FirstName() . '</p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type="submit" name="seach" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <ul class="nav navbar-nav">
                                           

                        ' . $this->Menu() . '

                       
                    </ul>
                </section>
            </aside>';
    }

}
