<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		
		location.href='?tela_id=319';
});
$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<a href="#" class='s1'>
  	Vektor
</a>
<a href="#" class='s2'>
  	Relat�rios
</a>
<a href="#" class='navegacao_ativo'>
<span></span>    An�lise de Mensalidades
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
  <span style="float:right">
   
  	<?php 
		if(empty($_GET["de"])&&empty($_GET["ate"])){ 
			echo "01/".date("m/Y")." a ".date("t/m/Y");
		}else{
			echo "Per�odo:".$_GET['de']." a ".$_GET['ate'];
		}?>
  </span>
  <form method="get" autocomplete="off">
	De:<input type="text" id='de' name="de" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["de"];?>" height="7"/>
    Ate:<input type="text" id='ate' name="ate" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["ate"];?>" height="7"/>
    <input type="submit" value="Filtrar" />
    <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	</form>
    
</div>

<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="30">Codigo</td>
          <td width="200">Nome</td>
          <td width="70">Qtd Vendida</td>
          
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso � Necess�rio para a cria�ao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		/*if(!empty($_GET['de'])&&!empty($_GET['ate'])){
			$filtro = " AND data_locacao BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
		}else{
			$mes_atual=date("m");
			$filtro = "AND MONTH(data_locacao) = '$mes_atual'";
		}
		if(!empty($_GET['busca'])){
			$busca = "AND id='".$_GET['busca']."' OR descricao LIKE '%".$_GET['busca']."%'";
		}
		$mes_atual=date("m");
		$registros= mysql_result(mysql_query($t="SELECT count(*) FROM 
							aluguel_locacao
							WHERE
							vkt_id='$vkt_id' AND
							status_locacao!='7'
							$filtro
							$busca"),0,0);
							//echo $t;
		$sql = mysql_query($t="SELECT * FROM 
							aluguel_locacao 
							WHERE
							vkt_id='$vkt_id' AND 
							status_locacao!=7
							$filtro 
							$busca
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
			
		//echo $t;
		$soma_valor = 0;
		$soma_lucro=0;
		$soma_custos=0;		
		while($r=mysql_fetch_object($sql)){
			$valores_aluguel=mysql_fetch_object(mysql_query($t="SELECT * FROM aluguel_locacao WHERE id=$r->id AND vkt_id='$vkt_id'"));
			$custos_locacao = mysql_query($t="SELECT * FROM aluguel_custos WHERE locacao_id=$r->id AND vkt_id='$vkt_id'");
			$custo_total = 0;
			while($custo=mysql_fetch_object($custos_locacao)){
				$custo_total+= $custo->valor * $custo->qtd;
			}
			//echo $t."<br>";
			//$despesas = $qtd->produto+$qtd->funcionario;
			$soma_valor+=$valores_aluguel->valor_total;
			$soma_lucro+=$valores_aluguel->valor_total-$custo_total;	
			$soma_custos+=$custo_total;*/
?>      
    	<!--<tr <?=$sel?> id="<?=$r->id?>">
          <td width="60"><?=$r->id?></td>
          <td width="200"><?=$r->descricao?></td>
          <td width="70"><?=moedaUsaToBr($valores_aluguel->valor_total)?></td>
          <td width="70"><?=moedaUsaToBr($custo_total)?></td>
          <td width="70"><?=moedaUsaToBr($valores_aluguel->valor_total-$custo_total)?></td>
          <td></td>
        </tr>-->
        <tr>
         <td width="30">1</td>
          <td width="200">Revendedor 1</td>
          <td width="100">15</td>
          <td width="95">R$ 10.000,00</td>
          <td width="95">20</td>
           <td></td>
        </tr>
        <tr>
         <td width="30">2</td>           
          <td width="200">Revendedor 2</td>
          <td width="100">10</td>
          <td width="95">R$ 8.0000</td>
          <td width="95">10</td>
           <td></td>
        </tr>
<?php
		//}
?>
    	
    </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr <?=$sel?>>
          <td width="30"></td>           
          <td width="200"></td>
          <td width="100">25</td>
          <td width="95">R$ 18.0000</td>
          <td width="95">30</td>
           <td></td>
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
