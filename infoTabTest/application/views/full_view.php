<?php

echo "<div id='".$name."' class='tab_content tab-pane active' >";
//echo"tres columas";
echo' <div class="row-fluid">
<!--Tabs1-->
	<div class="span12"><!-- START Portlet Full Row  -->
	
		<div id="'.$name.'_accordion1_1" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a href="#'.$name.'_widget1_1" data-toggle="collapse" class="accordion-toggle in">
							<span class="divider-vertical"></span><i class="icon-chevron-down icon-white pull-right"></i>
						</a>
					</div>
					<div class="accordion-body collapse in" id="'.$name.'_widget1_1">
						<div class="accordion-inner paddind">
								<div class="accordion" id="'.$name.'_FiltrosAccordion" style="font-family: arial;font-size: 12px;display:none;width:350px;position: relative;float: right;">
									<h3><a href="#">Filtros</a></h3>
									<div id="'.$name.'_Filtros" style="font-family: arial;font-size:10px;display:block;min-height:150px;"></div>
									
								</div>
								<div id="'.$name.'_gridFilters" style="display:none;">
								<div class="span12">
									<table class="table-striped">
											<tr>
												<td>
													 
													<label for="selectError" class="control-label">Sucursal</label>
												</td>
												<td>
													<div class="controls">
														<select name="sucursal" id="'.$name.'_sucursal">
															<option value="1">Alberdi</option>
															<option value="2">Pergamino 1</option>
															<option value="3">Pergamino 2</option>
															<option value="4">Cptn. Bermudez</option>
															<option value="5">5</option>
														</select>
													</div>
														
												</td>
												<td>
													 <div data-date-format="dd-mm-yyyy" data-date="'.date("d-m-Y").'" id="'.$name.'_start" class="input-append date">
														Desde : <input type="text" readonly="" name="desde" value="" size="16" class="span6" id="'.$name.'_from">
																<span class="add-on"><i class="icon-th"></i></span>
													</div>
												</td>
												<td>
													<div data-date-format="dd-mm-yyyy" data-date="'.date("d-m-Y").'" id="'.$name.'_end" class="input-append date">
														Hasta : <input type="text" readonly="" name="hasta" value="" size="16" class="span6" id="'.$name.'_to">
																<span class="add-on"><i class="icon-th"></i></span>
													</div>
												</td>
												<td>
													<button class="btn btn-primary" type="button" id="'.$name.'_btn">Mostrar</button>
												</td>
											</tr>
									</table>
								</div>
								<!--to grid -->
								 
								</div>
									<!-- grid to-->
								<div class="span12" style="float: left;" id="'.$name.'_barChart1.1">
										<table id="'.$name.'_barChart1_1Table" class="span12"></table>
										<div id="'.$name.'_pager"></div>
								 </div>
						</div><!-- accordion-inner-->
					</div><!-- accordion-body-->
				</div><!--accordion.group-->
			</div><!--accordion-->
	</div>
</div>
<!-- END Portlet Full Row -->';

echo" </div>";    
