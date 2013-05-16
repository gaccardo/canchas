<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_Chart_Data extends CI_Controller {

    public function index()
    {
    
    }
	function completionChart(){
	$chart     =  $_POST['chart'];
      $table      = $_POST['table'];
      $datasource = $_POST['datasource'];
      $script     = $_POST['sql'];
      $noCols =  array("id", "cols", "tpo", "nombre","col_model");    
        $tipoChart =   "tpo";  
         //var_dump($_POST); 
      if($table=='grid'){
			  $rowColModel	= $this->obtainColModel($chart,$table);
			  $rowNames		= $this->obtainColName($chart,$table);
			  $modeloColumnas = array();
			  $colNames = array();
			  foreach($rowNames  as $k=>$v){
				  foreach ($v as $key => $value) {
						$colNames[]	= $value;
					}
				}
				$names	= implode(";",$colNames);
			  foreach($rowColModel  as $k=>$v){
				  $colModel	= array();
				foreach ($v as $key => $value) {
					if(in_array($key, $noCols )){
				   
						if($key==$tipoChart){
							$grafico    =   $value;
						}
					 }else{
						if($value!='' || $value!=NULL){
						 
							$colModel[] = $key.':'.$value;
						}
					}
					$model	= implode(",",$colModel);
				}
				
				$modeloColumnas []	= $model;
				  //var_dump($value);
				
			}
			$columnas	= implode(";",$modeloColumnas);
		}else{
			$columnas	= '';
			$names		= '';
		}
		//obtengo los formaters si es una tabla de google
		if($table=='tbl_chart'){
			$formaters	= $this->obtainFormaters($chart,$table);
			
			foreach($formaters  as $k=>$v){
				$f= array();
			  foreach ($v as $k=>$v) {
				  if($k=='formaterWidth'){
					  $f[]	= $v;
					  $formaterColumns[] = implode(",",$f);
					 $f= array();
					}else{
						$f[]	= $v;
					}
					//$formaterColumns[]	= $valor;
				}
			}
			$formaterColumns	= implode(";",$formaterColumns);
		}else{
				$formaterColumns	= '';
		}
      $row = $this->obtainChart($chart,$table);
      $rowdatasource  = $this->obtainDataSource($datasource);
      $rowscript  = $this->obtainScript($script);
	//var_dump($rowdatasource);
	   if ($rowdatasource != NULL) {
           $tipo   = $rowdatasource[0]->tipo;
           $dataSource     = $rowdatasource[0]->string.','.$rowdatasource[0]->driver.','.$rowdatasource[0]->user.','.$rowdatasource[0]->passwd;
       } else {
           $tipo   = "iframe";
           $dataSource  = "iframe";
       }
       
              
        $chartOptions   = '';
       
        //$dataSource     = $rowdatasource[0]->string.','.$rowdatasource[0]->driver.','.$rowdatasource[0]->user.','.$rowdatasource[0]->passwd;
      if($rowscript!=NULL){
          $sql            = $rowscript[0]->consulta;
      } else{
          $sql            = "";
      }
        $grafico    = '';
        foreach($row  as $k=>$v){
            foreach ($v as $key => $value) {
                if(in_array($key, $noCols )){
               
                    if($key==$tipoChart){
                        $grafico    =   $value;
                    }
                 }else{
                    if($value!='' || $value!=NULL){
							if($key=='stringFilter' && $value==true){
									$formaterWidth = 0;
									$fotmaterCol = 0;
									//me fijo si tiene stringFilters definidos
									$filters	= $this->obtainFilters($chart,$table);
									if(count($filters)>0){
										foreach($filters  as $k=>$v){
											$f= array();
										  foreach ($v as $k=>$v) {
												$f[]	= $v;
												
											}
											$strigFilters = implode(",",$f);
											$f= array();
										}
									}else{
										$strigFilters	= '';
										}
									//$chartOptions[] = $key.':'.$value;
								
								}else{
									$strigFilters	= '';
									$formaterWidth = 0;
									$fotmaterCol = 0;
									
									/*if($key=='formaterWidth'){
									$formaterWidth	= $value;
									}else{
										$chartOptions[] = $key.':'.$value;
										$formaterWidth = 0;
										$fotmaterCol = 0;
									}*/
									
									//$chartOptions[] = $key.':'.$value;
									//$fotmaterCol = 0;
								}
								$chartOptions[] = $key.':'.$value;
							
                    }
                }
            }
              //var_dump($value);
            
        }
        if ($grafico=='') {
            $grafico    = 'jqgrid/iframe';
        } else {
            
        }
        
       echo implode(";",$chartOptions).'|'.$dataSource.'|'.$tipo.'|'.$sql.'|'.$grafico.'|'.$columnas.'|'.$names.'|'.$strigFilters.'|'.$formaterWidth.'|'.$formaterColumns;
      
  //var_dump($rowdatasource);
	}
    function __construct(  ) {
         parent::__construct();
       $this->load->model('chartdata_model','',TRUE); 
    }
    function obtainChart($chart,$table){
      
        if ($chart!='') {
            $charts = $this->chartdata_model->getChart($chart,$table);
        }else{
            $charts = "";
        }
        return $charts; 
        
    }
     function obtainColModel($chart,$table){
      
        if ($chart!='') {
            $model = $this->chartdata_model->getColModel($chart,$table);
        }else{
            $model = "";
        }
        return $model; 
        
    }
    function obtainFormaters($chart,$table){
		if ($chart!='') {
            $formaters = $this->chartdata_model->getFormaters($chart,$table);
        }else{
            $formaters = "";
        }
        return $formaters; 
	}
	function obtainFilters($chart,$table){
		if ($chart!='') {
            $filters = $this->chartdata_model->getFilters($chart,$table);
        }else{
            $filters = "";
        }
        return $filters; 
	}
    function obtainColName($chart,$table){
      
        if ($chart!='') {
            $model = $this->chartdata_model->getColName($chart,$table);
        }else{
            $model = "";
        }
        return $model; 
        
    }
    function obtainDataSource($datasource){
         $dataSources =   $this->chartdata_model->getDataSource($datasource);
         return $dataSources; 
    }
    function obtainScript($script){
         $scripts =   $this->chartdata_model->getScript($script);
        return $scripts; 
    }
}  
