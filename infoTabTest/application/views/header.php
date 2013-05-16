<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang='es' xml:lang='es' xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$title?></title>
<meta name="robots" content="noindex, nofollow"/>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type='text/javascript' src = '<?= base_url() .APPPATH ?>js/jquery.validate.min.js'></script>
<script src="<?= base_url() .APPPATH ?>js/hide_menu.js" type="text/javascript"></script>
<script src="<?= base_url() .APPPATH ?>js/scripts.js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script type="text/javascript" src="<?= base_url() .APPPATH ?>js/fg.menu.js"></script>

<script type="text/javascript">
// Load the Visualization API and the charts package.
google.load('visualization', '1.0', {'packages':['table', 'map', 'corechart']});

</script>

<script type="text/javascript">    
    jQuery(function(){
        // BUTTONS
        jQuery('.fg-button').hover(
            function(){ jQuery(this).removeClass('ui-state-default').addClass('ui-state-focus'); },
            function(){ jQuery(this).removeClass('ui-state-focus').addClass('ui-state-default'); }
        );
        
        // MENUS        
        jQuery('#flat').menu({ 
            content: jQuery('#flat').next().html(),
            flyOut: true
        });
        
        
    });
    </script>

<link rel="stylesheet" href="<?= base_url() .APPPATH ?>styles/forms.css" />
<link href="<?= base_url() .APPPATH ?>styles/main.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() .APPPATH ?>styles/style.css" rel="stylesheet" type="text/css" />
    <link type="text/css" href="<?= base_url() .APPPATH ?>styles/fg.menu.css" media="screen" rel="stylesheet" />
    <link type="text/css" href="<?= base_url() .APPPATH ?>styles/theme/ui.all.css" media="screen" rel="stylesheet" />
    
    
    
        <style type="text/css">
    body { font-size:62.5%; margin:0; padding:0; }
    #menuLog { font-size:1.4em; margin:20px; }
    .hidden { position:absolute; top:0; left:-9999px; width:1px; height:1px; overflow:hidden; }
    
    .fg-button { clear:left; margin:0 4px 40px 20px; padding: .4em 1em; text-decoration:none !important; cursor:pointer; position: relative; text-align: center; zoom: 1; }
    .fg-button .ui-icon { position: absolute; top: 50%; margin-top: -8px; left: 50%; margin-left: -8px; }
    a.fg-button { float:left;  }
    button.fg-button { width:auto; overflow:visible; } /* removes extra button width in IE */
    
    .fg-button-icon-left { padding-left: 2.1em; }
    .fg-button-icon-right { padding-right: 2.1em; }
    .fg-button-icon-left .ui-icon { right: auto; left: .2em; margin-left: 0; }
    .fg-button-icon-right .ui-icon { left: auto; right: .2em; margin-left: 0; }
    .fg-button-icon-solo { display:block; width:8px; text-indent: -9999px; }     /* solo icon buttons must have block properties for the text-indent to work */ 
    
    .fg-button.ui-state-loading .ui-icon { background: url(spinner_bar.gif) no-repeat 0 0; }
    </style>
    
    <!-- style exceptions for IE 6 -->
    <!--[if IE 6]>
    <style type="text/css">
        .fg-menu-ipod .fg-menu li { width: 95%; }
        .fg-menu-ipod .ui-widget-content { border:0; }
    </style>
    <![endif]-->    
</head>
