<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 

include("_functions.php");
include("_ctrl.php");

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>
<script>

$(document).ready(function(){
	$("#dados tr.aplicavel:nth-child(2n+1)").addClass('al');
})

var tabAtual = 1
 
mudarTab = function(numeroTab) {
	$("#tab_"+tabAtual).toggle()
	$("#tab_"+numeroTab).toggle()
	tabAtual = numeroTab
}
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <!--<input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>-->
    <input type="text" id='busca' name="busca" maxlength="44" value="<?=$_GET[busca]?>" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/eleitoral/politicos/busca_politico.php,@r0,0'/>
</form>
<a href="./" class='s1'>
  	Sistema NV
</a>
<a href="./" class='s2'>
    Eleitoral 
</a>
<a href="./" class='s2'>
    Cadastros 
</a>
<a href="" class="navegacao_ativo">
<span></span>  Politicos</a></div>
<div id="barra_info">
    <a href="<?=$caminho?>/form_vereador.php" target="carregador" class="mais"></a>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="120"><?=linkOrdem("Nome","nome",0)?></td>
             <td width="100"><?=linkOrdem("Cargo Pretendido","Cargo Pretendido",0)?></td>
            <td width="50"><?=linkOrdem("Partido","partido",0)?></td>
          	<td width="100"><?=linkOrdem("Coligacao","Coligacao",0)?></td>
            <td width="80">Votos</td>
            <td width="40">%</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso � Necess�rio para a cria��o o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="dados">
    <?
	if(empty($_GET['busca'])){
		$vereadores_q=mysql_query("SELECT * FROM eleitoral_politicos"); 
	}else{
		$vereadores_q=mysql_query("SELECT * FROM eleitoral_politicos WHERE nome LIKE '%".$_GET['busca']."%'");
	}
	$total_eleitores=mysql_fetch_object(mysql_query("SELECT COUNT(*) as qtd FROM eleitoral_intencoes_voto WHERE politico_id!='0' AND status='1' AND eleitor_id!='0' "));
	$total_colaboradores=mysql_fetch_object(mysql_query("SELECT COUNT(*) as qtd FROM eleitoral_intencoes_voto WHERE politico_id!='0' AND status='1' AND colaborador_id!='0' "));
	$total_votos=$total_colaboradores->qtd+$total_eleitores->qtd;
	while($vereador=mysql_fetch_object($vereadores_q)){
		
		$votos=mysql_fetch_object(mysql_query("SELECT COUNT(*) as qtd FROM eleitoral_intencoes_voto WHERE politico_id='{$vereador->id}' AND status='1' "));
	?>
     <tr class="aplicavel" onclick="window.open('<?=$caminho?>/form_vereador.php?idvereador=<?=$vereador->id?>','carregador')">
            <td width="120"><?=$vereador->nome?></td>
             <td width="100"><?=$vereador->cargo?></td>
            <?
            	$nomepartido = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_partidos WHERE id='".$vereador->partido_id."'"));
			?>
            <td width="50"><?=$nomepartido->sigla?></td>
            <?
            	$nomecoligacao = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_coligacoes WHERE id='".$vereador->coligacao_id."'"));
			?>
          	<td width="100"><?=$nomecoligacao->nome?></td>
            <td width="80"><?=$votos->qtd?></td>
            <td width="40"><?=number_format((100*$votos->qtd)/$total_votos,2,',','.')?></td>
            <td></td>
        </tr>
     <? 
	 } 
	 ?>
    </tbody>
</table>
</div>
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