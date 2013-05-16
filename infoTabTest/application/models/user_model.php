<?php

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function validate_user($usu,$pass){
        
        $query = $this->db->query('select pass from user where user="'.$usu.'"');
        if($query->num_rows>0){
             $row = $query->row();
            $resultado= $row->pass;
        }else{
             $resultado= '';
        }
       //die($pass); 
       if($resultado==$pass){
           //var_dump($row);
           return TRUE;
       }else{
           return FALSE;
       }
    }
    function getLogoempresa($usu){
		$query = $this->db->query('select logoEmpresa from user where user="'.$usu.'"');
        if($query->num_rows>0){
             $row = $query->row();
            $resultado= $row->logoEmpresa;
        }else{
             $resultado= '';
        }
        return $resultado;
	}
    function getAcces($usuario){
        $query = $this->db->query('select p.id,p.group,p.subgorup,p.link from user_acces u
                                    INNER JOIN permission p ON p.id=u.id_permission
                                    where u.user="'.$usuario.'" ORDER BY p.group, p.subgorup');
        if($query->num_rows>0){
            foreach ($query->result() as $rowData) {
                $acces[]=$rowData;
            }
             //$row = $query->row();
            return $acces;
        }else{
             return NULL;
        }
        
    }
    function getGroups($usuario){
        $query = $this->db->query('select p.group from user_acces u
                                    INNER JOIN permission p ON p.id=u.id_permission
                                    where u.user="'.$usuario.'" GROUP BY  p.group
                                    ORDER BY p.group');
        if($query->num_rows>0){
            foreach ($query->result() as $rowData) {
                $groups[]=$rowData;
            }
             //$row = $query->row();
            return $groups;
        }else{
             return NULL;
        }
        
    }
function getSubGroups($usuario){
        $query = $this->db->query('select p.group, p.subgorup from user_acces u
                                    INNER JOIN permission p ON p.id=u.id_permission
                                    where u.user="'.$usuario.'" GROUP BY p.group,p.subgorup
                                    ORDER BY p.group,p.subgorup');
        if($query->num_rows>0){
            foreach ($query->result() as $rowData) {
                $Sgroups[]=$rowData;
            }
             //$row = $query->row();
            return $Sgroups;
        }else{
             return NULL;
        }
        
    }
/*
    function getCharts($usuario){
        $query = $this->db->query('select template,draw_function from user_chart where user="'.$usuario.'" 
        ORDER BY template');
        if($query->num_rows>0){
            foreach ($query->result() as $rowData) {
                $html[]=$rowData;
            }
             //$row = $query->row();
            return $html;
        }else{
             return NULL;
        }
        
    }
    function getFirstTemplate( $usuario ){
         $query = $this->db->query('select template from user_chart where user="'.$usuario.'" 
        GROUP BY template ORDER BY template LIMIT 1');
        
         if($query->num_rows>0){
             $row = $query->row();
            $resultado= $row->template;
        }else{
             $resultado= '';
        }
        return $resultado;
        
    }
    
    function getTemplates($usuario){
        $query = $this->db->query('SELECT t.template FROM user_chart u INNER JOIN template t ON u.template = t.template
                                    WHERE u.user ="'.$usuario.'" GROUP BY t.template ORDER BY t.template');
        if($query->num_rows>0){
            foreach ($query->result() as $rowData) {
                $templates[]=$rowData;
            }
             //$row = $query->row();
            return $templates;
        }else{
             return NULL;
        }
        
    }*/
    function getChartsTab($link){
		
		$query = $this->db->query('select t.template,c.chart,c.connection,c.scriptSql,c.divToChart,c.chartTable,c.chartFunction,t.id AS idTab,c.titulo,c.tabDrillDown,c.tooltipText  from tabs t
	   INNER JOIN  tab_charts c ON t.id=c.id_tab
		where  t.id_link="'.$link.'" ORDER BY t.id');
        if($query->num_rows>0){
            foreach ($query->result() as $rowData) {
                $acces[]=$rowData;
            }
             //$row = $query->row();
            return $acces;
        }else{
             return NULL;
        }
        
    }
    function getTabs($link){
            $query = $this->db->query('select t.id AS idTab,t.template,p.link,t.nombre,t.titulo from tabs t INNER JOIN permission p
                                        ON t.id_link=p.id                                       
                                        where  t.id_link="'.$link.'" GROUP BY t.id
                                        ORDER BY t.id');
            if($query->num_rows>0){
                foreach ($query->result() as $rowData) {
                    $acces[]=$rowData;
                }
                 //$row = $query->row();
                return $acces;
            }else{
                 return NULL;
            }
            
        }
}
?>
