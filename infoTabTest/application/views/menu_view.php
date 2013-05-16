<body>
<div class="header-bg" id="header">
   <div id="headerSup"> 
     <div id="logo"><a href="index.php"><img border="0" alt="logo" width="307" height="135" src="<?= base_url() .APPPATH ?>images/dashboardsLogo.png"></a></div> 
    </div> 
    <div id="headerTitle"><h3>Bienvenido <?=$user?></h3>&nbsp;<?=anchor('login', 'Salir',  'title="User Console"')?></div>

</div>
<!--<div class="content">-->

    <ul class="tabs" >  
        <?php
            foreach($pages as $page){
               $html    =  explode(".",$page);
                $html   = $html[0];
                echo " <li><a href='#".$html."'>".$html."</a></li>  ";
            }
        ?>
       
    </ul>  
      
    <div class="tab_container">  
        <?php
            foreach($pages as $page){
                $html    =  explode(".",$page);
                $html   = $html[0];
                echo "<div id='".$html."' class='tab_content'> ";
                echo " <iframe src='http://www.infocentrosistemas.com.ar/4colums/".$page."' height='950px' width='100%'></iframe> ";
               echo"</div>";
            }
        ?>
       
    </div>
   
      
<!--</div>-->
</body>
</html>
<script>
    $(document).ready(function() {

//Cuando el sitio carga...

$(".tab_content").hide(); //Esconde todo el contenido

$("ul.tabs li:first").addClass("active").show(); //Activa la primera tab

$(".tab_content:first").show(); //Muestra el contenido de la primera tab

//On Click Event

$("ul.tabs li").click(function() {

$("ul.tabs li").removeClass("active"); //Elimina las clases activas

$(this).addClass("active"); //Agrega la clase activa a la tab seleccionada

$(".tab_content").hide(); //Esconde todo el contenido de la tab

var activeTab = $(this).find("a").attr("href"); //Encuentra el valor del atributo href para identificar la tab activa + el contenido

$(activeTab).fadeIn(); //Agrega efecto de transición (fade) en el contenido activo
//$(activeTab).css('display','block');
return false;

});

});
</script>