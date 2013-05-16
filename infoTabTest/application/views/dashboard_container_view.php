<body>
	<!-- nuevo header-->
	<div class="navbar navbar-fixed-top"><!-- onmouseover="toggleDown();"-->
            <div class="navbar-inner">

                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="index.html" style="padding:0px !important;"><img src="<?= base_url() .APPPATH ?>images/<?=$logoEmpresa?>" alt="logo" width="66px" /></a>
                    
                       
                    <div class="group-menu nav-collapse"> 
                        <ul class="nav pull-right">
                            <li class="divider-vertical"></li>
                            <li class="dropdown">
                                <a data-toggle="dropdown" href="#">Usuario:&nbsp; <?=$user?> <b class="caret"></b></a>
                               <ul class="dropdown-menu">
                                    <li>

                                        <div class="modal-header">

                                            <h3>Infotab- Admin</h3>
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
                                            
                                            <?=anchor('login',"Salir",array('class' => 'btn btn-info'));?>
                                        </div>

                                    </li>
                                </ul>

                            </li>
                        </ul>

                        <!--<form action="#" class="navbar-search pull-right">
                            <input type="text" placeholder="Search" class="search-query span2" >
                        </form>-->
                    </div>

                </div>
            </div>
        </div>
	<!--nuevo header-->

   <div class="container-fluid">
            <div class="row-fluid">         
			
				<div id="menu-left" class="span3">

                    <div  class="sidebar-nav">
                        <ul class="nav nav-list">
							<li><a href="#" class="current"><i class="icon-th-large icon-white"></i><span> Dashboard</span></a></li>
							<?php
								foreach($groups as $g){
									$grupo	=   str_replace(' ', '', $g->group);
									  echo "<li class='accordion-menu'>
											<a href='#".$grupo."' data-toggle='collapse' class='accordion-toggle'><i class='icon-signal'></i><span>".$g->group."<i class='icon-chevron-down pull-right'></i></span></a>";
									  echo "<div class='accordion-body collapse dropdown' id='".$grupo."'>
												<div class='accordion-inner'>
													<ul class='nav nav-list'>";
									  foreach ($subGroups as $s) {
										  if ($s->group==$g->group) {
											  $subgrupo	=  str_replace(' ', '', $s->subgorup);
											  echo " <li class='accordion-menu'><a href='#".$subgrupo."' data-toggle='collapse' class='accordion-toggle'><i class='icon-signal'></i><span>".$s->subgorup."<i class='icon-chevron-down pull-right'></i></span></a>";
												echo "<div class='accordion-body collapse dropdown' id='".$subgrupo."'>
														<div class='accordion-inner'>
															<ul class='nav nav-list'>";
												   foreach ($acces as $a) {
															if ($s->subgorup==$a->subgorup && $a->group==$g->group) {
																echo " <li>".anchor('dashboard/showTabs/'.$a->id.'', $a->link)."</li>";
																//echo "<li><a href='#".$a->link."'>".$a->link."</a></li>";
															  //  <a href='#".$a->link."'>".$a->link."</a><li>" anchor('login', $a->link);
															}
														}   
														echo"</ul>";
													echo"</div>";
												echo"</div>";
											 echo"</li>";
										  } else {
											  
										  }
														
									  }
												echo "</ul>";
											echo "</div>";
										echo"</div>";
									 echo"</li>  ";
								}
							?>
						   <li><?=anchor('login',"Salir");?></li>
						</ul>
					
                           
                        <div class='togglemenuleft'><a class='toggle-menu'><i class="icon-circle-arrow-left icon-white"></i></a></div>
                    </div>
                </div>
              <!--</div>
              </div>
           </div>-->
           
         <div id='content' class="span9 section-body">
		   <div id="section-body" class="tabbable">
				<div class="tab_container">  
					
						<ul class="tabs nav nav-tabs" id="tabes">
							 <?php
							   if (isset($templates)) {
								   $i=0;
								   foreach($templates as $page){
									   if($i==0){//class='active'
										   echo " <li class='active'><a href='#".$page->nombre."'>".$page->titulo."</a></li>  ";
										   }else{
											   echo " <li><a href='#".$page->nombre."'>".$page->titulo."</a></li>  ";
											   }
										  
										  $i++;
									}
							   } else {
								   
							   }?>
							  
						</ul>
										
				</div>
    
				<div id="hit_area2"> <!-- onmouseover="toggleUp();"-->
				<!--<div class="tab-content">-->
           
         <!-- here commes the templates -->
         <!-- close with dashboard_close_view-->
 
