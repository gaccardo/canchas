<?php

class ChartData_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
   
   function getChart($chart,$table){
       $sqlChart = $this->db->query('SELECT * FROM '.$table.' WHERE nombre="'.$chart.'"');
        if($sqlChart->num_rows>0){
           $row = $sqlChart->result() ;
         }else{
           $row = NULL;      
         }
        return $row;
        
        
    }
    function getFormaters($chart,$table){
		$sqlChart = $this->db->query('SELECT tbl_chart_formater.formaterColumn,tbl_chart_formater.colorNegative,tbl_chart_formater.colorPositive,tbl_chart_formater.showValue,tbl_chart_formater.formaterWidth 
										FROM tbl_chart_formater INNER JOIN '.$table.' 
										ON '.$table.'.id=tbl_chart_formater.id_tbl_chart WHERE '.$table.'.nombre="'.$chart.'"');
        if($sqlChart->num_rows>0){
           $row = $sqlChart->result() ;
         }else{
           $row = NULL;      
         }
        return $row;
	}
	function getFilters($chart,$table){ 	 	 	 
		$sqlChart = $this->db->query('SELECT tbl_string_filter.filterColumnLabel,tbl_string_filter.label,
									tbl_string_filter.labelSeparator,tbl_string_filter.labelStacking,
									tbl_string_filter.filterType,tbl_string_filter.allowTyping,tbl_string_filter.allowMultiple,tbl_string_filter.selectedValuesLayout
										FROM tbl_string_filter INNER JOIN '.$table.' 
										ON '.$table.'.id=tbl_string_filter.id_tbl_chart WHERE '.$table.'.nombre="'.$chart.'"');
        if($sqlChart->num_rows>0){
           $row = $sqlChart->result() ;
         }else{
           $row = NULL;      
         }
        return $row;
	}
    function getColModel($chart,$table){
		$sqlChart = $this->db->query('SELECT grid_col_model.* FROM grid_col_model INNER JOIN '.$table.' 
					ON '.$table.'.col_model=grid_col_model.col_model WHERE '.$table.'.nombre="'.$chart.'"');
        if($sqlChart->num_rows>0){
           $row = $sqlChart->result() ;
         }else{
           $row = NULL;      
         }
        return $row;
	}
	function getColName($chart,$table){
		$sqlChart = $this->db->query('SELECT grid_col_name.col_names  FROM grid_col_name INNER JOIN '.$table.' 
					ON '.$table.'.col_name=grid_col_name.id WHERE '.$table.'.nombre="'.$chart.'"');
        if($sqlChart->num_rows>0){
           $row = $sqlChart->result() ;
         }else{
           $row = NULL;      
         }
        return $row;
	}
    function getDataSource( $datasource ){
       $sqldatasource = $this->db->query('SELECT user,passwd,driver,string,tipo FROM datasources WHERE nombre="'.$datasource.'"');
        if($sqldatasource->num_rows>0){
           $rowdatasource = $sqldatasource->result() ;
         }else{
            $rowdatasource = NULL;     
         }
        return  $rowdatasource;
    }
    function getScript($script){
        $sqlscript = $this->db->query('SELECT consulta FROM scripts WHERE nombre="'.$script.'"');
         
        if($sqlscript->num_rows>0){
           $rowscript = $sqlscript->result() ;
         }else{
           $rowscript = NULL;      
         }
        return $rowscript;
    }
}
?>
