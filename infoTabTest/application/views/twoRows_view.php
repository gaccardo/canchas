<?php

echo "<div id='".$name."' class='tab_content'>";
//echo "dos registros";
echo'
<div class="portletRow1"><!-- START Portlet Row 1 -->
    <div class="portletSmall portlet1Row1"><!-- START Porlets of Row 1 -->
        <span class="portletHeader btn btn-large btn-block btn-primary" style="float: left;">
            <h4></h4>
        </span>
        <div class="portletContent" style="float: left;" id="'.$name.'_barChart1.1">
			<table id="'.$name.'_barChart1_1Table"></table>
         </div>
    </div>
<!-- Container of gchart-->
    <div class="portletSmall portlet2Row1"><!-- START Porlets of Row 1 -->
        <span class="portletHeader btn btn-large btn-block btn-primary" style="float: left;">
            <h4></h4>
        </span>
        <div class="portletContent" style="float: left;" id="'.$name.'_barChart1.2">
			<table id="'.$name.'_barChart1_2Table"></table>
         </div>
    </div>
<!-- Container of gchart-->
    <div class="portletSmall portlet3Row1"><!-- START Porlets of Row 1 -->
        <span class="portletHeader btn btn-large btn-block btn-primary" style="float: left;">
            <h4></h4>
        </span>
        <div class="portletContent" style="float: left;" id="'.$name.'_barChart1.3">
				<table id="'.$name.'_barChart1_3Table"></table>
         </div>
    </div>
<!-- Container of gchart--> 
</div>
<!-- END Portlet Row 1 -->
<!-- START Portlet Row 2 -->
<div class="portletRow2">
    <div id="portlet1Row2" class="portletSuper"> 
        <span class="portletHeader btn btn-large btn-block btn-primary" style="float: left;">
            <h4></h4>
        </span>
        <div class="portletContent" style="float: left;" id="'.$name.'_barChart2.1">
            <table id="'.$name.'_barChart2_1Table"></table>
        </div>
    </div>

</div>';

echo" </div>";    
