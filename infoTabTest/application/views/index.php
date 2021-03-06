<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Maniadmin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
 <!-- bootstrap css -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
         <!-- base css -->
        <link class="links-css" href="css/base.css" rel="stylesheet">
         <!-- home page css -->
        <link href="css/home-page.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
            .sidebar-nav {
                padding: 9px 0;
            }

        </style>
         <!-- datepicker css -->
        <link href="css/datepicker.css" rel="stylesheet"/>
         <!-- responsive css -->
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
         <!-- media query css -->
        <link href="css/media-fluid.css" rel="stylesheet">

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>

    <body>

        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">

                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="index.html"><img src="img/logo-small.png" alt="logo" /></a>
                    <ul class="nav pull-left bar-root">
                        <li class="divider-vertical"></li>
                        <li><a href="chat.html" ><i class="icon-comment icon-white"></i><span class="label label-important">6</span></a> </li>
                        <li class="dropdown"><a href="#" data-toggle="dropdown" > <i class="icon-envelope icon-white"></i><span class="label label-important">5 new</span></a> 
                            <ul class="dropdown-menu">
                                <li><a href="inbox.html"><img src="img/small/thumb1.png" alt="" /> Subject : Project <p class='help-block'><small>From: ab.alhyane@gmail.com</small></p><span class="label">23/09/2012</span></a></li>
                                <li class="divider"></li>
                                <li><a href="inbox.html"><img src="img/small/thumb2.png" alt="" /> Subject : Film <p class='help-block'><small>From: ab.alhyane@gmail.com</small></p><span class="label">21/04/2012</span> </a></li>
                                <li class="divider"></li>
                                <li><a href="inbox.html"><img src="img/small/thumb3.png" alt="" /> Subject : Meeting <p class='help-block'><small>From: ab.alhyane@gmail.com</small></p><span class="label">20/02/2012</span></a></li>
                                <li class="divider"></li>
                                <li><a href="inbox.html"><img src="img/small/thumb4.png" alt="" /> Subject : Tasks <p class='help-block'><small>From: ab.alhyane@gmail.com</small></p><span class="label">19/01/2012</span></a></li>
                                <li class="divider"></li>
                                <li class="active"><a href="inbox.html"> Show All </a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#" data-toggle="dropdown" > <i class="icon-refresh icon-white"></i><span class="label label-info">3 Updates</span></a> 
                            <ul class="dropdown-menu">
                                <li><a href="#"> Theme </a></li>
                                <li><a href="#"> Components</a></li>
                                <li><a href="#"> Plugins</a></li>
                                <li class="divider"></li>
                                <li class="active"><a href="#"> Show All </a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="group-menu nav-collapse"> 
                        <ul class="nav pull-right">
                            <li class="divider-vertical"></li>
                            <li class="dropdown">
                                <a data-toggle="dropdown" href="#">Salutations, Ab Alhyane <b class="caret"></b></a>
                               <ul class="dropdown-menu">
                                    <li>

                                        <div class="modal-header">

                                            <h3>Kostali Youssef - Admin</h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="span1"><img src="img/avatar/photo.png" alt="avatar" /></div>
                                                <div class="span3 pull-right">
                                                    <h5>mail@gmail.com</h5>
                                                    <a href="#" class="link-modal" >Account</a>  <a href="#" class="link-modal" >Settings-Privacy</a>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#" class="btn btn-info pull-left">Show my profile</a>
                                            <a class="btn btn-info" href="login.html">Deconnexion</a>
                                        </div>

                                    </li>
                                </ul>

                            </li>
                        </ul>

                        <form action="#" class="navbar-search pull-right">
                            <input type="text" placeholder="Search" class="search-query span2" >
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row-fluid">
                <div id="menu-left" class="span3">

                    <div  class="sidebar-nav">
                        <ul class="nav nav-list">
                            <li><a href="index.html" class="current"><i class="icon-th-large icon-white"></i><span> Dashboard</span></a></li>
                            <li><a href="widget.html"><i class="icon-th"></i><span> Widgets</span></a></li>
                            <li><a href="tables.html"><i class="icon-list-alt"></i><span> Tables</span></a></li>
                            <li><a href="elements.html"><i class="icon-tasks"></i><span> Elements</span></a></li>
                            <li><a href="media.html"><i class="icon-picture"></i><span> Media</span></a></li>
                            <li><a href="forms.html"><i class="icon-align-center"></i><span> Forms</span></a></li>
                            <li><a href="grid.html"><i class="icon-indent-left"></i><span> Grid</span></a></li>
                            <li><a href="buttons.html"><i class="icon-gift"></i><span> Buttons & Icons</span></a></li>
                            <li><a href="noty.html"><i class="icon-comment"></i><span> Notification</span></a></li>
                            <li><a href="callendar.html"><i class="icon-calendar"></i><span> Callendar </span></a></li>
                            <li><a href="bootstrap-ui.html"><i class="icon-ok"></i><span> Bootstrap ui </span></a></li>
                            <li><a href="chat.html"><i class="icon-bullhorn"></i><span> Chat </span></a></li>
                            <li><a href="inbox.html"><i class="icon-envelope"></i><span> Inbox </span></a></li>
                            <li><a href="charts.html" class="last"><i class="icon-warning-sign"></i><span>  Graphs & Charts</span></a></li>
                            <li class="accordion-menu">
                                <a href="#collapseOne" data-toggle="collapse" class="accordion-toggle"><i class="icon-signal"></i><span> Error Pages  <i class="icon-chevron-down pull-right"></i></span></a>
                                <div class="accordion-body collapse dropdown" id="collapseOne">
                                    <div class="accordion-inner">
                                        <ul class="nav nav-list">
                                            <li><a href="404.html">404</a></li>
                                            <li><a href="403.html">403</a></li>
                                            <li><a href="500.html">500</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class='togglemenuleft'><a class='toggle-menu'><i class="icon-circle-arrow-left icon-white"></i></a></div>
                    </div>
                </div>
                <div id='content' class="span6 section-body">
                    <div id="section-body" class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">Dashboard</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div id="block-top" class="">
                                            <ul class="thumbnails">
                                                <li class="">
                                                    <a class="btn btn-maniadmin-6" href="#"  data-original-title="Inbox"><img src="img/icon/iconset-contact.png"  alt=''/><span class="badge badge-important">6</span></a>
                                                </li>

                                                <li class="">
                                                    <a class="btn btn-maniadmin-6" href="#"  data-original-title="first tooltip"><img src="img/icon/icons-pic2.png" alt='' /><span class="label label-important">Important</span></a>
                                                </li>

                                                <li class="">
                                                    <a class="btn btn-maniadmin-6" href="#myModal" data-toggle="modal" data-original-title="Open modal"><img src="img/icon/iconset-info.png"  alt=''/>
                                                        <span class="label label-success">Open Modal</span></a>
                                                </li>

                                                <li class="">
                                                    <a class="btn btn-maniadmin-6" href="#"  data-original-title="first tooltip"><img src="img/icon/iconset-promo.png" alt='' /><span class="badge badge-warning">6</span></a>
                                                </li>

                                                <li class="">
                                                    <a class="btn btn-maniadmin-6" href="#" data-original-title="first tooltip"><img src="img/icon/iconset-bio.png" alt='' /><span class="badge badge-success">2</span></a>
                                                </li>
                                            </ul>
                                            <div class="modal hide fade" id="myModal" style="display: none;">
                                                <div class="modal-header">
                                                    <button data-dismiss="modal" class="close">×</button>
                                                    <h3>Modal Heading</h3>
                                                </div>
                                                <div class="modal-body">

                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>item</th>
                                                                <th>item</th>
                                                                <th>item</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td><span class="badge badge-important">6</span></td>
                                                                <td><div class="progress progress-danger progress-striped">
                                                                        <div style="width: 40%" class="bar"></div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td><span class="badge badge-info">8</span></td>
                                                                <td>    
                                                                    <div class="progress progress-striped active">
                                                                        <div class="bar" style="width: 70%;"></div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td><span class="badge badge-success">2</span></td>
                                                                <td>
                                                                    <div class="progress progress-success progress-striped">
                                                                        <div style="width: 100%" class="bar"></div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="modal-footer">
                                                    <a data-dismiss="modal" class="btn" href="#">Close</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <!--Tabs1-->
                                    <div class="span12">



                                        <div id="accordion1" class="accordion">
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <a href="#graph" data-toggle="collapse" class="accordion-toggle in">
                                                        <i class="icon-signal icon-white"></i> <span class="divider-vertical"></span> Visits <i class="icon-chevron-down icon-white pull-right"></i>
                                                    </a>
                                                </div>
                                                <div class="accordion-body collapse in" id="graph">
                                                    <div class="accordion-inner paddind">

                                                   
														<div id="placeholder" class='span12' style="height:300px;"></div>
														<p id="choices"></p>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--/Tabs1-->
                                </div>
                                <!--/Row fluid-->


                                <div class="row-fluid">
                                    <!--Tabs2-->
                                    <div class="span6">
                                        <div id="accordion2" class="accordion">
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <a href="#widget-tabs" data-toggle="collapse" class="accordion-toggle in">
                                                        <i class="icon-bullhorn icon-white"></i> <span class="divider-vertical"></span> Order <i class="icon-chevron-down icon-white pull-right"></i>
                                                    </a>
                                                </div>
                                                <div class="accordion-body collapse in" id="widget-tabs">
                                                    <div class="accordion-inner">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Last week</th>
                                                                    <th>This week</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>$11.00</td>
                                                                    <td>$99.00</td>
                                                                    <td><a data-original-title="Validate" class="btn btn-small" href="javascript:;">
                                                                            <i class="icon-ok"></i> 
                                                                        </a>

                                                                        <a data-original-title="Remove"  class="btn btn-small btn-danger" onclick="return confirm('Are you sure  ?');" href="javascript:;">
                                                                            <i class="icon-white icon-remove"></i>
                                                                        </a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>$56.00</td>
                                                                    <td>$3344.00</td>
                                                                    <td>
                                                                        <a data-original-title="Validate"  class="btn btn-small" href="javascript:;">
                                                                            <i class="icon-ok"></i> 
                                                                        </a>

                                                                        <a data-original-title="Remove" class="btn btn-small btn-danger" onclick="return confirm('Are you sure  ?');" href="javascript:;">
                                                                            <i class="icon-white icon-remove"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>$76.00</td>
                                                                    <td>$889.00</td>
                                                                    <td><a data-original-title="Validate"  class="btn btn-small" href="javascript:;">
                                                                            <i class="icon-ok"></i> 
                                                                        </a>

                                                                        <a data-original-title="Remove"  class="btn btn-small btn-danger" onclick="return confirm('Are you sure  ?');" href="javascript:;">
                                                                            <i class="icon-white icon-remove"></i>
                                                                        </a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div id="accordion3" class="accordion">
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <a href="#annoncement" data-toggle="collapse" class="accordion-toggle in">
                                                        <i class="icon-calendar icon-white"></i> <span class="divider-vertical"></span> Calendar <i class="icon-chevron-down icon-white pull-right"></i>
                                                    </a>
                                                </div>
                                                <div class="accordion-body collapse in" id="annoncement">
                                                    <div class="accordion-inner">
                                                        <div id="datepicker"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="span3" id="widget">
                    <div id="accordion4" class="accordion">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a href="#event" data-toggle="collapse" class="accordion-toggle">
                                    <i class="icon-bookmark icon-white"></i> <span class="divider-vertical"></span> Earning <i class="icon-chevron-down icon-white pull-right"></i>
                                </a>
                            </div>
                            <div class="accordion-body collapse in" id="event">
                                <div class="accordion-inner">
                                    <div id="earning" class="graph" style="height: 250px;
    width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a href="#statements" data-toggle="collapse" class="accordion-toggle">
                                    <i class="icon-globe icon-white"></i> <span class="divider-vertical"></span> Notifications <i class="icon-chevron-down icon-white pull-right"></i>
                                </a>
                            </div>
                            <div class="accordion-body collapse in" id="statements">
                                <div class="accordion-inner">
                                    <table class="table table-striped">

                                        <tbody>
                                            <tr>
                                                <td><i class="icon-user"></i></td>
                                                <td><a href=""><strong>Hanafi ALMOJRIM</strong> added <strong>23 users</strong> </a><em>4 hours ago</em></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icon-envelope"></i></td>
                                                <td><a href=""><strong>Abderrahim NIBET</strong> sent you  <strong>message</strong> </a><em>Yesterday</em></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icon-tag"></i></td>
                                                <td><a href=""><strong>Youssef BASSIR</strong> invite you to  <strong>dinner</strong> </a><em>2 days ago</em></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><a class="pull-right" href="">Show all</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a href="#latest" data-toggle="collapse" class="accordion-toggle">
                                    <i class="icon-th icon-white"></i> <span class="divider-vertical"></span> Tabbed Container <i class="icon-chevron-down icon-white pull-right"></i>
                                </a>
                            </div>
                            <div class="accordion-body collapse in" id="latest">
                                <div class="accordion-inner">
                                    <div class="tabbable"> <!-- Only required for left/right tabs -->
                                        <ul class="nav nav-tabs">
                                            <li><a href="#t1" data-toggle="tab">Products</a></li>
                                            <li class="active"><a href="#t2" data-toggle="tab">Posts</a></li>
                                            <li><a href="#t3" data-toggle="tab">Media</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane" id="t1">
                                                <ul>
                                                    <li><a href="">Proin elit arcu, rutrum commodo</a></li>
                                                    <li><a href="">Aenean tempor ullamcorper leo</a></li>
                                                    <li><a href="">Vehicula tempus, commodo a, risus</a></li>
                                                    <li><a href="">Donec sollicitudin mi sit amet mauris</a></li>
                                                    <li><a href="">Curabitur nec arcu</a></li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane active" id="t2">
                                                <ul class="nav nav-list">
                                                    <li><a href="#"><img src="img/small/thumb1.png" alt="" /> button groups for a toolbar, navigation</a></li>
                                                    <li><a href="#"><img src="img/small/thumb2.png" alt="" /> Use them in buttons, button groups for a toolbar, navigation</a></li>
                                                    <li><a href="#"><img src="img/small/thumb3.png" alt="" /> button groups for a toolbar, navigation</a></li>
                                                    <li><a href="#"><img src="img/small/thumb4.png" alt="" /> Use them in buttons, button groups for a toolbar, navigation</a></li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane" id="t3">
                                                <ul class="unstyled flickr">
                                                    <li><a href="http://farm8.staticflickr.com/7153/6839672369_687f2c49e8_b.jpg" title="Down the rabbit hole [Framed]"><img src="http://farm8.staticflickr.com/7153/6839672369_687f2c49e8_s.jpg" alt="" class="img_nofade"></a></li>
                                                    <li><a href="http://farm6.staticflickr.com/5235/7156342506_3180179c4d_b.jpg" title="Looking Up"><img src="http://farm6.staticflickr.com/5235/7156342506_3180179c4d_s.jpg" alt="" class="img_nofade"></a></li><li><a href="http://farm8.staticflickr.com/7248/6894937942_475bce7076_b.jpg" title="Your eyes are open"><img src="http://farm8.staticflickr.com/7248/6894937942_475bce7076_s.jpg" alt="" class="img_nofade"></a></li><li><a href="http://farm8.staticflickr.com/7280/7023103445_62489017a0_b.jpg" title="Mel McGowan"><img src="http://farm8.staticflickr.com/7280/7023103445_62489017a0_s.jpg" alt="" class="img_nofade"></a></li><li><a href="http://farm8.staticflickr.com/7243/6853027310_00cdd402ee_b.jpg" title="We will be forever calm"><img src="http://farm8.staticflickr.com/7243/6853027310_00cdd402ee_s.jpg" alt="" class="img_nofade"></a></li><li><a href="http://farm8.staticflickr.com/7196/6837771770_6d771aa7cf_b.jpg" title="Videographer"><img src="http://farm8.staticflickr.com/7196/6837771770_6d771aa7cf_s.jpg" alt="" class="img_nofade"></a></li><li><a href="http://farm8.staticflickr.com/7200/6829158646_d4f32ea229_b.jpg" title="Daylight Reveals Colors"><img src="http://farm8.staticflickr.com/7200/6829158646_d4f32ea229_s.jpg" alt="" class="img_nofade"></a></li><li><a href="http://farm8.staticflickr.com/7200/6950787615_65517ec924_b.jpg" title="Jennifer Ziliotto x3"><img src="http://farm8.staticflickr.com/7200/6950787615_65517ec924_s.jpg" alt="" class="img_nofade"></a></li><li><a href="http://farm8.staticflickr.com/7186/6937410907_234f15a111_b.jpg" title="Broadway St. Santa Monica"><img src="http://farm8.staticflickr.com/7186/6937410907_234f15a111_s.jpg" alt="" class="img_nofade"></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a href="#elements" data-toggle="collapse" class="accordion-toggle">
                                    <i class="icon-star-empty icon-white"></i> <span class="divider-vertical"></span> Events <i class="icon-chevron-down icon-white pull-right"></i>
                                </a>
                            </div>
                            <div class="accordion-body collapse in" id="elements">
                                <div class="accordion-inner paddind">
                                    <span class="label">23/12/2012</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>


                                    <span class="label label-warning">23/02/2012</span>
                                    <p>Lorem ipsum dolor sit amet dolore.</p>

                                    <span class="label label-important">13/02/2012</span> 
                                    <p>Lorem ipsum dolor sit amet dolore.</p>
                                    <br />   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer>
                <p><strong>&copy; Maniadmin 2012</strong></p>
            </footer>
            <div class="theme">
                <h4>Style</h4>
                    <a class="darkblue style" href="darkblue.css"></a>
                    <a class="darkred style" href="darkred.css"></a>
                    <a class="default style" href="base.css"></a>
                     <a class="switcher" href="#"><i class="icon-circle-arrow-right"></i></a>
            </div>
        </div><!--/.fluid-container-->

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        
        <script src="js/charts/jquery.flot.js"></script>
        <script src="js/charts/jquery.flot.resize.js"></script>
        <script src="js/charts/jquery.flot.pie.js"></script>
        <script src="js/charts/customcharts.js"></script>

      
        <script src="js/jquery-ui.min.js"></script>
 
         <script type="text/javascript">
            $(document).ready(function(){
                $('.togglemenuleft').click(function(){
                    $('#menu-left').toggleClass('span1');
                    $('#menu-left').toggleClass('icons-only');
                    $('#menu-left').toggleClass('span3');
                    
                    $('#content').toggleClass('span6');
                    $('#content').toggleClass('span8');
                    
                    $(this).find('i').toggleClass('icon-circle-arrow-right');
                    $(this).find('i').toggleClass('icon-circle-arrow-left');
                    $('#menu-left').find('span').toggle();
                    $('#menu-left').find('.dropdown').toggle();
                });

                $('#menu-left a').click(function(){
                    $('#menu-left').find('a').removeClass('active');
                    $(this).addClass('active');
                });
        // tool tip
                $('a').tooltip('hide');

        //datePciker
                $("#datepicker").datepicker();
// switch style 
                $('a.style').click(function(){
                    var style = $(this).attr('href');
                    $('.links-css').attr('href','css/' + style);
                    return false;
                });
               


                $(".switcher").click(function(){
                    if($(this).find('i').hasClass('icon-circle-arrow-right'))
                    $('.theme').animate({left:'0px'},500);
                    else
                    $('.theme').animate({left:'-89'},500);

                    $(this).find('i').toggleClass('icon-circle-arrow-right');
                    $(this).find('i').toggleClass('icon-circle-arrow-left');
                });

            });
        </script>
    </body>
</html>
