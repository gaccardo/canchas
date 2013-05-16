         
 
 <!--hit area2 close -->
 </div>
 <!--section body-->
 </div>
 <!--content close-->
 </div>
 <!--row-fluyd close-->
      </div>
<!--container-fluid close-->
</div>

<br clear="both" />
    <footer>
    <div style="overflow:hidden;align:center;" align="center">
        
        <!--<div class="copyright">--><p>Copyright &copy; 2012 eHead - Systems.&nbsp;&nbsp;&nbsp;
            Website by <a style="font-size:12px;" href="http://www.ehead.com.ar" target="_blank">eHead-Systems</a></p>
        <!--</div>-->
            <a href="http://jigsaw.w3.org/css-validator/check/referer">
			<img style="border:0;width:88px;height:31px"
            src="http://jigsaw.w3.org/css-validator/images/vcss"
            alt="¡CSS Válido!" />
            <a href="http://jigsaw.w3.org/css-validator/check/referer">
    <img style="border:0;width:88px;height:31px"
        src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
        alt="¡CSS Válido!" />
</a>
			</a>
    </div>
    </footer>

<!-- END Footer -->

<script type="text/javascript">

jQuery(document).ready(function() {
/*get on the datepickers objets for the jqgrid*/
/*jQuery( ".date" ).datepicker({ 
        altFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '2008:2020'
    });
  */  
    /*
    jQuery(function(){
      window.prettyPrint && prettyPrint();

      jQuery('#star').datepicker();
      
      
      var startDate = new Date(2012,1,20);
      var endDate = new Date(2012,1,25);
      jQuery('#end').datepicker()
        .on('changeDate', function(ev){
          if (ev.date.valueOf() > endDate.valueOf()){
           jQuery('#alert').show().find('strong').text('The start date can not be greater then the end date');
          } else {
            jQuery('#alert').hide();
            startDate = new Date(ev.date);
            jQuery('#startDate').text(jQuery('#end').data('date'));
          }
          jQuery('#end').datepicker('hide');
        });
    });*/
/*datepickers on*/

//maniadmin
jQuery('.togglemenuleft').click(function(){
	jQuery('#menu-left').toggleClass('span1');
	jQuery('#menu-left').toggleClass('icons-only');
	jQuery('#menu-left').toggleClass('span3');
	
	jQuery('#content').toggleClass('span9');
    jQuery('#content').toggleClass('span11');
	
	jQuery(this).find('i').toggleClass('icon-circle-arrow-right');
	jQuery(this).find('i').toggleClass('icon-circle-arrow-left');
	jQuery('#menu-left').find('span').toggle();
	//jQuery('#menu-left').find('.dropdown').toggle();
});

jQuery('#menu-left a').click(function(){
	jQuery('#menu-left').find('a').removeClass('active');
	jQuery(this).addClass('active');
});
// tool tip
jQuery('a').tooltip('hide');

// switch style 
jQuery('a.style').click(function(){
	var style = jQuery(this).attr('href');
	jQuery('.links-css').attr('href','css/' + style);
	return false;
});
			   


jQuery(".switcher").click(function(){
	if(jQuery(this).find('i').hasClass('icon-circle-arrow-right'))
	jQuery('.theme').animate({left:'0px'},500);
	else
	jQuery('.theme').animate({left:'-89'},500);

	jQuery(this).find('i').toggleClass('icon-circle-arrow-right');
	jQuery(this).find('i').toggleClass('icon-circle-arrow-left');
});

		//maniadmin
//Cuando el sitio carga...

jQuery(".tab_content").hide(); //Esconde todo el contenido

jQuery("ul.tabs li:first").addClass("active").show(); //Activa la primera tab
jQuery("ul.tabs li:first").addClass("active").click();
jQuery(".tab_content:first").show(); //Muestra el contenido de la primera tab

//On Click Event

jQuery("ul.tabs li").click(function() {
	jQuery.blockUI({ message: "<h1>cargando..</h1>" });	
	setTimeout(jQuery.unblockUI, 2000); 
    jQuery("ul.tabs li").removeClass("active"); //Elimina las clases activas

    jQuery(this).addClass("active"); //Agrega la clase activa a la tab seleccionada

    jQuery(".tab_content").hide(); //Esconde todo el contenido de la tab

    var activeTab = jQuery(this).find("a").attr("href"); //Encuentra el valor del atributo href para identificar la tab activa + el contenido
	
	var tabName	= activeTab.replace('#','');
    jQuery(activeTab).fadeIn(function(){
		
		callFunctions(tabName);
		
		jQuery(".msg_head").click(function()
		  {
			var padre = jQuery(this).parent().get(0);
			var abuelin = jQuery(padre).parent().get(0);
			jQuery(this).next(".portletContent").slideToggle(600);
			
		  });
		
		}); //Agrega efecto de transición (fade) en el contenido activo
	
    return false;

});


function callFunctions(tabName){
	
<?php 

if (isset($functions_charts) && count($functions_charts)>0) {
		foreach ($functions_charts as $funcion) {
			$arrFunc	= array();
			$arrFunc	= explode("|",$funcion);
			$tabName	= $arrFunc[0];
			$funcionTab	= $arrFunc[1];?>
			var tab	=	"<?php echo $tabName?>";
						
			 if(tab==tabName){
				
				 <?php echo $funcionTab;?>
				 
				}else{}
		<?php } 
		
		
		
	} else {}?>
	
}
<?php
/*
if (isset($functions_charts) && count($functions_charts)>0) {
	//var_dump($functions_charts);
	$i=0;
	foreach ($functions_charts as $fucion) {
       
		echo $fucion;
		$i++;
    }
} else {
	
}
*/
?>
   
		  //hide or show the all of the element with class portletContent are the body of charts
		 // jQuery(".portletContent").show();
		  //toggle the componenet with class portletContent
		  
		  jQuery(".msg_head").click(function()
		  {
			var padre = jQuery(this).parent().get(0);
			var abuelin = jQuery(padre).parent().get(0);
			jQuery(this).next(".portletContent").slideToggle(600);
			alert("dando click");
		  });
			/*jQuery('.msg_head').toggle(
				function(){
								
					jQuery(this).attr({ 
					  src: "<?= base_url() .APPPATH ?>images/dArrow.png",
					 
					});

				},
				function(){
					jQuery(this).attr({ 
					  src: "<?= base_url() .APPPATH ?>images/uArrow.png",
					 
					});

				}
			);*/
				//print the content of div class portletContent
            jQuery( ".printImage" ).click(function(){
				var padre = jQuery(this).parent().get(0);
				var abuelo	= jQuery(padre).parent().get(0);
				var viscaabuelo	= jQuery(abuelo).parent().get(0);
				Imprimir(viscaabuelo);
				
				});
				
				
				jQuery( ".reload" ).click(function(){
				var funcionDibujar	= jQuery(this).attr('name');
				var Datos = funcionDibujar.split(',');   
				var funcion	= Datos[0];
				chart = Datos[1];
				dataSource= Datos[2];
				sql=Datos[3];
				div=Datos[4];
				table=Datos[5];
				titulo=Datos[6];
				document.getElementById(div).innerHTML = '';
				reload(funcion,chart,dataSource,sql,div,table,titulo);
				return false;
				});
				
	/*busco la tab activa y la prendo*/
	jQuery('ul.tabs li').each(function(index) {
	
		var clase = jQuery(this).attr('class'); 
		
		if( clase=='active'){
			jQuery.blockUI({ message: "<h1>cargando..</h1>" });	
			
			var activeTab = jQuery(this).find("a").attr("href"); //Encuentra el valor del atributo href para identificar la tab activa + el contenido
				
			var tabName	= activeTab.replace('#','');
			jQuery(activeTab).fadeIn(function(){
				callFunctions(tabName);
				
				jQuery(".msg_head").click(function()
				  {
					var padre = jQuery(this).parent().get(0);
					var abuelin = jQuery(padre).parent().get(0);
					jQuery(this).next(".portletContent").slideToggle(600);
					
				  });
				
			}); 
			setTimeout(jQuery.unblockUI, 3500); 
			return false;

		} 
	});
	
	/*activate the datepicker*/
	window.prettyPrint && prettyPrint();

    jQuery('.date').datepicker();
   /*datepicker activate*/   
      
});
</script>

</div>
    </body>
</html>
