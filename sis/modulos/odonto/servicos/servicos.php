<?
// fun�oes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});

$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});

$("#grupo_id").live("change",function(){
		var grupo_id = $(this).val();
		//alert(grupo_id);
		$("#botoes").text("");
		if(grupo_id==""){
			location.href='?tela_id=<?=$_GET['tela_id']?>';
		}else if(grupo_id!="novo"){
			
			$("#botoes").append("<input type='button' value='Editar' id='edt_grupo'><input type='button' value='filtrar' id='filtrar'>");
		}else if(grupo_id=="novo"){
			window.open('modulos/odonto/servicos/form_grupo.php','carregador');
		}
	});
	$("#edt_grupo").live("click",function(){
		var grupo_id = $("#grupo_id").val();
		//alert(grupo_id);
		window.open('modulos/odonto/servicos/form_grupo.php?grupo_id='+grupo_id,'carregador');
	});
	$("#filtrar").live("click",function(){
		var grupo_id = $("#grupo_id").val();
		location.href='?tela_id=<?=$_GET['tela_id']?>&grupo_id='+grupo_id+'&filtro=filtrar';
	});
	
	
	$("#remover_foto").live('click',function(){
		var id=$("#id").val();		
		
		$("#div_foto").hide("slow");
	
		$("#exibe_formulario > div").css("width","450px");
		
		window.open('modulos/odonto/servicos/remover_foto.php?id='+id,'carregador');
	});
	
	$("#importar_procedimentos").live('click',function(){
		location.href='?tela_id=558';
	});

</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">�</div>
<a href="" class='s1'>
  Sistema
</a>
<a href="" class='s1'>
  	Odonto
</a>
<a href="" class='s1'>
  	SERVI&Ccedil;OS
</a>
<form class='form_busca' action="" method="get">
   	 <a id="clickbusca"></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" id="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>

<div id="barra_info">
	  <select name="grupo_id" id="grupo_id" style="float:left;margin-top:3px;">
    	<option value="">Grupos</option>
        <option value="novo">Adicionar</option>
		<?php
			$grupos = mysql_query("SELECT * FROM servico_grupo WHERE vkt_id='$vkt_id'");
			while($grupo = mysql_fetch_object($grupos)){
		?>
        	<option value="<?=$grupo->id?>" <?php if($grupo->id==$_GET['grupo_id']){ echo "selected='selected'";}?>><?=$grupo->nome?></option>
        <?php
			}
		?>
    </select>
    <div id="botoes" style="float:left;">
    	<?php
			if($_GET['grupo_id']>0){
				echo "<input type='button' value='Editar' id='edt_grupo'><input type='button' value='filtrar' id='filtrar'>";
			}
		?>
    </div>
  <input type="button" value="Importar Procedimentos" id="importar_procedimentos" name="importar_procedimentos" style="float:right;margin-top:3px;margin-right:2px;"/>
  <a href="modulos/odonto/servicos/form.php" target="carregador" class="mais"></a>
   	
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		window.open('modulos/odonto/servicos/form.php?id='+id,'carregador');
	});
});
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="60">Codigo</td>
          <td width="300">Descricao</td>
          <td width="70">Unidade</td>
          <td width="80">Valor Normal</td>
          <td width="60">Execu&ccedil;&atilde;o</td>
          <?php
		  	$c=0;
		  	while($convenio = mysql_fetch_object($convenios)){
				echo "<td width='80'>".substr($convenio->razao_social,0,10)."</td>";	
				$convenio_id[$c] = $convenio->convenio_id;
				$c++;
			}			
		  ?>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso � Necess�rio para a cria�ao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    	<?php 
		$fim='';
		if(!empty($_GET['busca'])){
			$fim.=" AND nome LIKE '%".$_GET['busca']."%'";	
		}
		if(!empty($_GET['grupo_id'])){
			$fim.=" AND id='".$_GET['grupo_id']."'";	
		}
		// necessario para paginacao
   		$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM servico WHERE vkt_id='$vkt_id' $fim"),0,0);
		
		$sql = mysql_query($t="SELECT *	FROM servico_grupo WHERE vkt_id='$vkt_id' $fim ORDER BY nome  LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
					
		echo mysql_error();	
				while($r=mysql_fetch_object($sql)){
					$servicos = mysql_query($t="SELECT * FROM servico WHERE vkt_id='$vkt_id' AND grupo_id='$r->id' ORDER BY nome  LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
					
					echo mysql_error();
	?>  			
    	<thead>
        	<tr >
            	<td colspan="8"><?=$r->nome?></td>
            </tr>
        </thead> 
         <tbody>   
    <?php
			while($servico=mysql_fetch_object($servicos)){
	?>
       
        <tr <?=$sel?> id="<?=$servico->id?>" >
          <td width="60"><?=$servico->codigo_interno?></td>
          <td width="300"><?=substr($servico->nome,0,100);?></td>
          <td width="70"><?=$servico->und?></td>
          <td width="80"><?=moedaUsaToBr($servico->valor_normal)?></td>
          <td width="60"><?=$servico->tempo_execucao?></td>
          		<?php
					if(sizeof($convenio_id)>0){
						foreach($convenio_id as $id_convenio){
							$preco_convenio = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_procedimento_convenio WHERE convenio_id='$id_convenio' AND servico_id='$servico->id' AND vkt_id='$vkt_id'"));
							if($preco_convenio->valor>0){
								echo "<td width='80'>".MoedaUsaToBr($preco_convenio->valor)."</td>";
							}else{
								echo "<td width='80'>".MoedaUsaToBr($r->valor_normal)."</td>";
							}
						}
					}
				?>
          <td></td>
        </tr>
        
<?php
				}
		echo "</tbody>";
		}
?>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>