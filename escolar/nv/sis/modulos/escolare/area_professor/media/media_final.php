<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
$sql_escola = mysql_fetch_object(mysql_query($t=" SELECT * FROM escolar_escolas WHERE vkt_id = '$vkt_id'"));

 $media_instituicao = $sql_escola->media;
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
table#bimestre tr td{
		background:#F8F8F8;
		padding:5px;
		padding-left:5px;
}

</style>
<script>
	$('#curso_id').live('change',function(){
		var curso=$("select#curso_id").val();
			//alert(curso);
		$('#result_curso').load('modulos/escolar/exemplo_matricula/curso_turma.php?curso='+curso);
	})
	$(document).ready(function(){
		$("#dados tr:nth-child(2n+1)").addClass('al');
		//$("tr:odd").css("background-color", "#F5F5F5");
	})
	
</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<a href="?tela_id=233" class='s1'>
  	Sistema NV
</a>
<a href="?tela_id=233" class='s2'>
    Escolar 
</a>
<a href="?tela_id=233" class="navegacao_ativo">
<span></span>Modulos
</a>
</div>
<div id="barra_info">
    <button type="button" onclick="location.href='?tela_id=256&materia=<?=$_SESSION['materia_id']?>&periodo_id=<?=$_SESSION['periodo_id']?>&sala=<?=$sala?>'">&laquo;</button> <!-- ?tela_id=256&materia=16&periodo_id=1&sala=3&sala_materia=220 -->
  	<button type="button" onclick="location.href='?tela_id=270&materia=<?=$_SESSION['materia_id']?>&periodo_id=<?=$_SESSION['periodo_id']?>&sala=<?=$sala?>&sala_materia=<?=$smp->id?>'">Recupera�&atilde;o</button> <!-- ?tela_id=270&materia=16&periodo_id=1&sala=3&sala_materia=220 -->
   <?
   		$sql_materia=mysql_fetch_object(mysql_query(" SELECT * FROM escolar_materias WHERE id = '{$_GET[materia]}' AND vkt_id = '$vkt_id'"));
		
		echo '<strong> Mat&eacute;ria: </strong>'.$sql_materia->nome.' | <strong> Media da Institui&ccedil;&atilde;o: </strong>'.number_format($media_instituicao, 1, '.', ' ');
   ?> 
</div>

<table cellpadding="0" cellspacing="0" width="100%" id="bimestre">
    <thead>
     <tr>
           <td width="40">Codigo</td>
           <td width="200">Nome</td>
           <?
		   
           		$sala_materia = mysql_fetch_object(mysql_query($sm="SELECT * 
																	FROM 
																		escolar_sala_materia_professor 
																	WHERE 
																		sala_id = '$sala' 
																	AND 
																		materia_id = '$materia' 
																	AND 
																		vkt_id = '$vkt_id'"));
																		
				$qtd_avaliacao = mysql_fetch_array(mysql_query($an=" SELECT COUNT(id) as qtd 
																		FROM 
																			escolar_avaliacao 
																		WHERE 
																			sala_materia_professor_id = '$sala_materia->id' 
																		AND 
																			vkt_id = '$vkt_id'
																		ORDER BY 
																			periodicidade_id	
																"));
				$n_avaliacao=mysql_query("SELECT * 
														FROM 
															escolar_avaliacao a
														WHERE 
															sala_materia_professor_id = '$sala_materia->id'
														AND
															vkt_id = '$vkt_id'
														ORDER BY 
															periodicidade_id
														 
														
								");		
				
				$j=0;
				$avaliacao_qtd = 0;
				while($r=mysql_fetch_object($n_avaliacao)){
								$j++;						
						$periodo=mysql_fetch_object(mysql_query(" SELECT * FROM escolar_periodicidade_avaliacao WHERE id = '$r->periodicidade_id' AND vkt_id = '$vkt_id'"));	
						
						$qtd_aval = mysql_fetch_object(mysql_query($an=" SELECT COUNT(id) as avaliacao_qtd 
																		FROM 
																			escolar_avaliacao 
																		WHERE 
																			sala_materia_professor_id = '$sala_materia->id' 
																		AND 
																			vkt_id = '$vkt_id'
																		AND
																			periodicidade_id = '$periodo->id'
																			
																"));
												
		   ?>
           <td width="90"><div style="padding-left:8px;"><!--Nota--><?=$periodo->nome?></div><div style="font-weight:normal; padding-left:3px;"><?=substr($r->descricao,0,16)?></div></td>
           <?
		   				$avaliacao_qtd = 0;
					}
		   ?>
           <td width="70">M�dia Final</td>
           <td width="80">% Faltas</td>
           <td width="80">Situa�&atilde;o</td>
           <td></td>
           
     </tr>
     
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso � Necess�rio para a cria��o o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	
	<tr>
   		<td width="40"> <?=$aluno->id?></td>
   		<td width="200">Marcos da Silva Concei��o</td>
        
        	
		<td width="60">78</td>
           
        <td width="70">45</td>
        <td width="80"><?=moedaUsatoBr($media_faltas)?></td>
        <td width="80">
		<? 
			if($media_final >= $media_instituicao and $cont != 0 and $media_faltas<=$curso->perc_faltas){
				echo '<strong style="color:#32870E">Aprovado</strong>';} 
			else if($media_final<$media_instituicao){
				echo '<strong style="color:#A42B2B">Reprovado</strong>';}
			else{
			echo '<strong style="color:#A42B2B">Reprovado Por Falta</strong>';}
		?>
        </td>
            
            
        <td ></td>
        
	</tr>
       
	<?
	
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query($t="SELECT count(*) FROM escolar_alunos a, escolar_alunos_bolsistas ab WHERE ab.vkt_id=$vkt_id $busca_add ORDER BY a.id DESC"),0,0);
   //echo $t;
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="codigo_totvs";
	}
	
	// colocar a funcao da pagina��o no limite
	$q= mysql_query($t="SELECT a.*,ab.* FROM escolar_alunos a, escolar_alunos_bolsistas ab WHERE  a.id=ab.aluno_id AND ab.vkt_id='$vkt_id' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>

<?
	}
	?>	
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
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
