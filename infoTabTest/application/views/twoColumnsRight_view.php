   <?php
echo "<div id='".$name."' class='tab_content tab-pane active' >";
//echo "dos columnas izquierda";
echo' <div class="row-fluid">
<!--Tabs1-->
<div class="span12">
	<div class="row-fluid"><!-- START Portlet Column 1 -->
		<div class="span4"><!-- START Porlets of column 1 -->
			<div id="'.$name.'_accordion1_1" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a href="#'.$name.'_widget1_1" data-toggle="collapse" class="accordion-toggle in">
								 <span class="divider-vertical"></span><i class="icon-chevron-down icon-white pull-right"></i>
						</a>
					</div>
					<div class="accordion-body collapse in" id="'.$name.'_widget1_1">
						<div class="accordion-inner paddind">
								
								<div class="span12" style="float: left;" id="'.$name.'_barChart1.1">
										<table id="'.$name.'_barChart1_1Table"></table>
								 </div>
						</div><!-- accordion-inner-->
					</div><!-- accordion-body-->
				</div><!--accordion.group-->
			</div><!--accordion-->
		
		</div>
		<div class="span8"><!-- START Porlets of column 1 -->
			<div id="'.$name.'_accordion1_2" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a href="#'.$name.'_widget1_2" data-toggle="collapse" class="accordion-toggle in">
								 <span class="divider-vertical"></span><i class="icon-chevron-down icon-white pull-right"></i>
						</a>
					</div>
					<div class="accordion-body collapse in" id="'.$name.'_widget1_2">
						<div class="accordion-inner paddind">
								
								<div class="span12" style="float: left;" id="'.$name.'_barChart1.2">
										<table id="'.$name.'_barChart1.2Table"></table>
								 </div>
						</div><!-- accordion-inner-->
					</div><!-- accordion-body-->
				</div><!--accordion.group-->
			</div><!--accordion-->
	
		</div>
			<!-- Container of gchart-->
				
			<!-- Container of gchart--> 
	</div><!--row1 -->
			<!-- END Portlet Column 1 --><!-- START Portlet Column 2 -->
			
<div class="row-fluid">
		<div class="span4"><!-- START Porlets of column 1 -->
			<div id="'.$name.'_accordion1_3" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a href="#'.$name.'_widget1_3" data-toggle="collapse" class="accordion-toggle in">
								 <span class="divider-vertical"></span><i class="icon-chevron-down icon-white pull-right"></i>
						</a>
					</div>
					<div class="accordion-body collapse in" id="'.$name.'_widget1_3">
						<div class="accordion-inner paddind">
								
								<div class="span12" style="float: left;" id="'.$name.'_barChart1.3">
										<table id="'.$name.'_barChart1_3Table"></table>
								 </div>
						</div><!-- accordion-inner-->
					</div><!-- accordion-body-->
				</div><!--accordion.group-->
			</div><!--accordion-->
		
		</div>
		<div class="span8"><!-- START Porlets of column 1 -->
		<div id="'.$name.'_accordion2_1" class="accordion">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a href="#'.$name.'_widget2_1" data-toggle="collapse" class="accordion-toggle in">
							 <span class="divider-vertical"></span><i class="icon-chevron-down icon-white pull-right"></i>
					</a>
				</div>
				<div class="accordion-body collapse in" id="'.$name.'_widget2_1">
					<div class="accordion-inner paddind">
							
							<div class="span12" style="float: left;" id="'.$name.'_barChart2.1">
									<table id="'.$name.'_barChart2.1Table"></table>
							 </div>
					</div><!-- accordion-inner-->
				</div><!-- accordion-body-->
			</div><!--accordion.group-->
		</div><!--accordion-->
	
	</div>
	</div><!-- end row2-->
	<div class="row-fluid">
		<div class="span12">
			<div id="'.$name.'_accordion2_2" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a href="#'.$name.'_widget2_2" data-toggle="collapse" class="accordion-toggle in">
								 <span class="divider-vertical"></span><i class="icon-chevron-down icon-white pull-right"></i>
						</a>
					</div>
					<div class="accordion-body collapse in" id="'.$name.'_widget2_2">
						<div class="accordion-inner paddind">
								
								<div class="span12" style="float: left;" id="'.$name.'_barChart2.2">
										<table id="'.$name.'_barChart2_2Table"></table>
								 </div>
						</div><!-- accordion-inner-->
					</div><!-- accordion-body-->
				</div><!--accordion.group-->
			</div><!--accordion-->
		</div>
		</div><!--end row-fluyd de span12-->
</div><!-- en rspan12 container-->';


echo" </div></div>";
