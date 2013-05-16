	function getChart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText){
		//if(redibuja==true){
			insertHeaderChart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText);;
		
	//}else{
		
	//}
	/*var aDentroSpan	= '<a href="#'+div+'" data-toggle="collapse" class="accordion-toggle in" id="'+toolId+'">';
		aDentroSpan	+=	titulo +'</a>';
	if(redibuja==true){
	}else{
		var toolId	= div.replace('.', "_");
		var padre = document.getElementById(div).parentNode;
		
		var reloadImg = "<img src='<?= base_url() .APPPATH ?>images/gtk-refresh.png' alt='reload' name='getChart,"+chart+","+dataSource+","+sql+","+div+","+table+","+titulo+"' class='reload' height='16' width='16' style='float: right; cursor: pointer;' >";

		var img = "<img src='<?= base_url() .APPPATH ?>images/printIco.png' alt='Imprimir' class='printImage' height='16' width='16' style='float: right; cursor: pointer;'>";
		var plusImg	= "<img src='<?= base_url() .APPPATH ?>images/uArrow.png' alt='mas' class='msg_head' height='16' width='16' style='float: right; cursor: pointer;'>";
		if(tabDD!=''){
			var drillWownImg = "<img src='<?= base_url() .APPPATH ?>images/drillDown.png' onclick='go(\""+tabDD+"\");' height='16' width='16' style='float: left; cursor: pointer;' >";   
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div>"+drillWownImg+aDentroSpan;
		}else{
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div>"+aDentroSpan;
		}
	}*/
	var toolId	= div.replace('.', "_");
    var options;//={};
    var source="";
    var tipo="";
    var consulta="";
    var grafico="";
	
    var doLoginMethodUrl = '../../get_chart_data/completionChart';//'<? echo site_url("get_chart_data/completionChart");?>';//'get_chart_data/completionChart';
    jQuery.ajax({
        type: "POST",
        async: false,
         url:doLoginMethodUrl,
        data: {chart: chart,datasource: dataSource,sql:sql,table:table},
        success: function(json)
        {
			var arrJson = [];
            arrJson = json.split('|');   
            options = arrJson[0];
            source  = arrJson[1];
            tipo    = arrJson[2];
            consulta    = arrJson[3];
            grafico	= arrJson[4];
           	if( grafico=='' ){
				grafico	= 'google.visualization.BarChart';
			}
            google.setOnLoadCallback(function(){ drawInteligentChart(options,tipo,source,consulta,grafico,div,chart,table) });
		}
	});
	
    //test con opciones
      //  google.setOnLoadCallback(function(){ drawInteligentChart(options,tipo,source,consulta,grafico,div,chart) });
    function drawInteligentChart(options,tipo,source,consulta,grafico,div,chart,table) {
        var doLoginMethodUrl =  '../../get_json_data';//'<? echo site_url("get_json_data");?>';//'get_json_data';
        try {
			  var JsonData = jQuery.ajax({
				type: "POST",
				data: {tipo: tipo,datasource: source,sql:consulta,chart:chart,table:table},
				async: false,
				url:doLoginMethodUrl,
			  //url:'../application/xhr/get_json_data_test.php?tipo='+tipo+'&datasource='+source+'&sql='+consulta+'&chart='+chart,
				dataType:"json",
				async: false
				}).responseText;
				var data = new google.visualization.DataTable(JsonData);
		} catch (exception) {
		  alert("Json invalido");
		  return false;
		}
                
        var obj	= getOptionsObjets(options);
        
       // var option = {backgroundColor:'#ccc',chartArea:{left:20,top:0,width:"50%",height:"75%"},fontSize:'10',fontName:'Arial',height:'300',isStacked:true,legend:{position: 'top', textStyle: {color: 'blue', fontSize: 8}},title:'Chart de test',titlePosition:'out',titleTextStyle:{color: 'black', fontName: 'Arial', fontSize: '14'},vAxis:{title: 'Hello', titleTextStyle: {color: '#FF0000'}},width:'300'}
        //alert(option['chartArea'].left);
       	//alert(obj['chartArea'].left);    
		grafico = grafico.trim();
        switch(grafico){
			case 'google.visualization.BarChart':
				var chart = new google.visualization.BarChart(document.getElementById(div));
                chart.draw(data, obj);
			break;
			case 'google.visualization.DataTable':
				var table = new google.visualization.Table(document.getElementById(div));
                table.draw( data, obj); 
			break;
			case 'google.visualization.PieChart':
				var chart = new google.visualization.PieChart(document.getElementById(div));
                chart.draw( data, obj); 
			break;
			case 'google.visualization.ColumnChart':
				var chart = new google.visualization.ColumnChart(document.getElementById(div));
                chart.draw(data, obj);
			break;
		}
       
    }
    /*usando el tooltip de twitter*/
				var op	= {content:"<span style='color:#000;'>"+tooltipText+"</span>",
							trigger:'hover',
							placement:'top',
							//title:"<span style='color:#000;'><h4>Infotab<h4></span>",
							html:true
						};
						
				jQuery('#'+toolId).tooltip(op);
				/*usando el tooltip de twitter*/
    //
}
String.prototype.trim= function() {//Agrega la función trim al objeto String
   return this.replace(/(^\s*)|(\s*$)/g,""); //elimina espacios a izquierda y derecha
}

function getChartGdocs(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText){
	//if(redibuja==true){
		insertHeaderChart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText);
		
	//}else{
		
	//}
	//vizcaabuelo.append('<a href="#"  class="accordion-toggle in" style="float:left;"><i class="icon-th icon-white"></i> <span class="divider-vertical"></span><i class="icon-th icon-white"></i> <span class="divider-vertical"></span></a>');	
		//vizcaabuelo.getElementsByTagName('div')[0].innerHTML = '<a href="#"  class="accordion-toggle in" style="float:left;"><i class="icon-th icon-white"></i> <span class="divider-vertical"></span><i class="icon-th icon-white"></i> <span class="divider-vertical"></span></a>';
	/*var aDentroSpan	= '<a href="#'+div+'" data-toggle="collapse" class="accordion-toggle in" id="'+toolId+'">';
		aDentroSpan	+=	titulo +'</a>';
	if(redibuja==true){
	}else{
		var toolId	= div.replace('.', "_");
		//alert(toolId);
		var padre = document.getElementById(div).parentNode;
		var reloadImg = "<img src='<?= base_url() .APPPATH ?>images/gtk-refresh.png' alt='reload'  name='getChartGdocs,"+chart+","+dataSource+","+sql+","+div+","+table+","+titulo+"' class='reload' height='16' width='16' style='float: right; cursor: pointer;' >";
		var img = "<img src='<?= base_url() .APPPATH ?>images/printIco.png' alt='Imprimir' class='printImage' height='16' width='16' style='float: right; cursor: pointer;'>";
		var plusImg	= "<img src='<?= base_url() .APPPATH ?>images/uArrow.png' alt='mas' class='msg_head' height='16' width='16' style='float: right; cursor: pointer;'>";
		
		if(tabDD!=''){
			var drillWownImg = "<img src='<?= base_url() .APPPATH ?>images/drillDown.png' onclick='go(\""+tabDD+"\");' height='16' width='16' style='float: left; cursor: pointer;' >";   
			padre.getElementsByTagName('span')[0].innerHTML = "<div style='padding-top:0.5%;float:right;' >"+reloadImg+plusImg+img+"</div>"+drillWownImg+aDentroSpan;
		}else{
			padre.getElementsByTagName('span')[0].innerHTML = "<div style='padding-top:0.5%;float:right;' >"+reloadImg+plusImg+img+"</div>"+aDentroSpan;
		}

	*/
	
	var toolId	= div.replace('.', "_");
	 var options;//={};
		var source="";
		var tipo="";
		var consulta="";
		var grafico="";
		var doLoginMethodUrl = '../../get_chart_data/completionChart';//'<? echo site_url("get_chart_data/completionChart");?>';//'get_chart_data/completionChart';
        jQuery.ajax({
            type: "POST",
            async: false,
             url:doLoginMethodUrl,
            data: {chart: chart,datasource: dataSource,sql:sql,table:table},
			success: function(json)
			{
				var arrJson = [];
				arrJson = json.split('|');   
				options = arrJson[0];
				source  = arrJson[1];
				var arrSource	= source.split(',');
				var urlSpreadsheet	= arrSource[0];
				tipo    = arrJson[2];
				consulta    = arrJson[3];
				grafico	= arrJson[4];
				var opciones	= getOptionsObjets(options);//DESCOMENTAR ESTOOOO:::
				var wrapper = new google.visualization.ChartWrapper({
					dataSourceUrl: urlSpreadsheet,
					chartType: grafico,
					options:opciones,
					containerId: div
				});
				wrapper.draw();
			}

		});
		/*usando el tooltip de twitter*/
				var op	= {content:"<span style='color:#000;'>"+tooltipText+"</span>",
							trigger:'hover',
							placement:'top',
							//title:"<span style='color:#000;'><h4>Infotab<h4></span>",
							html:true
						};
						
				jQuery('#'+toolId).tooltip(op);
				/*usando el tooltip de twitter*/
}
function handleQueryResponse(response,options,grafico) {
	  if (response.isError()) {
		alert('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
		return;
	  }
	
}

function getOptionsObjets(options){

		//to get the options
		
        //divido cada property que viene con ;
        var properties = options.split(';');
		var obj = {};
		var arr = [];
        //itero dentro de cada tupla separada por ";"
		properties.forEach(function(property) {
            //divido la tupla en label y valor mediante ":"
			var tup = property.split(':');
			var remplazo	= tup[1];
            //busco si tiene = el valor es porque adentro hay otro {label:value} si da -1 no esta
            pos = remplazo.indexOf(",");
            tup[0] = tup[0].replace(/_/g, ".");
            //alert(tup[0]);
            if( pos>0 ){
                var values  = {};
                //puede que el valor tenga adentro opciones separadas por ","
                var valores = remplazo.split(',');
                //itero cada tupla de valor que adentro contiene label=valor nuevamente
                valores.forEach(function(val) {
                    var aux = val.split('=');
                    //cargo el arreglo de valores para la tupla superior
                    var label   = aux[0];
                    values[label]=aux[1];
                    //alert(values[label]);
                    //cargo la tupla en el objeto de opciones
                   // obj[tup[0]] = values;
                });obj[tup[0]] = values;
            }else{
                pos2    = remplazo.indexOf("=");
                if(pos2>0){
                    var values  = {};
                    //puede que el valor tenga adentro una sola tupla label=valor
                    var aux = remplazo.split('=');
                    //cargo el arreglo de valores para la tupla superior
                    var label   = aux[0];
                    values[label]=aux[1];
                    obj[tup[0]] = values;
                }else{
                    //si la primer tupla dividida no tiene tuplas adentro la almaceno directamente en opciones
                    var r   = remplazo.trim();
                    obj[tup[0]] = r;
                }
                
            }
                        			
		});
		return obj;
		//options
	
}
/*funcion para grillas
 si es grupoing grid usa json y si es gridwithsubgrid usa xml
 * */

 /*por ahora la comento*/
function getGroupingGrid(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText){
	//if(redibuja==true){
		insertHeaderChart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText);
		
	//}else{
		
	//}
	/*if(redibuja==true){
	}else{
		var toolId	= div.replace('.', "_");
		var padre = document.getElementById(div).parentNode;
		var reloadImg = "<img src='<?= base_url() .APPPATH ?>images/gtk-refresh.png' alt='reload' name='getGroupingGrid,"+chart+","+dataSource+","+sql+","+div+","+table+","+titulo+"' class='reload' height='16' width='16' style='float: right; cursor: pointer;' >";

		var img = "<img src='<?= base_url() .APPPATH ?>images/printIco.png' alt='Imprimir' class='printImage' height='16' width='16' style='float: right; cursor: pointer;'>";
		var plusImg	= "<img src='<?= base_url() .APPPATH ?>images/uArrow.png' alt='mas' class='msg_head' height='16' width='16' style='float: right; cursor: pointer;'>";
		if(tabDD!=''){
			var drillWownImg = "<img src='<?= base_url() .APPPATH ?>images/drillDown.png' onclick='go(\""+tabDD+"\");' height='16' width='16' style='float: left; cursor: pointer;' >";   
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div>"+drillWownImg+"<h3 id='"+toolId+"'>"+titulo+"</h3>";
		}else{
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div><h3 id='"+toolId+"'>"+titulo+"</h3>";
		}
	}
	*/
	var toolId	= div.replace('.', "_");
    var options;//={};
    var source="";
    var tipo="";
    var consulta="";
    var grafico="";
	var colModel	= "";
    var doLoginMethodUrl = '../../get_chart_data/completionChart';//'<? echo site_url("get_chart_data/completionChart");?>';
    var divToTable	= "";
    jQuery.ajax({
        type: "POST",
        async: false,
         url:doLoginMethodUrl,
        data: {chart: chart,datasource: dataSource,sql:sql,table:table},
        success: function(json)
        {
           /*primero dibujo la tabla*/
          
            var arrJson = [];
            arrJson = json.split('|');   
            options = arrJson[0];
            source  = arrJson[1];
            tipo    = arrJson[2];
            consulta    = arrJson[3];
            colModel	= arrJson[5];
            colName		= arrJson[6];
			
          dibujameLaTabla(options,colModel,div,colName,tipo,source,consulta,chart);
        }
        
    });
    /*usando el tooltip de twitter*/
				var op	= {content:"<span style='color:#000;'>"+tooltipText+"</span>",
							trigger:'hover',
							placement:'top',
							//title:"<span style='color:#000;'><h4>Infotab<h4></span>",
							html:true
						};
						
				jQuery('#'+toolId).tooltip(op);
				/*usando el tooltip de twitter*/
    
}


//ESTA FUNCION ESTA ANDANDO JOYA SIN OPCIONES DE GROUPING
function getOptionsGridNoGruping(options){

	//to get the options
		var cadenaOp = '';
        //divido cada property que viene con ;
        var properties = options.split(';');
		var obj = {};
		var arr = [];
        //itero dentro de cada tupla separada por ";"
		properties.forEach(function(property) {
            //divido la tupla en label y valor mediante ":"
			var tup = property.split(':');
			var remplazo	= tup[1];
            //obj[tup[0]] = remplazo;
            pos2    = remplazo.indexOf("=");
			if(pos2>0){
				remplazo = remplazo.replace(/=/g, ":");
				//obj[tup[0]] = values;
			}else{
				//si la primer tupla dividida no tiene tuplas adentro la almaceno directamente en opciones
				//var r   = remplazo.trim();
				//obj[tup[0]] = r;
			}
			obj[tup[0]] = remplazo;
			cadenaOp += tup[0]+":"+remplazo+",";
            //alert(cadenaOp);
                        			
		});
		//return cadenaOp;
		return obj;
		//options
	
}
function getOptionsGrid(options){

        //divido cada property que viene con ;
        var properties = options.split(';');
		var obj = {};
		var arr = [];
        //itero dentro de cada tupla separada por ";"
		properties.forEach(function(property) {
            //divido la tupla en label y valor mediante ":"
			var tup = property.split(':');
			var remplazo	= tup[1];
            //los rowlist es un arreglo por eso lo cargo asi
            if(tup[0]=='rowList'){
				var row = [];
				var i = 0;
				var lista = remplazo.split(',');
				lista.forEach(function(item) {
					row[i]=item;
					i++;
					});
				
				obj[tup[0]]=row;
			}else{
				//busco si adentro hay mas tuplas para crear los arrays respectivos
				pos = remplazo.indexOf(",");
				//si el campo tiene un "_" lo reemplazo por "."
				tup[0] = tup[0].replace(/_/g, ".");
				//alert("el campo es "+tup[0]+" valor= "+remplazo);
				
				if( pos>0 ){
					var values  = {};
					//puede que el valor tenga adentro opciones separadas por ","
					var valores = remplazo.split(',');
					//itero cada tupla de valor que adentro contiene label=valor nuevamente
					//obj[tup[0]]	= '{';
					valores.forEach(function(val) {
						var aux = val.split('=');
						//cargo el arreglo de valores para la tupla superior
						//alert(aux[0]);
						var label   = aux[0];
						var dato	= new Array();
						//alert('antes del case:'+label);
						label	= label.trim();
						var auc	= aux[1].trim();
						switch(label){
							case "groupField":
								dato[0]=auc;
								values[label]=dato;
							break;
							case "groupColumnShow":
								if(auc=='true'){dato[0]=true;}else{dato[0]=false;}
								values[label]=dato;
								
							break;
							case "groupText":
								dato[0]=auc;
								values[label]=dato;
								
							break;
							case "groupCollapse":
								if(auc=='true'){values[label]=true;}else{values[label]=false;}
								
							break;
							case "groupOrder":
								dato[0]=auc;
								values[label]=dato;
						 	break;
							case "groupSummary":
								if(auc=='true'){dato[0]=true;}else{dato[0]=false;}
								values[label]=dato;
							break;
							case "showSummaryOnHide":
								if(auc=='true'){values[label]=true;}else{values[label]=false;}
									
							break;
							case "groupDataSorted":
								if(auc=='true'){values[label]=true;}else{values[label]=false;}
								
							break;
							}
						
						//alert('values['+label+']='+values[label]);
						//alert('aux[1] ' +aux[1]);
						
					});
				
				  // obj[tup[0]]	+= '}';
					obj[tup[0]] = values;
				}else{
					pos2    = remplazo.indexOf("=");
					if(pos2>0){
						var values  = {};
						//puede que el valor tenga adentro una sola tupla label=valor
						var aux = remplazo.split('=');
						//cargo el arreglo de valores para la tupla superior
						var label   = aux[0];
						values[label]=aux[1];
						obj[tup[0]] = values;
					}else{
						//si la primer tupla dividida no tiene tuplas adentro la almaceno directamente en opciones
						var r   = remplazo.trim();
						if(r=='true'){
							obj[tup[0]] =true;
						}else{
							if(r=='false'){
							obj[tup[0]] =false;
							}else{
								obj[tup[0]] = r;
								}
						}
								
						//obj[tup[0]] = r;
					}
					
				}
				//alert("obj["+tup[0]+"] "+obj[tup[0]]);	
			}
            
            
                        			
		});
		return obj;
		//options
	
}
function getColmodel(col_model){

        //divido cada property que viene con ;
        var properties = col_model.split(';');
		var obj = [];
		//itero dentro de cada tupla separada por ";"
        i=0;
        var cadenaFinal='';
		properties.forEach(function(property) {
			var arr = {};
			var cadenaOp = '';
            //divido la tupla en label y valor mediante ":"
            var valores = property.split(',');
            valores.forEach(function(val) {
					var tup = val.split(':');
					var remplazo	= tup[1];
					
                    arr[tup[0]] = remplazo;
                    cadenaOp	+= tup[0]+':'+remplazo+'-';
                    
                });
                
           obj[i]   = arr;
          i+=1;
		});
		
		return obj;
		//options
	
}
function getColName(col_name){

        //divido cada property que viene con ,
        var properties = col_name.split(',');
		var obj = [];
		
        i=0;
        var cadenaFinal='';
		properties.forEach(function(property) {
			obj[i]   = property;
			i+=1;
		});
		
		return obj;
		//options
	
}
 function dibujameLaTabla(options,col_model,divTable,col_name,tipo,source,consulta,chart,sucu,desde,hasta){
	 var doLoginMethodUrl = '../../get_json_grid';// '<? echo site_url("get_json_grid");?>';
	 var pagerDiv	= divTable.split("_");
	 pagerDiv		= "#"+pagerDiv[0]+"_pager"; 
	 var opciones	= getOptionsGrid(options);//getOptionsGridNoGruping(options);//
	 var modelo		= getColmodel(col_model);
	 var names		= getColName(col_name);
	 //reemplazo el . por un _ sino el js no funciona!!! fucking jqgrid!
	 var toolId		= divTable.replace('.', "_");
	 var txtDiv		= toolId+'Table';
	 
	jQuery.extend(jQuery.jgrid.defaults, opciones);
	jQuery('div.tab_content table').each(function(index) {//busco todas las tablas dentro de tab_content
			var activeTab = jQuery(this).attr("id");
			if(activeTab==txtDiv){ //si es la tabla que busco le aplico la grilla
				jQuery(this).GridUnload();
				jQuery(this).jqGrid({
					scroll:1,
					loadonce:true,
					url: doLoginMethodUrl,                  // - webinvoke post method
					postData: {tipo: tipo,datasource: source,sql:consulta,chart:chart,sucursal:sucu,desde:desde,hasta:hasta},
					search: true,
					datatype: 'json',
					mtype: 'POST',
					pager:pagerDiv,     
					/*jsonReader : {
						 root: "rows",
						 page: "page",
						 total: "total",
						 records: "records",
						 repeatitems: true,
						 cell: "cell",
						 id: "id"
					   },*/
					   
					colNames:names,
					colModel:modelo,
					footerrow: true,
					userDataOnFooter: true
				});
				
				jQuery(this).jqGrid('navGrid',pagerDiv,{add:false,edit:false,del:false});
				jQuery(this).jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
			}
	});
	
	
}
function getGridWithfilters(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText){
	/*activar el div con los filtros con display:block*/
	insertHeaderChart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText);
	var arrtabName	= [];
	arrtabName	= div.split("_");
	var tabName	= arrtabName[0];
	jQuery("#"+tabName+"_gridFilters").css("display","block");
	jQuery("#"+tabName+"_btn").click(function(){
		var sucu	= jQuery("#"+tabName+"_sucursal").val();
		var desde	= jQuery("#"+tabName+"_from").val();
		var hasta	= jQuery("#"+tabName+"_to").val();
	/*traer los datos de consulta y demas para ejecutar el 2 json*/
		var doLoginMethodUrl = '../../get_chart_data/completionChart';//'<? echo site_url("get_chart_data/completionChart");?>';
		var divToTable	= "";
		jQuery.ajax({
			type: "POST",
			async: false,
			 url:doLoginMethodUrl,
			data: {chart: chart,datasource: dataSource,sql:sql,table:table},
			success: function(json)
			{
			   /*primero dibujo la tabla*/
			  
				var arrJson = [];
				arrJson = json.split('|');   
				options = arrJson[0];
				source  = arrJson[1];
				tipo    = arrJson[2];
				consulta    = arrJson[3];
				colModel	= arrJson[5];
				colName		= arrJson[6];
				//alert("server:"+source+" consulta:"+consulta+"div: "+div);
				//,sucursal:sucu,desde:desde,hasta:hasta
				//jQuery("#"+div).GridUnload();
			  dibujameLaTabla(options,colModel,div,colName,tipo,source,consulta,chart,sucu,desde,hasta);
			}
		 });
	});
	
}
function getTableGchart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText){
	//if(redibuja==true){
		insertHeaderChart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText);
		
	//}else{
		
	//}
	/*if(redibuja==true){
	}else{
		var toolId	= div.replace('.', "_");
		var padre = document.getElementById(div).parentNode;
		var reloadImg = "<img src='<?= base_url() .APPPATH ?>images/gtk-refresh.png' alt='reload' name='getTableGchart,"+chart+","+dataSource+","+sql+","+div+","+table+","+titulo+"' class='reload' height='16' width='16' style='float: right; cursor: pointer;' >";

		var img = "<img src='<?= base_url() .APPPATH ?>images/printIco.png' alt='Imprimir' class='printImage' height='16' width='16' style='float: right; cursor: pointer;'>";
		var plusImg	= "<img src='<?= base_url() .APPPATH ?>images/uArrow.png' alt='mas' class='msg_head' height='16' width='16' style='float: right; cursor: pointer;'>";
		if(tabDD!=''){
			var drillWownImg = "<img src='<?= base_url() .APPPATH ?>images/drillDown.png' onclick='go(\""+tabDD+"\");' height='16' width='16' style='float: left; cursor: pointer;' >";   
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div>"+drillWownImg+"<h3 id='"+toolId+"'>"+titulo+"</h3>";
		}else{
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div><h3 id='"+toolId+"'>"+titulo+"</h3>";
		}
	}*/
	var toolId	= div.replace('.', "_");
    var options;//={};
    var source="";
    var tipo="";
    var consulta="";
    var grafico="";
	var formaterCol	= "";
	var formaterWidth = "";
	var formatersColumns = "";
    var doLoginMethodUrl = '../../get_chart_data/completionChart';//'<? echo site_url("get_chart_data/completionChart");?>';
    jQuery.ajax({
        type: "POST",
        async: false,
         url:doLoginMethodUrl,
        data: {chart: chart,datasource: dataSource,sql:sql,table:table},
        success: function(json)
        {
			var arrJson = [];
            arrJson 	= json.split('|');   
            options		= arrJson[0];
            source		= arrJson[1];
            tipo    	= arrJson[2];
            consulta    = arrJson[3];
            grafico		= arrJson[4];
            //formaterCol = arrJson[7];
			//formaterWidth	= arrJson[8];
			formatersColumns	= arrJson[9]; 
			
			//alert(formatersColumns);
            google.setOnLoadCallback(function(){ drawTable(options,tipo,source,consulta,grafico,div,chart,table,formatersColumns) });
		}
	});
	function drawTable(options,tipo,source,consulta,grafico,div,chart,table,formatersColumns) {
        var doLoginMethodUrl =  '../../get_json_data';//'<? echo site_url("get_json_data");?>';
        
        try {
			var JsonData = jQuery.ajax({
        	type: "POST",
        	data: {tipo: tipo,datasource: source,sql:consulta,chart:chart,table:table},
        	async: false,
         	url:doLoginMethodUrl,
            dataType:"json",
			async: false
			}).responseText;
			try{
			var data = new google.visualization.DataTable(JsonData);
			}catch(exe){
				alert("tabla sin columnas");
			}
                
			var obj	= getOptionsObjets(options);
		   
			//formaterCol	= parseInt(formaterCol);
			
			//formaterWidth	= parseInt(formaterWidth);
			var arrFormaters	= formatersColumns.split(';');
			arrFormaters.forEach(function(property) {
				var tup = property.split(',');
				formaterCol	= parseInt(tup[0]);
				formaterWidth	= parseInt(tup[4]);
				var colornegative	= tup[1];
				var colorpositive	= tup[2];
				var showvalue		= tup[3];
				showvalue			= showvalue.trim();
				
				if(showvalue=='true'){
					var formatter = new google.visualization.TableBarFormat({width:formaterWidth,showValue:true,colorNegative:colornegative,colorPositive:colorpositive});
				}else{
					var formatter = new google.visualization.TableBarFormat({width:formaterWidth,showValue:false,colorNegative:colornegative,colorPositive:colorpositive});
				}
				
				formatter.format(data,formaterCol);
			});
				
			// Create and draw the visualization.
			visualization = new google.visualization.Table(document.getElementById(div));
			visualization.draw( data, obj); 
		} catch (exception) {
		  alert("Json invalido");
		  return false;
		}
	}
	/*usando el tooltip de twitter*/
				var op	= {content:"<span style='color:#000;'>"+tooltipText+"</span>",
							trigger:'hover',
							placement:'top',
							//title:"<span style='color:#000;'><h4>Infotab<h4></span>",
							html:true
						};
						
				jQuery('#'+toolId).tooltip(op);
				/*usando el tooltip de twitter*/
    //
}
/*tabla para gdocs*/
function getTableGchartGdocs(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText){
	//if(redibuja==true){
		insertHeaderChart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText);
		var padre = document.getElementById(div).parentNode;
		var abuelo = padre.parentNode;
		var vizcaabuelo = abuelo.parentNode;
		//creo un contenedor
		var divContainer=document.createElement("div");
		divContainer.setAttribute('style','float: left; width: 15%;');//divContainer.setAttribute('class','accordion-heading');
		//creo el header otro div 
		var divHeader=document.createElement("div");
		divHeader.setAttribute('class','msg_head accordion-toggle in');divHeader.setAttribute('style','float:left');
		//creo el contenedor delos iconos
		var divContent=document.createElement("div");
		divContent.setAttribute('class','portletContent accordion-toggle in');divContent.setAttribute('style','float:left;display:none;');
		
		//creo el primer icono dentro de un a 
		var header=document.createElement("div");
		header.setAttribute('style','float:left');//aHeader.setAttribute('href','#');//aHeader.setAttribute('class','reload');
		var i=document.createElement("i");
		i.setAttribute('class','icon-th icon-white');
		//inserto el i dentro del a
		header.appendChild(i);
		//inserto el a dentro del divcontenedor
		divHeader.appendChild(header);
		
		//creo el primer icono dentro de un a 
		var aContent=document.createElement("a");
		aContent.setAttribute('href','#');aContent.setAttribute('class','reload');aContent.setAttribute('style','float:left');
		var iContent=document.createElement("i");
		iContent.setAttribute('class','icon-refresh');iContent.setAttribute('name','getChartGdocs,'+chart+','+dataSource+','+sql+','+div+','+table+','+titulo+'');
		//inserto el i dentro del a
		aContent.appendChild(iContent);
		//inserto el a dentro del divcontenedor
		divContent.appendChild(aContent);
		//creo el segundo icono
		var aContent2=document.createElement("a");
		aContent2.setAttribute('href','#');aContent2.setAttribute('class','printImage');aContent2.setAttribute('style','float:left');
		var iContent2=document.createElement("i");
		iContent2.setAttribute('class','icon-print');//iContent2.setAttribute('name','getChartGdocs,'+chart+','+dataSource+','+sql+','+div+','+table+','+titulo+'');
		//inserto el i dentro del a
		aContent2.appendChild(iContent2);
		//inserto el a dentro del divcontenedor
		divContent.appendChild(aContent2);
		
		//inserto el header y el contenedor dentro del main containet
		divContainer.appendChild(divHeader);
		divContainer.appendChild(divContent);
		
		//busco el primer hijo de la clase accordion-heading para insertar antes de el, el nuevo elemento
		var donde = vizcaabuelo.getElementsByClassName('accordion-heading')[0];
		var txt = document.createTextNode(titulo);
		donde.getElementsByTagName('a')[0].appendChild(txt);//innerHTML = 
		//si es la segunda vez que le doy click, primero elimino el elemento repetido
		donde.removeChild(donde.firstChild);
		donde.insertBefore(divContainer,donde.firstChild); 
	//}else{
		
	//}
	/*if(redibuja==true){
	}else{
		var toolId	= div.replace('.', "_");
		var padre = document.getElementById(div).parentNode;
		var reloadImg = "<img src='<?= base_url() .APPPATH ?>images/gtk-refresh.png' alt='reload' name='getTableGchartGdocs,"+chart+","+dataSource+","+sql+","+div+","+table+","+titulo+"' class='reload' height='16' width='16' style='float: right; cursor: pointer;' >";

		var img = "<img src='<?= base_url() .APPPATH ?>images/printIco.png' alt='Imprimir' class='printImage' height='16' width='16' style='float: right; cursor: pointer;'>";
		var plusImg	= "<img src='<?= base_url() .APPPATH ?>images/uArrow.png' alt='mas' class='msg_head' height='16' width='16' style='float: right; cursor: pointer;'>";
		if(tabDD!=''){
			var drillWownImg = "<img src='<?= base_url() .APPPATH ?>images/drillDown.png' onclick='go(\""+tabDD+"\");' height='16' width='16' style='float: left; cursor: pointer;' >";   
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div>"+drillWownImg+"<h3 id='"+toolId+"'>"+titulo+"</h3>";
		}else{
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div><h3 id='"+toolId+"'>"+titulo+"</h3>";
		}
	}*/
	var toolId	= div.replace('.', "_");
    var options;//={};
    var source="";
    var tipo="";
    var consulta="";
    var grafico="";
	var formaterCol	= "";
	var formaterWidth = "";
	var formatersColumns = "";
    var doLoginMethodUrl = '../../get_chart_data/completionChart';//'<? echo site_url("get_chart_data/completionChart");?>';
   jQuery.ajax({
        type: "POST",
        async: false,
         url:doLoginMethodUrl,
        data: {chart: chart,datasource: dataSource,sql:sql,table:table},
        success: function(json)
        {
			var arrJson = [];
            arrJson 	= json.split('|');  
            options		= arrJson[0];
            source		= arrJson[1];
            var arrSource	= source.split(',');
			var urlSpreadsheet	= arrSource[0];
			tipo    	= arrJson[2];
            consulta    = arrJson[3];
            grafico		= arrJson[4];
            //formaterCol = arrJson[7];
			//formaterWidth	= arrJson[8];
			formatersColumns	= arrJson[9]; 
			var opciones	= getOptionsObjets(options)
			var arrFormaters	= formatersColumns.split(';');
			
			query = new google.visualization.Query(urlSpreadsheet);
			query.send(handleQueryResponseTable);
			
			function handleQueryResponseTable(response) {
			  if (response.isError()) {
				alert('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
				return;
				}
			
				var data = response.getDataTable();
				/*aplico los formtaters*/
				arrFormaters.forEach(function(property) {
				var tup = property.split(',');
				formaterCol	= parseInt(tup[0]);
				formaterWidth	= parseInt(tup[4]);
				var colornegative	= tup[1];
				var colorpositive	= tup[2];
				var showvalue		= tup[3];
				showvalue			= showvalue.trim();
				
					if(showvalue=='true'){
						var formatter = new google.visualization.TableBarFormat({width:formaterWidth,showValue:true,colorNegative:colornegative,colorPositive:colorpositive});
					}else{
						var formatter = new google.visualization.TableBarFormat({width:formaterWidth,showValue:false,colorNegative:colornegative,colorPositive:colorpositive});
					}
				
				formatter.format(data,formaterCol);
				});
				/*fin de formaters*/
				visualization = new google.visualization.Table(document.getElementById(div));
				visualization.draw( data, opciones); 	
			}
		
		}
		
	});
	/*usando el tooltip de twitter*/
				var op	= {content:"<span style='color:#000;'>"+tooltipText+"</span>",
							trigger:'hover',
							placement:'top',
							//title:"<span style='color:#000;'><h4>Infotab<h4></span>",
							html:true
						};
						
				jQuery('#'+toolId).tooltip(op);
				/*usando el tooltip de twitter*/
	
}

/*tabla para gdocs*/
/*tabla con string filter*/
function getTableStringFilter(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText){
	//if(redibuja==true){
		insertHeaderChart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText);
		var padre = document.getElementById(div).parentNode;
		var abuelo = padre.parentNode;
		var vizcaabuelo = abuelo.parentNode;
		//creo un contenedor
		var divContainer=document.createElement("div");
		divContainer.setAttribute('style','float: left; width: 15%;');//divContainer.setAttribute('class','accordion-heading');
		//creo el header otro div 
		var divHeader=document.createElement("div");
		divHeader.setAttribute('class','msg_head accordion-toggle in');divHeader.setAttribute('style','float:left');
		//creo el contenedor delos iconos
		var divContent=document.createElement("div");
		divContent.setAttribute('class','portletContent accordion-toggle in');divContent.setAttribute('style','float:left;display:none;');
		
		//creo el primer icono dentro de un a 
		var header=document.createElement("div");
		header.setAttribute('style','float:left');//aHeader.setAttribute('href','#');//aHeader.setAttribute('class','reload');
		var i=document.createElement("i");
		i.setAttribute('class','icon-th icon-white');
		//inserto el i dentro del a
		header.appendChild(i);
		//inserto el a dentro del divcontenedor
		divHeader.appendChild(header);
		
		//creo el primer icono dentro de un a 
		var aContent=document.createElement("a");
		aContent.setAttribute('href','#');aContent.setAttribute('class','reload');aContent.setAttribute('style','float:left');
		var iContent=document.createElement("i");
		iContent.setAttribute('class','icon-refresh');iContent.setAttribute('name','getChartGdocs,'+chart+','+dataSource+','+sql+','+div+','+table+','+titulo+'');
		//inserto el i dentro del a
		aContent.appendChild(iContent);
		//inserto el a dentro del divcontenedor
		divContent.appendChild(aContent);
		//creo el segundo icono
		var aContent2=document.createElement("a");
		aContent2.setAttribute('href','#');aContent2.setAttribute('class','printImage');aContent2.setAttribute('style','float:left');
		var iContent2=document.createElement("i");
		iContent2.setAttribute('class','icon-print');//iContent2.setAttribute('name','getChartGdocs,'+chart+','+dataSource+','+sql+','+div+','+table+','+titulo+'');
		//inserto el i dentro del a
		aContent2.appendChild(iContent2);
		//inserto el a dentro del divcontenedor
		divContent.appendChild(aContent2);
		
		//inserto el header y el contenedor dentro del main containet
		divContainer.appendChild(divHeader);
		divContainer.appendChild(divContent);
		
		//busco el primer hijo de la clase accordion-heading para insertar antes de el, el nuevo elemento
		var donde = vizcaabuelo.getElementsByClassName('accordion-heading')[0];
		var txt = document.createTextNode(titulo);
		donde.getElementsByTagName('a')[0].appendChild(txt);//innerHTML = 
		//si es la segunda vez que le doy click, primero elimino el elemento repetido
		donde.removeChild(donde.firstChild);
		donde.insertBefore(divContainer,donde.firstChild); 
	//}else{
		
	//}
	/*if(redibuja==true){
	}else{
		var toolId	= div.replace('.', "_");
		var padre = document.getElementById(div).parentNode;
		var reloadImg = "<img src='<?= base_url() .APPPATH ?>images/gtk-refresh.png' alt='reload' name='getTableStringFilter,"+chart+","+dataSource+","+sql+","+div+","+table+","+titulo+"' class='reload' height='16' width='16' style='float: right; cursor: pointer;' >";
		var img = "<img src='<?= base_url() .APPPATH ?>images/printIco.png' alt='Imprimir' class='printImage' height='16' width='16' style='float: right; cursor: pointer;'>";
		var plusImg	= "<img src='<?= base_url() .APPPATH ?>images/uArrow.png' alt='mas' class='msg_head' height='16' width='16' style='float: right; cursor: pointer;'>";
		if(tabDD!=''){
			var drillWownImg = "<img src='<?= base_url() .APPPATH ?>images/drillDown.png' onclick='go(\""+tabDD+"\");' height='16' width='16' style='float: left; cursor: pointer;' >";   
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div>"+drillWownImg+"<h3 id='"+toolId+"'>"+titulo+"</h3>";
		}else{
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div><h3 id='"+toolId+"'>"+titulo+"</h3>";
		}

	}*/
	var toolId	= div.replace('.', "_");
	 document.getElementById(div).innerHTML = '<div id="control1'+div+'" class="filterContainer" style="width: 100%;margin: 5px;"></div><div class="tableContainer" style="float:left" id="chart1'+div+'"></div>';
	 var options;//={};
		var source="";
		var tipo="";
		var consulta="";
		var grafico="";
		var doLoginMethodUrl = '../../get_chart_data/completionChart';//'<? echo site_url("get_chart_data/completionChart");?>';//'get_chart_data/completionChart';
        jQuery.ajax({
            type: "POST",
            async: false,
             url:doLoginMethodUrl,
            data: {chart: chart,datasource: dataSource,sql:sql,table:table},
			success: function(json)
			{
				var arrJson = [];
				arrJson = json.split('|');   
				options = arrJson[0];
				source  = arrJson[1];
				var arrSource	= source.split(',');
				var urlSpreadsheet	= arrSource[0];
				tipo    = arrJson[2];
				consulta    = arrJson[3];
				grafico	= arrJson[4];
				filters = arrJson[7];
				formatersColumns	= arrJson[9]; 
				var arrFormaters	= formatersColumns.split(';');
				/*funcion que va a dibujar con datos de json o spreadsheet*/
				drawStringFilterTable(options,tipo,source,consulta,grafico,div,chart,table,arrFormaters,filters);
				
			}

		});
		function drawStringFilterTable(options,tipo,source,consulta,grafico,div,chart,table,arrFormaters,filters){
				var doLoginMethodUrl =  '../../get_json_data';//'<? echo site_url("get_json_data");?>';
				var JsonData = jQuery.ajax({
					type: "POST",
					data: {tipo: tipo,datasource: source,sql:consulta,chart:chart,table:table},
					async: false,
					url:doLoginMethodUrl,
				   dataType:"json",
				  async: false
				}).responseText;
				var data = new google.visualization.DataTable(JsonData);
				
				/*aplico los formtaters*/
				arrFormaters.forEach(function(property) {
				var tup = property.split(',');
				formaterCol	= parseInt(tup[0]);
				formaterWidth	= parseInt(tup[4]);
				var colornegative	= tup[1];
				var colorpositive	= tup[2];
				var showvalue		= tup[3];
				showvalue			= showvalue.trim();
				
					if(showvalue=='true'){
						var formatter = new google.visualization.TableBarFormat({width:formaterWidth,showValue:true,colorNegative:colornegative,colorPositive:colorpositive});
					}else{
						var formatter = new google.visualization.TableBarFormat({width:formaterWidth,showValue:false,colorNegative:colornegative,colorPositive:colorpositive});
					}
				
				formatter.format(data,formaterCol);
				});
				/*fin de formaters*/
				var arrFilter	= filters.split(',');
				var containerFilter	= 'control1'+div;
				var containerWrapper	= 'chart1'+div;
				var opciones	= getOptionsObjets(options);
				if(arrFilter[5]=='true'){
					var typing	= true;
					}else{
						var typing	= false;
					}
				if(arrFilter[6]=='true'){
					var multiple	= true;
					}else{
						var multiple	= false;
					}
				var stringFilter = new google.visualization.ControlWrapper({
					'controlType': arrFilter[4],
					'containerId': containerFilter,
					'options': {
					   'filterColumnLabel': arrFilter[0],
					   'matchType':'any',
						"ui": {"label": arrFilter[1],
						"caption":"Seleccione",
						"labelSeparator": arrFilter[2],
						"labelStacking":arrFilter[3],
						"allowTyping":typing,
						"allowMultiple":multiple,
						"selectedValuesLayout":arrFilter[7]} 
					}
				  });
				var table = new google.visualization.ChartWrapper({
					dataTable:data,
					//dataSourceUrl: urlSpreadsheet,
					chartType: 'Table',
					options:opciones,
					containerId:containerWrapper
				});
				 var dashboard = new google.visualization.Dashboard(document.getElementById(div)).
				// Configure the string filter to affect the table contents
				bind(stringFilter, table).
				// Draw the dashboard
				draw(data);
				
		}
		/*usando el tooltip de twitter*/
				var op	= {content:"<span style='color:#000;'>"+tooltipText+"</span>",
							trigger:'hover',
							placement:'top',
							//title:"<span style='color:#000;'><h4>Infotab<h4></span>",
							html:true
						};
						
				jQuery('#'+toolId).tooltip(op);
				/*usando el tooltip de twitter*/
}
/*fin tabla con string filter*/
function getIframe(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText){
	//if(redibuja==true){
		insertHeaderChart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText);
		
	//}else{
		
	//}
	/*if(redibuja==true){
	}else{
		var toolId	= div.replace('.', "_");
		var padre = document.getElementById(div).parentNode;
		var reloadImg = "<img src='<?= base_url() .APPPATH ?>images/gtk-refresh.png' alt='reload' name='getIframe,"+chart+","+dataSource+","+sql+","+div+","+table+","+titulo+"' class='reload' height='16' width='16' style='float: right; cursor: pointer;' >";

		var img = "<img src='<?= base_url() .APPPATH ?>images/printIco.png' alt='Imprimir' class='printImage' height='16' width='16' style='float: right; cursor: pointer;'>";
		var plusImg	= "<img src='<?= base_url() .APPPATH ?>images/uArrow.png' alt='mas' class='msg_head' height='16' width='16' style='float: right; cursor: pointer;'>";
		if(tabDD!=''){
			var drillWownImg = "<img src='<?= base_url() .APPPATH ?>images/drillDown.png' onclick='go(\""+tabDD+"\");' height='16' width='16' style='float: left; cursor: pointer;' >";   
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div>"+drillWownImg+"<h3 id='"+toolId+"'>"+titulo+"</h3>";
		}else{
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div><h3 id='"+toolId+"'>"+titulo+"</h3>";
		}
	}*/
	var toolId	= div.replace('.', "_");
    var options;//={};
    var source="";
    var tipo="";
    var consulta="";
    var grafico="";
    var iframe  = '<iframe ';   
    var doLoginMethodUrl = '../../get_chart_data/completionChart';// '<? echo site_url("get_chart_data/completionChart");?>';
    jQuery.ajax({
        type: "POST",
        async: false,
         url:doLoginMethodUrl,
        data: {chart: chart,datasource: dataSource,sql:sql,table:table},
        success: function(json)
        {
            var arrJson = [];
            arrJson = json.split('|');   
            options = arrJson[0];
            arrOptions  = options.split(';');
            arrOptions.forEach(function(property) {
                       
                var tup = property.split(':');
                var tupi	= tup[1];
                pos = tupi.indexOf("=");
                if( pos>0 ){
					tupi = tupi.replace("=",":"); 
				}else{
				
				}
                iframe += tup[0]+'="'+tupi+' "';
            });
            iframe += " style='border: 0 none;'/>"; 
            document.getElementById(div).innerHTML = iframe;
            
           }
            
    });
    /*usando el tooltip de twitter*/
				var op	= {content:"<span style='color:#000;'>"+tooltipText+"</span>",
							trigger:'hover',
							placement:'top',
							//title:"<span style='color:#000;'><h4>Infotab<h4></span>",
							html:true
						};
						
				jQuery('#'+toolId).tooltip(op);
				/*usando el tooltip de twitter*/
}
/*aca va a ir la funcion pivot table*/

function getPivotTable(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText){
	//if(redibuja==true){
		insertHeaderChart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText);
		
	//}else{
		
	//}
	/*
	if(redibuja==true){
	}else{
		var toolId	= div.replace('.', "_");
		var padre = document.getElementById(div).parentNode;
		var reloadImg = "<img src='<?= base_url() .APPPATH ?>images/gtk-refresh.png' alt='reload' name='getPivotTable,"+chart+","+dataSource+","+sql+","+div+","+table+","+titulo+"' class='reload' height='16' width='16' style='float: right; cursor: pointer;' >";

		var img = "<img src='<?= base_url() .APPPATH ?>images/printIco.png' alt='Imprimir' class='printImage' height='16' width='16' style='float: right; cursor: pointer;'>";
		var plusImg	= "<img src='<?= base_url() .APPPATH ?>images/uArrow.png' alt='mas' class='msg_head' height='16' width='16' style='float: right; cursor: pointer;'>";
		if(tabDD!=''){
			var drillWownImg = "<img src='<?= base_url() .APPPATH ?>images/drillDown.png' onclick='go(\""+tabDD+"\");' height='16' width='16' style='float: left; cursor: pointer;' >";   
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div>"+drillWownImg+"<h3 id='"+toolId+"'>"+titulo+"</h3>";
		}else{
			padre.getElementsByTagName('span')[0].innerHTML = "<div style=padding-top:0.5%;float:right;>"+reloadImg+plusImg+img+"</div><h3 id='"+toolId+"'>"+titulo+"</h3>";
		}
	}
	*/
	
	var toolId	= div.replace('.', "_");
    var options;//={};
    var source="";
    var tipo="";
    var consulta="";
    var grafico="";
	var colModel	= "";
    var doLoginMethodUrl = '../../get_chart_data/completionChart';//'<? echo site_url("get_chart_data/completionChart");?>';
    var divToTable	= div;
    jQuery.ajax({
        type: "POST",
        async: false,
         url:doLoginMethodUrl,
        data: {chart: chart,datasource: dataSource,sql:sql,table:table},
        success: function(json)
        {
            var arrJson = [];
            arrJson = json.split('|');   
            options = arrJson[0];
            source  = arrJson[1];
            tipo    = arrJson[2];
            consulta    = arrJson[3];
           			
          drawPivotTable(options,tipo,source,consulta,chart,divToTable,table);
        }
        
    });
    /*usando el tooltip de twitter*/
				var op	= {content:"<span style='color:#000;'>"+tooltipText+"</span>",
							trigger:'hover',
							placement:'top',
							//title:"<span style='color:#000;'><h4>Infotab<h4></span>",
							html:true
						};
						
				jQuery('#'+toolId).tooltip(op);
				/*usando el tooltip de twitter*/
    
}
function getOptionsPivot(arreglo){
	//divido cada property que viene con :
        var properties = arreglo.split(':');
        //cargo solo los valores en el arreglo para iterarlos
        properties		= properties[1];
        var pos = properties.indexOf(",");
        var obj = [];
        if( pos>0 ){
			i=0;
			propiedades	= properties.split(",");
			propiedades.forEach(function(property) {
				  obj[i]   = property;
				  
				  i+=1;						
			
			});
		}else{
			obj[0]   = properties;
			
		}
        	
		return obj;
	}
function drawPivotTable(options,tipo,source,consulta,grafico,div,table){
	var header = Array();
	var doLoginMethodUrl =  '../../get_json_pivot';//'<? echo site_url("get_json_pivot");?>';
    var data	= new Array();
    var arrOptions = [];
    arrOptions	= options.split(";");
   
	var headerRowIndexes = getOptionsPivot(arrOptions[0]);
	var headerColIndexes = getOptionsPivot(arrOptions[1]);
	var filterIndexes = getOptionsPivot(arrOptions[2]);
	var dataColumnIndex = getOptionsPivot(arrOptions[3]);
	/*alert(headerRowIndexes);alert(headerColIndexes);alert(filterIndexes);alert(dataColumnIndex);*/
    jQuery.ajax({
        type: "POST",
        async: false,
        url:doLoginMethodUrl,
        data: {chart: grafico,datasource: source,sql:consulta,table:table},
        success: function(json)
        {
				var i = 0;
                var j	= 0;
                
                try {
					var deco = eval('(' + json + ')');
				                              
              // if(deco){
                //itero cada registro devuelto
					jQuery.each(deco.d, function(key, value) { 
						
						var row	= new Array();
						var dataRow = new Array();
						var columna	= deco.d[i];
						var l	= 0;
						//itero cada columna de cada registro devuelto
						jQuery.each(columna,function(k,v){
							//dataRow = new Array();
							if(j==0){
								//asigno los campos que van a ir en el header traidos desde el ajax
								header[l]	= k;
								
							}
							dataRow[l]	= v;
							//itero los indices del header
							l++;
													
						});
						j++;
						row	= dataRow;
						
					
						data[i]	= row;
						i+=1;
					});
					drawPivot(data,div,header,headerRowIndexes,headerColIndexes,filterIndexes,dataColumnIndex);//,headerRowIndexes,headerColIndexes,filterIndexes,dataColumnIndex) ;
				 /*}else{
					 alert("Json invalido, problemas de conexion con el servidor de db");
				}  */ 
				} catch (exception) {
				  //It's advisable to always catch an exception since eval() is a javascript executor...
				  var deco = null;
				  alert("no se encontro el driver pdo");
				}           
		}
            
    });
   
}

function drawPivot(data,div,header,headerRowIndexes,headerColIndexes,filterIndexes,dataColumnIndex){//,headerRowIndexes,headerColIndexes,filterIndexes,dataColumnIndex) {
	var idArr				=	[];
	idArr					=	div.split("_");	
	var idFiltersAccordion	=	"#"+idArr[0]+"_FiltrosAccordion";
	var idFilters			= 	idArr[0]+"_Filtros";
	//alert(idFilters);
	jQuery( idFiltersAccordion ).css("display","block");
	jQuery( idFiltersAccordion ).accordion({
			collapsible: true
			
		});
   //se deben modificar los indices de los arreglos para referenciar a los traidos via ajax
   //var pivot = new OAT.Pivot(div,"pivot_chart","PivotFunction_Filtros",header,data,[3],[0,1],[7,4,5],[9],null);
	var pivot = new OAT.Pivot(div,"pivot_chart",idFilters,header,data,headerRowIndexes,headerColIndexes,filterIndexes,dataColumnIndex,null);
    var aggRef = function() {
        pivot.options.agg = parseInt($v("pivot_agg"));
        pivot.go();
    }
    
  pivot.go();  
}

/*
/*fin funcion pivot table*/

/*funcion column  chart de highchart*/
function getWidth(options){
	//divido cada property que viene con ;
		var width		= '';
        var properties	= options.split(';');
		//var obj = [];
		//itero dentro de cada tupla separada por ";"
        i=0;
       // var cadenaFinal='';
		properties.forEach(function(property) {
			
            //divido la tupla en label y valor mediante ":"
            var valores = property.split(':');
            if(valores[0]=='width'){
					width	= valores[1];
				}
         
		});
		return width;

}
function getHeight(options){
	//divido cada property que viene con ;
		var height		= '';
        var properties	= options.split(';');
	
		properties.forEach(function(property) {
			var valores = property.split(':');
			if(valores[0]=='height'){
					height	= valores[1];
				}
                         
      });
		return height;

}
function getTextData(options){
	//divido cada property que viene con ;
		var height		= '';
        var properties	= options.split(';');
		var text		= [];
		var i 			= 0;
		properties.forEach(function(property) {
			var valores = property.split(':');
			text[i]		= valores[1];
			
            i++;         
      });
	return text;

}
function getColumnChartHC(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText){
	
	//if(redibuja==true){
		insertHeaderChart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText);
		
	//}else{}
		
	
	var toolId	= div.replace('.', "_");
    var options;//={};
    var source="";
    var tipo="";
    var consulta="";
    var grafico="";
	var colModel	= "";
    var doLoginMethodUrl = '../../get_chart_data/completionChart';//'<? echo site_url("get_chart_data/completionChart");?>';
    var divToTable	= "";
    var subtitle;	
    var yAxisText;
    var title;
    
    jQuery.ajax({
        type: "POST",
        async: false,
         url:doLoginMethodUrl,
        data: {chart: chart,datasource: dataSource,sql:sql,table:table},
        success: function(json)
        {
           /*primero dibujo la tabla*/
          /*voy a devolver uno a uno los datos separados por |*/
            var arrJson = [];
            arrJson		= json.split('|');   
            options 	= arrJson[0];
            width		= getWidth(options);
            height		= getHeight(options);
            var arrText	= getTextData(options);
            title 		= arrText[0];	
            subtitle	= arrText[1];
            yAxisText	= arrText[2];
            xAxisText	= arrText[3];
            source  	= arrJson[1];
            tipo    	= arrJson[2];
            consulta    = arrJson[3];
			
            
			drawColumnChartHC(grafico,source,consulta,table,div,width,height,title,subtitle,yAxisText,xAxisText);
          //drawColumnChartHC(options,source,consulta,div,grafico,chart,table,div);
        }
        
    });
    /*usando el tooltip de twitter*/
				var op	= {content:"<span style='color:#000;'>"+tooltipText+"</span>",
							trigger:'hover',
							placement:'top',
							//title:"<span style='color:#000;'><h4>Infotab<h4></span>",
							html:true
						};
						
				jQuery('#'+toolId).tooltip(op);
				/*usando el tooltip de twitter*/
    
}
//en esta solo voy a traer los datos con json
function drawColumnChartHC(grafico,source,consulta,table,div,width,height,title,subtitle,yAxisText,xAxisText){
var categorias = new Array();
var seriesData = [];	
var doLoginMethodUrl =  '../../get_json_column_data';
jQuery.ajax({
	type: "POST",
	async: false,
	url:doLoginMethodUrl,
	data: {datasource: source,sql:consulta},
	success: function(json)
	{
		var i = 0;
		var j	= 0;
		//var deco = eval('(' + json + ')');
		try {
			var deco = eval('(' + json + ')');
		} catch (exception) {
		  //It's advisable to always catch an exception since eval() is a javascript executor...
		  var deco = null;
		}
		
	   if(deco){
		//itero cada registro devuelto
		var x	= 0;
		jQuery.each(deco.series, function(key, value) { 	
			serie	={};
			jQuery.each(value, function(k, v) { 	
				if(k=='data'){
					//si dentro hay un arreglo con datos...
					pos = v.indexOf(",");
					var valor	= [];
					if( pos>0 ){
						var arrValores = [];
						arrValores = v.split(','); 
						for(m=0;m<=arrValores.length;m++){
							valor[m]=parseFloat(arrValores[m]);
							}
							
						categorias[x]=seriesData[x]['name'];	
					}else{
						valor[0]	= parseFloat(v);
						serie[k]=valor;
						categorias[x]=xAxisText;
					}
					
				}else{
					
					serie[k]=v;
					
				}
			});
			
			seriesData[x]=serie;
			//categorias[x]=seriesData[x]['name'];
			
			x++;
		});
		getColumnChart(categorias,seriesData,div,width,height,title,subtitle,yAxisText);
		}else{
			alert('json invalido');
		}//fin if deco
	}
});
	
}
function getColumnChart(categorias,seriesData,div,width,height,title,subtitle,yAxisText){
	
columnchart = new Highcharts.Chart({
	chart: {
		renderTo:div,
		type: 'column',
		width:parseInt(width),
		height:parseInt(height)
	},
	title: {
		text:title
	},
	subtitle: {
		text: subtitle
	},
	xAxis:{categories: categorias
	},
	yAxis: {
		min: 0,
		title: {
			text: yAxisText
		}
	},
	legend: {
		layout: 'vertical',
		backgroundColor: '#FFFFFF',
		align: 'left',
		verticalAlign: 'top',
		x: 100,
		y: 70,
		floating: true,
		shadow: true
	},
	tooltip: {
		formatter: function() {
			return ''+
				this.series.name +': '+ this.y;
		}
	},
	plotOptions: {
		column: {
			pointPadding: 0.2,
			borderWidth: 0
		}
	},
		series:seriesData
})	;

//return columnchart;

}
/*column chart highchart*/
function Imprimir(elemento)
{
    
    var Ventana_Impresion = window.open(' ', 'popimpr');
    Ventana_Impresion.document.write( elemento.innerHTML );
    Ventana_Impresion.document.close();
    Ventana_Impresion.print( );
    Ventana_Impresion.close();
}
   
		  
		
function reload(funcionDibuja,chart,dataSource,sql,div,table,titulo){
	//alert(funcionDibuja.toString()+'('+chart+','+dataSource+','+sql+','+div+','+table+','+titulo+')');
	redibuja=true;
	switch(funcionDibuja){
		case 'getChartGdocs':
			getChartGdocs(chart,dataSource,sql,div,table,titulo,redibuja);
			break;
		case 'getChart':
			getChart(chart,dataSource,sql,div,table,titulo,redibuja);
			break;
		case 'getGroupingGrid':
			getGroupingGrid(chart,dataSource,sql,div,table,titulo,redibuja);
			break;
		case 'getIframe':
			getIframe(chart,dataSource,sql,div,table,titulo,redibuja);
			break;
		
		}
	return false;
}

function insertHeaderChart(chart,dataSource,sql,div,table,titulo,redibuja,tabDD,tooltipText){
		var padre = document.getElementById(div).parentNode;
		var abuelo = padre.parentNode;
		var vizcaabuelo = abuelo.parentNode;
		//creo un contenedor
		var divContainer=document.createElement("div");
		divContainer.setAttribute('style','float: left; width: 15%;');//divContainer.setAttribute('class','accordion-heading');
		//creo el header otro div 
		var divHeader=document.createElement("div");
		divHeader.setAttribute('class','msg_head accordion-toggle in');divHeader.setAttribute('style','float:left');
		//creo el contenedor delos iconos
		var divContent=document.createElement("div");
		divContent.setAttribute('class','portletContent accordion-toggle in');divContent.setAttribute('style','float:left;display:none;');
		
		//creo el primer icono dentro de un a 
		var header=document.createElement("div");
		header.setAttribute('style','float:left');//aHeader.setAttribute('href','#');//aHeader.setAttribute('class','reload');
		var i=document.createElement("i");
		i.setAttribute('class','icon-th icon-white');
		//inserto el i dentro del a
		header.appendChild(i);
		//inserto el a dentro del divcontenedor
		divHeader.appendChild(header);
		
		//creo el primer icono dentro de un a 
		var aContent=document.createElement("a");
		aContent.setAttribute('href','#');aContent.setAttribute('class','reload');aContent.setAttribute('style','float:left');
		var iContent=document.createElement("i");
		iContent.setAttribute('class','icon-refresh');iContent.setAttribute('name','getChartGdocs,'+chart+','+dataSource+','+sql+','+div+','+table+','+titulo+'');
		//inserto el i dentro del a
		aContent.appendChild(iContent);
		//inserto el a dentro del divcontenedor
		divContent.appendChild(aContent);
		//creo el segundo icono
		var aContent2=document.createElement("a");
		aContent2.setAttribute('href','#');aContent2.setAttribute('class','printImage');aContent2.setAttribute('style','float:left');
		var iContent2=document.createElement("i");
		iContent2.setAttribute('class','icon-print');//iContent2.setAttribute('name','getChartGdocs,'+chart+','+dataSource+','+sql+','+div+','+table+','+titulo+'');
		//inserto el i dentro del a
		aContent2.appendChild(iContent2);
		//inserto el a dentro del divcontenedor
		divContent.appendChild(aContent2);
		
		//inserto el header y el contenedor dentro del main containet
		divContainer.appendChild(divHeader);
		divContainer.appendChild(divContent);
		
		//busco el primer hijo de la clase accordion-heading para insertar antes de el, el nuevo elemento
		var donde = vizcaabuelo.getElementsByClassName('accordion-heading')[0];
		var txt = document.createTextNode(titulo);
		donde.getElementsByTagName('a')[0].appendChild(txt);//innerHTML = 
		//si es la segunda vez que le doy click, primero elimino el elemento repetido
		donde.removeChild(donde.firstChild);
		donde.insertBefore(divContainer,donde.firstChild); 	
}			
				
          

