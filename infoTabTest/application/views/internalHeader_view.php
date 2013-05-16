<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang='es' xml:lang='es' xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$title?></title>
<meta name="robots" content="noindex, nofollow"/>


 <!-- Le javascript 
 <script src="<?= base_url() .APPPATH ?>js/jquery-1.7.2.min.js"></script>

<script src="<?= base_url() .APPPATH ?>js/jquery-ui-1.9.0.custom.js"></script>
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?= base_url() .APPPATH ?>js/jquery.min.js"></script>
        <script src="<?= base_url() .APPPATH ?>js/bootstrap.min.js"></script>
		<script src="<?= base_url() .APPPATH ?>js/bootstrap-datepicker.js"></script>
		
        
        <script src="<?= base_url() .APPPATH ?>js/charts/jquery.flot.js"></script>
        <script src="<?= base_url() .APPPATH ?>js/charts/jquery.flot.resize.js"></script>
        <script src="<?= base_url() .APPPATH ?>js/charts/jquery.flot.pie.js"></script>
        <script src="<?= base_url() .APPPATH ?>js/charts/customcharts.js"></script>

      
      <!--  <script src="<?= base_url() .APPPATH ?>js/jquery-ui.min.js"></script> si lo activo se desactiva el datepicker-->
  <!-- Le styles -->
 <!-- bootstrap css -->
        <link href="<?= base_url() .APPPATH ?>styles/bootstrap.min.css" rel="stylesheet">
         <!-- base css -->
        <link class="links-css" href="<?= base_url() .APPPATH ?>styles/darkblue.css" rel="stylesheet">
         
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
            .sidebar-nav {
                padding: 9px 0;
            }

        </style>
         <!-- datepicker css-->
        <link href="<?= base_url() .APPPATH ?>styles/datepicker.css" rel="stylesheet"/> 
         <!-- responsive css -->
        <link href="<?= base_url() .APPPATH ?>styles/bootstrap-responsive.css" rel="stylesheet">
         <!-- media query css -->
        <link href="<?= base_url() .APPPATH ?>styles/media-fluid.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?= base_url() .APPPATH ?>styles/noty-css/jquery.noty.css"/
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
 
<script src="<?= base_url() .APPPATH ?>js/scripts.js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<!-- grilla -->

<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() .APPPATH ?>styles/ui.jqgrid.css" />
<script src="<?= base_url() .APPPATH ?>js/i18n/grid.locale-es.js" type="text/javascript"></script>
<script src="<?= base_url() .APPPATH ?>js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="<?= base_url() .APPPATH ?>src/grid.grouping.js" type="text/javascript"></script>

<script src="<?= base_url() .APPPATH ?>src/grid.subgrid.js" type="text/javascript"> </script>
<!-- grilla-->
  
<script type="text/javascript">
// Load the Visualization API and the charts package.
google.load('visualization', '1.1', {'packages':['table', 'controls', 'corechart']});

</script>
<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() .APPPATH ?>oat/styles/pivot.css" />
<script type="text/javascript" src="<?= base_url() .APPPATH ?>oat/loader.js"></script>
<script>
var featureList = ["pivot","statistics"];
</script>
<!--===================highcharts==================-->
<script src="<?= base_url() .APPPATH ?>js/highcharts.js"></script>
<script src="<?= base_url() .APPPATH ?>js/modules/exporting.js"></script>
<!--===================highcharts==================-->
<script type="text/javascript">    
    
    function go(div){
	//window.location ="<?= base_url()?>index.php/dashboard/showTabs/2#Tab3";
	    jQuery("ul.tabs li").removeClass("active"); //Elimina las clases activas
     	 
		jQuery(".tab_content").hide(); //Esconde todo el contenido de la tab
		
		jQuery('ul.tabs li').each(function(index) {//busco el li que tenga el div para activarlo
			var activeTab = jQuery(this).find("a").attr("href");
			if(activeTab==div){
				
				jQuery(this).addClass("active")
				jQuery(activeTab).fadeIn();
				}
		 });
	
	}
    </script>

<link href="<?= base_url() .APPPATH ?>styles/jquery-ui-1.9.0.custom.min.css" rel="stylesheet" type="text/css" />
<!--        
<link rel="stylesheet" href="<?= base_url() .APPPATH ?>styles/forms.css" />


<link href="<?= base_url() .APPPATH ?>styles/style.css" rel="stylesheet" type="text/css" />-->

<!--
<link type="text/css" href="<?= base_url() .APPPATH ?>styles/theme/ui.all.css" media="screen" rel="stylesheet" />-->
    <!-- style exceptions for IE 6 -->
    <!--[if IE 6]>
    <style type="text/css">
        .fg-menu-ipod .fg-menu li { width: 95%; }
        .fg-menu-ipod .ui-widget-content { border:0; }
    </style>
    <![endif]-->   
<!--<script type="text/javascript" src="<?= base_url() .APPPATH ?>js/scripts.js"></script>-->
<script src="<?= base_url() .APPPATH ?>js/jquery.blockUI.js" type="text/javascript"></script>
 <script src="<?= base_url() .APPPATH ?>js/jquery.noty.js"></script>
</head>
