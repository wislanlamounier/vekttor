<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
.qtd{width:50px;height:12px; text-align:right}
.vlr{width:55px;height:12px; text-align:right}
.marca{height:11px; width:40px;}
.cz{ color:#999999}
.und{width:72px;}
.g{background:url(../fontes/img/bb.jpg); font-weight:bold; }
</style>
<script>
//moedaBrToUsa
//moedaUsaToBR
$(document).ready(function(){
	$("#dados tr.registro:nth-child(2n+1)").addClass('al');
})

function calculo_compra(t){

// compra > embala > usa
//  1 > 30 > 1000

	qtd = qtdBrToUsa($(t.parentNode.parentNode).find(".qtd").val(),3)*1;	
	unidade = $(t.parentNode.parentNode).find(".und").val();
	valor =  moedaBrToUsa($(t.parentNode.parentNode).find(".vlr").val())*1;
	unidade2 = $(t.parentNode.parentNode).find(".conversao").val()*1;
	unidade3 = $(t.parentNode.parentNode).find(".conversao2").val()*1;
	unidade_tipo = $(t.parentNode.parentNode).find(".und option:selected").attr("ut");
	//alert(unidade2);
	if(unidade_tipo=='compra'){
		qtd_unidade 	= (qtd);
		qtd_embalagem 	= (qtd_unidade*unidade2);
		qtd_uso			= (qtd_unidade*unidade3*unidade2);
		vlr_unidade 	= valor
		v_embalagem		= (vlr_unidade/unidade2);		
		v_uso			= v_embalagem/unidade3;
	}
	
	if(unidade_tipo=='embalagem'){
		qtd_embalagem 	= (qtd);
		qtd_unidade 	= (qtd/unidade2);
		qtd_uso			= (qtd*unidade3);
		
		v_embalagem		= valor;
		vlr_unidade 	= v_embalagem*unidade2;
		v_uso			= v_embalagem/unidade3;
	}
	if(unidade_tipo=='uso'){
		qtd_uso			= (qtd);
		qtd_embalagem 	= (qtd/unidade3);
		qtd_unidade 	= (qtd_embalagem/unidade2);
		
		v_uso			= valor;
		v_embalagem		= v_uso*unidade3;
		vlr_unidade 	= v_embalagem*unidade2;
	}
	
	
	v_total =valor*qtd;
	v_total =moedaUsaToBR(v_total.toFixed(2));
	
	if(qtd_unidade==Infinity||isNaN(qtd_unidade)){
		qtd_unidade2=0.00;
	}else{
		qtd_unidade2 	= moedaUsaToBR(qtd_unidade.toFixed(2));
	}
	
	if(qtd_embalagem==Infinity||isNaN(qtd_embalagem)){
		qtd_embalagem2=0.00;
	}else{
		qtd_embalagem2 	= moedaUsaToBR(qtd_embalagem.toFixed(2));
	}
	
	qtd_uso2 		= moedaUsaToBR(qtd_uso.toFixed(2));

	if(vlr_unidade==Infinity||isNaN(vlr_unidade)){
		vlr_unidade2	= 0.00;
	}else{
		vlr_unidade2	= moedaUsaToBR(vlr_unidade.toFixed(2));
	}
	
	if(v_embalagem==Infinity||isNaN(v_embalagem)){
		v_embalagem2 	= 0.00;
	}else{
		v_embalagem2 	= moedaUsaToBR(v_embalagem.toFixed(2));
	}
	if(v_uso==Infinity||isNaN(v_uso)){
		v_uso2 			= 0.00;
	}else{
		v_uso2 			= moedaUsaToBR(v_uso.toFixed(2));
	}

	$(t.parentNode.parentNode).find('.qtd_unidade').html(qtd_unidade2);
	$(t.parentNode.parentNode).find('.qtd_embalagem').html(qtd_embalagem2);
	$(t.parentNode.parentNode).find('.qtd_uso').html(qtd_uso2);
	
	$(t.parentNode.parentNode).find('.v_compra').html(vlr_unidade2) ;
	$(t.parentNode.parentNode).find('.v_embalagem').html(v_embalagem2) ;
	$(t.parentNode.parentNode).find('.v_uso').html(v_uso2);
	
	
	$(t.parentNode.parentNode).find('.v_total').html(v_total);
	
	valor_total =0;
	$(t.parentNode.parentNode.parentNode).find('.v_total').each(function(){
		valor_total += (moedaBrToUsa($(this).html()))*1;
	})
	valor_total=moedaUsaToBR(valor_total.toFixed(2));
	$('#valor_total').html(valor_total);
}

$(".qtd").live('keyup',function(){
	calculo_compra(this);
})

$(".vlr").live('keyup',function(){
	calculo_compra(this);
})

$(".und").live('change',function(){
	
	/*
unidade_compra
unidade_embalagem
unidade_uso
fator1
fator2
linhan
	*/
	
	
	 var linhan    		= $(this).parent().parent().attr('id');
	  produto_nome		= $(this).parent().parent().find('td:eq(0)').text();
	  unidade_compra	= $(this).parent().find('option:eq(0)').attr('value');
	  unidade_embalagem	= $(this).parent().find('option:eq(1)').attr('value');
	  unidade_uso		= $(this).parent().find('option:eq(2)').attr('value');
	  fator1			= $(this).parent().find('.conversao'  ).val();
	  fator2			= $(this).parent().find('.conversao2' ).val();
	  selecionado 		= $(this).attr('sel');
	if($(this).val()=="editar_fator"){

		window.open('modulos/estoque/consumo/form_fatores.php?linhan='+linhan+'&unidade_compra='+unidade_compra+'&unidade_embalagem='+unidade_embalagem+'&unidade_uso='+unidade_uso+'&fator1='+fator1+'&fator2='+fator2+'&produto_nome='+produto_nome+'&selecionado='+selecionado,"carregador");
		$(this).val(selecionado);
	}else{
		$(this).attr('sel',$(this).val());
		calculo_compra(this);	
	}
})


function direciona(t){
	//qtd=t.value;
	//alert($("#estoque_id").val());
	    data_chegada_prevista = $("#data_chegada_prevista").val();
		
		qtd=qtdBrToUsa($(t.parentNode.parentNode).find(".qtd").val(),3)*1;
		//unidade=$(t).parent().parent().find(".und").val();
		unidade = $(t.parentNode.parentNode).find(".und").val();
		//vlr=$(t).parent().parent().find(".vlr").val();
		vlr = moedaBrToUsa($(t.parentNode.parentNode).find(".vlr").val());
		//conversao=$(t).parent().parent().find(".conversao").val();
		conversao = $(t.parentNode.parentNode).find(".conversao").val()*1;
		conversao2 = $(t.parentNode.parentNode).find(".conversao2").val()*1;
		unidade_tipo = $(t.parentNode.parentNode).find(".und option:selected").attr("ut");
		//console.log(qtd*conversao_usada);
		produto_id=$(t).parent().parent().find(".produto_id").val();
		marca=$(t).parent().parent().find(".marca").val();
		compra_id=$("#compra_id").val();
		pedido_id=$("#pedido_id").val();
		cont = $(t.parentNode.parentNode).find('.item').attr('id');
		//pedido_item=$(t.parentNode.parentNode).find(".pedido_item").val();
		item_id=$(t.parentNode.parentNode).find(".item").text();
		estoque_id=$('#estoque_id').val();
		console.log(unidade);
		url='<?=$caminho?>atualiza_valores.php?pedido_id='+pedido_id+'&produto_id='+produto_id+'&qtd='+qtd+'&unidade='+unidade+'&unidade_tipo='+unidade_tipo+'&valor='+vlr+'&conversao='+conversao+'&conversao2='+conversao2+'&marca='+marca+'&cont='+cont+'&item_id='+item_id+'&acao=alterar&estoque_id='+estoque_id+'&data_chegada_prevista='+data_chegada_prevista;
		
		if((qtd!=0&&qtd!='')&&(vlr!=''&&vlr!=0)){
			window.open(url,'carregador');
		}
		
	
}

function atualiza_pedido(){
	var busca_produto=$('#busca_produto').attr('disabled');
	var ocorrencia=$('#ocorrencia').val();
	var estoque_id=$('#estoque_id').val();
	if(estoque_id!=''){
		$('#busca_produto').attr('disabled',false);
	}else{
		$('#busca_produto').attr('disabled',true);
	}
	url='<?=$caminho?>atualiza_pedido.php?compra_id=<?=$pedido_id?>&ocorrencia='+ocorrencia+'&estoque_id='+estoque_id;
	//alert(url);
	window.open(url,'carregador');
}

function checaUnidade(t){
}

function funcao_bsc2(resultado,acao,origem){	
	actions_W= acao.split('|');//ns1.vkt.srv.br
	//alert(actions_W);
//	document.title=resultado.innerHTML+','+resultado.getAttribute('r0')+','+resultado.getAttribute('r1')+','+resultado.getAttribute('r2')+','+acao+','+origem+','+actions_W.length;
	
	//document.getElementById(origem).value=resultado.getAttribute('r0');
	
	for(w=0;w<actions_W.length;w++){
		vlores_e_locais = actions_W[w].split("-");
		local_e_acao = vlores_e_locais[1].split('>');
		
		valor = vlores_e_locais[0].replace(/@/g,'');
		local = local_e_acao[0];
		acao_W  = local_e_acao[1];
		
		if(local=='innerHTML'){
			document.getElementById(acao_W).innerHTML=resultado.getAttribute(valor);
		}else if(local=='value'){
			document.getElementById(acao_W).setAttribute('value',resultado.getAttribute(valor));
			document.getElementById(acao_W).value=resultado.getAttribute(valor);
		}else{
			document.getElementById(acao_W).setAttribute(local,resultado.getAttribute(valor));
		}
	}
	/*--------- funcoes para pegar valor e enviar a requisicao para o servidor via ajax ----------------------*/
	var produto_id    = $("#busca_produto_id").val();
	//var fornecedor_id = $("#fornecedor_id").val();
	
	//linha = $("<tr><td>"+nome+"</td><td></td> <td></td> <td></td> <td></td> </tr>");ocorrencia	
	//linha.appendTo("#tbody");
	//alert(produto_id);
	$("#produto_id").val('');
	$("#busca_produto_id").val('');
	$("#busca_produto").val('');
	
	nlinhas=$('#tbody').find('tr').size()+1;
	document.title=nlinhas;
		var dados = 'produto_id='+produto_id+'&compra_id=<?=$pedido_id?>&unidade_id=<?=$estoque_id?>&nlinhas='+nlinhas;
						
						$.ajax({
							url: 'modulos/estoque/consumo/adiciona_produto.php', 
							dataType: 'html',
							type: 'POST',
							data: dados,
							success: function(data, textStatus) {
								$('#tbody').append(data);
								$("tr:odd").addClass('al');
							},
						}); /* Fim Ajax*/					
}
function removeItem(t){
	//alert(t);
	var pedido_id = $("#pedido_id").val();
	var produto_id = $(t.parentNode.parentNode).find(".produto_id").val();
	//alert(produto_id);
	var id=$(t.parentNode.parentNode).find('.item').text();
	
	vlr=moedaBrToUsa($(t.parentNode.parentNode).find('.v_total').text())*1;
	total=moedaBrToUsa($('#valor_total').text());
	total -=vlr;
	total=total.toFixed(2);
	//$(t.parentNode.parentNode).find('.v_total').val('');
	//$(t.parentNode.parentNode).find('.vlr').val('');
	//$(t.parentNode.parentNode).find('.qtd').val('');
	//$(t.parentNode.parentNode).find('.marca').val('');
	$(t.parentNode.parentNode).find('td').remove();
	url='modulos/estoque/consumo/atualiza_valores.php?acao=excluir&id='+id+'&pedido_id='+pedido_id+"&produto_id="+produto_id;
	window.open(url,'carregador');
	$('#valor_total').text(moedaUsaToBR(total));
	//alert(id);
}

$("#duplica_compra").live('click',function(){

	var compra_id = $("#pedido_id").val();

	var dados = 'compra_id='+compra_id+'&acao=duplica_compra';
	
	
	$.ajax({
		url: 'modulos/estoque/consumo/adiciona_produto.php', 
		dataType: 'html',
		type: 'POST',
		data: dados,
		success: function(data, textStatus) {
			//alert(data);
			var dados = data.split("|");
			
			//fornecedor_id = top.document.getElementById
			
			location.href='?tela_id=499&compra_id='+dados[0]+'&estoque_id='+dados[1];			
			
		},
	});

});

$("#fator_conversao1, #fator_conversao2").live('keyup',function(){
	
	var fator_conversao1 = $("#fator_conversao1").val();
	var fator_conversao2 = $("#fator_conversao2").val();
	var linhan = $("#linhan").val();
	
	
	$("#"+linhan).find('.conversao').val(qtdBrToUsa(fator_conversao1,3));
	$("#"+linhan).find('.conversao2').val(qtdBrToUsa(fator_conversao2,3));
	
	
	$("#"+linhan).find('option:eq(0)').text($("#"+linhan).find('option:eq(0)').val()+' - '+fator_conversao1);
	$("#"+linhan).find('option:eq(1)').text($("#"+linhan).find('option:eq(1)').val()+' - '+fator_conversao2);
	
	//
	
	
});

$("#finalizar").live('click',function(){
	var pedido_id     = $("#pedido_id").val();
	//var fornecedor_id = $("#fornecedor_id").val();
	var estoque_id=$('#estoque_id').val();
	location.href='?tela_id=499&compra_id='+pedido_id+'&estoque_id='+estoque_id+'&acao=Finalizar';
	
});
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some"><<</div>

<a href="?tela_id=498" class='s1'>
  	Sistema NV
</a>
<a href="?tela_id=498" class='s1'>
  	Estoque
</a>
<a href="?tela_id=498" class='s2'>
    Consumo 
</a>

<a href="?tela_id=499" class="navegacao_ativo">
<span></span>Novo Consumo 
</a>
</div>
<div id="barra_info">

<form method="post" action="">
<input type="button" value="<<" onclick="location.href='?tela_id=498&pagina=<?=$_GET['pagina']?>&limitador=<?=$_GET['limitador']?>'">

<input type="hidden" name="busca_produto_id[]" id="busca_produto_id" value="">
  Adicione um produto <input type="text" id='busca_produto' onkeyup="return vkt_ac(this,event,'0','modulos/estoque/consumo/busca_produto.php','@r0','funcao_bsc2(this,\'@r1-value>busca_produto_id\',\'produto\')')"
   autocomplete='off' name="produto" value=""  valida_minlength="3"  style='width:170px;height:10px;font-size:11px;' retorno='focus|Coloque no minimo 3 caracter'  <? if(($pedido->status=='Finalizado')||($pedido->status=='cancelado')){echo "disabled='disabled'";}?> />
                 
<?=
"<strong>Pedido:</strong> ".$pedido_id." || <strong>Unidade:</strong> ".$estoque->nome;
?>
<input type="hidden" name="estoque_id"  id="estoque_id" value="<?=$pedido->unidade_id?>" />

<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>"/>
<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>"/>
<?
	if($pedido->status!='Finalizado'){
		if($pedido->status=='cancelado'){
?>
<input type="button" style="float:right; margin:3px 5px 0 10px;" name="acao" value="Reabrir Consumo" onclick="location.href='?tela_id=499&pagina=<?=$_GET['pagina']?>&limitador=<?=$_GET['limitador']?>&compra_id=<?=$pedido_id?>&status=Em aberto'"/>
<?
		}else{
?>
<input type="button" style="float:right; margin:3px 5px 0 10px;" name="acao" value="Cancelar Consumo" onclick="location.href='?tela_id=499&pagina=<?=$_GET['pagina']?>&limitador=<?=$_GET['limitador']?>&compra_id=<?=$pedido_id?>&status=cancelado'"/>
<?
		}
	echo "<input type='button' style='float:right; margin:3px 5px 0 10px;' value='Finalizar' id='finalizar'>";
	}
?>
<input type="button" style="float:right; margin:3px 5px 0 10px;" name="acao" value="Imprimir" onclick="window.open('modulos/estoque/consumo/imprimir_compra.php?compra_id=<?=$pedido_id?>',carregador)" />

</form>
</div>
<div id="barra_info">

<form method="post" action="">
<label>

	Data de Chegada Prevista: <input type="text" <?=$disabled?> name="data_chegada_prevista" id="data_chegada_prevista" value="<?php echo DataUsaToBr($pedido->data_chegada_prevista);?>" calendario="1" style="width:70px;height:10px;" onblur="direciona(this)" mascara="__/__/____"/>

</label>

<!--<input type="button" name="duplica_compra" id="duplica_compra" value="Duplicar Compra" />-->

</form>
</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>	
            <td width="80">Produto</td>
            <td width="50">Marca</td>
            <td width="70">Qtd estoque</td>
            <td width="60">Qtd</td>
            <td width="80">Unidade</td>
            <td width="70">R$ Valor</td>
            <td width="60">Ult. R$</td>
            <td width="60">Un Com.</td>
            <td width="60">R$ Com.</td>
            <td width="70">Un Emb.</td>
            <td width="60">R$ Emb.</td>
            <td width="57">Un Uso.</td>
            <td width="50">R$ Uso</td>
            <td width="60">Total</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso � Necess�rio para a cria��o o resize -->
<!--<form id="produtos">-->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados" id="tbody">
	
	
		<?
		$infoquantidade=mysql_fetch_object(mysql_query("SELECT count(*) as c FROM estoque_consumos_item as pf WHERE pf.pedido_id ='$pedido_id' "));
		if($infoquantidade->c<1){			
			//$produtos_fornecedor_q=mysql_query($t="SELECT p.* FROM produto as p, produto_has_fornecedor as pf WHERE p.vkt_id='$vkt_id' AND pf.produto_id = p.id AND pf.fornecedor_id = '{$_GET['fornecedor_id']}' ");
			$produtos_fornecedor_q=mysql_query($t="SELECT p.*, p.conversao as fatorconversao, p.conversao2 as fatorconversao2, pg.nome as grupo FROM produto as p,produto_grupo as pg WHERE p.vkt_id='$vkt_id' AND p.produto_grupo_id = pg.id ORDER BY pg.nome, p.nome ASC");
		}else{
			$produtos_fornecedor_q=mysql_query($t="SELECT pf.*, p.*, pg.nome as grupo FROM estoque_consumos_item as pf, produto as p, produto_grupo as pg WHERE pf.vkt_id='$vkt_id' AND pf.pedido_id ='$_GET[compra_id]' AND  pf.produto_id = p.id AND p.produto_grupo_id = pg.id ORDER BY pg.nome , p.nome ASC");
		}
		//$produtos_pedido
		$total = 0;
		//if(mysql_num_rows($produtos_fornecedor_q)>0){
			$grupo='';
		   while($produto = @mysql_fetch_object($produtos_fornecedor_q)){
			   
				$item_compra = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_consumos_item WHERE pedido_id='".$_GET['compra_id']."' AND produto_id='$produto->id'"));
				$total = $item_compra->qtd_pedida * $item_compra->valor_ini;
				if($item_compra->unidade_tipo=='compra'){$ut="compra";}
				if($item_compra->unidade_tipo=='embalagem'){$ut="embalagem";}
				if($item_compra->unidade_tipo=='uso'){$ut="uso";}
				$qtd_unidade='';$qtd_embalagem='';$qtd_uso='';$vlr_unidade='';$v_embalagem='';$v_uso='';
				if($item_compra->qtd_pedida>0){
					$unidade			= $item_compra->unidade;
					$conversao 			= $item_compra->fatorconversao;
					$conversao2 		= $item_compra->fatorconversao2;
					if($ut=='compra'){
						//echo $ut;
						$qtd_unidade   = $item_compra->qtd_pedida;
						$qtd_embalagem = $qtd_unidade*$item_compra->fatorconversao;
						$qtd_uso	   = $qtd_unidade*$item_compra->fatorconversao2*$item_compra->fatorconversao;
			
						$vlr_unidade   = $item_compra->valor_ini;					
						$v_embalagem   = ($vlr_unidade/$item_compra->fatorconversao)/$qtd_unidade;
						$v_uso		   = $v_embalagem/$item_compra->fatorconversao2;
					}
					if($ut=='embalagem'){
					//	echo $ut;
						$qtd_embalagem 	= $item_compra->qtd_pedida;
						$qtd_unidade 	= $item_compra->qtd_pedida/$item_compra->fatorconversao;
						$qtd_uso		= $item_compra->qtd_pedida*$item_compra->fatorconversao2;
			
						$v_embalagem	= $item_compra->valor_ini;
						$vlr_unidade 	= $v_embalagem*$item_compra->fatorconversao;
						$v_uso			= $v_embalagem/$item_compra->fatorconversao2;
						//echo $vlr_unidade."<br>";
					}
					if($ut=='uso'){
						$qtd_uso		= $item_compra->qtd_pedida;
						$qtd_embalagem 	= $qtd_uso*$item_compra->conversao2;
						$qtd_unidade 	= $item_compra->qtd_pedidfatora/$item_compra->fatorconversao;
			
						$v_uso			= $item_compra->valor_ini;
						$v_embalagem	= $v_uso*$item_compra->fatorconversao2;
						$vlr_unidade 	= $v_embalagem*$item_compra->fatorconversao;
						//echo $vlr_unidade."<br>";
					}
				}else{
						$unidade 		= $produto->unidade;
						$conversao 		= $produto->fatorconversao;
						$conversao2 	= $produto->fatorconversao2;
						$ut			   	= "compra";
						$qtd_unidade   	= 1;
						$qtd_embalagem 	= $qtd_unidade*$produto->fatorconversao;
						$qtd_uso	   	= $qtd_unidade*$produto->fatorconversao2*$produto->fatorconversao;
			
						$vlr_unidade   	= $produto->valor_ini;					
						$v_embalagem   	= ($vlr_unidade/$produto->fatorconversao)/$qtd_unidade;
						$v_uso		   	= $v_embalagem/$produto->fatorconversao2;
				}
			
				$soma += $total;
				//echo $soma." ";
				$linha++;
				if($produto->grupo!=$grupo){
			$grupo=$produto->grupo;
	?>
	<tr>
    	<td colspan="15" class="g"><?=$grupo?></td>
    </tr>
    <?
		}
			?>
			
			
			<tr id='l<?=$linha?>' class="registro">
           <td width="80" ><?=$produto->nome;?></td>
           <td width="50"><input type="hidden" name="produto_id[]" class="produto_id" value="<?=$produto->id?>" /><input type="text" name="marca[]" class="marca funcao valida_almoxarifado" onblur="direciona(this)" value="<?=$item_compra->marca?>" <?=$disabled?> /></td>
            <td width="70">
            <?php
				$qtd_estoque = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_mov WHERE almoxarifado_id = '".$_GET['estoque_id']."' AND produto_id='$produto->id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
				//echo $t."<br>";
				if($qtd_estoque->saldo > 0){
					$qtd_estoque_embalagem = $qtd_estoque->saldo/$produto->conversao2;
					echo MoedaUsaToBr($qtd_estoque_embalagem)." ".substr($produto->unidade_embalagem,0,2);
				}else{
					echo "0,00";
				}
			?>
            </td>
            <td width="60">
            	
           	  <input type="text"  name="qtd[]" class="qtd valida_almoxarifado"  onblur="direciona(this)" value="<?=qtdUsaToBr($item_compra->qtd_pedida)?>" <?=$disabled?>/>
           	</td>
            <td width="80">
            <select name="unidade[]" class='und valida_almoxarifado' sel='<?=$item_compra->unidade?>'  onchange="direciona(this)" <?=$disabled?>>
                <option  ut = 'compra' value="<?=$produto->unidade?>" <? if($ut=='compra'){echo "selected=selected";}?>>
					<?=$produto->unidade." - ".$conversao?>
                </option>
                
                <option ut = 'embalagem' value="<?=$produto->unidade_embalagem ?>" <? if($ut=='embalagem'){echo "selected=selected";}?>>
					<?=$produto->unidade_embalagem." - ".$conversao2?> 
                </option>
                
                <option ut = 'uso' value="<?=$produto->unidade_uso?>" <? if($ut=='uso'){echo "selected=selected";}?>>
					<?=$produto->unidade_uso  ?>
                </option>
                
                <option value="editar_fator">Editar Fatores</option>
            </select>
            
            <input type="hidden" name="conversao" class="conversao" value="<?=$conversao?>"/>
            <input type="hidden" name="conversao1" class="conversao2" value="<?=$conversao2?>"/>
            </td>
            <td width="70"><input type="text" name="vlr[]" class="vlr valida_almoxarifado"  onblur="direciona(this)" 
             sonumero="1" value="<?=moedaUsaToBr($item_compra->valor_ini)?>" <?=$disabled?>/></td>
            <td width="60" align="right" class="cz" ><?=moedaUsaToBr($produto->custo)?></td>
            <td width="60" align="right" class="cz"><span class="qtd_unidade">
			<? if($qtd_unidade>0){echo MoedaUsaToBr($qtd_unidade);}else{echo "0,00";}?></span> <?=substr($produto->unidade,0,2)?>
            </td>
            <td width="60" align="right" class="v_compra cz"><? if($vlr_unidade>0){echo moedaUsaToBr($vlr_unidade);}else{echo "0,00";}?></td>
            <td width="70" align="right" class="cz"><span class="qtd_embalagem"><?php if($qtd_embalagem>0){echo MoedaUsaToBr($qtd_embalagem);}else{echo 0;}?></span> <?=substr($produto->unidade_embalagem,0,2)?></td>
            <td width="60" align="right" class="v_embalagem cz"><?php if($v_embalagem>0){echo MoedaUsaToBr($v_embalagem);}else{echo "0,00";}?></td>
            <td width="57" align="right" class="cz"><span class="qtd_uso"><?php if($qtd_uso>0){echo MoedaUsaToBr($qtd_uso);}else{echo 0;}?></span><?=substr($produto->unidade_uso,0,2)?></td>
            <td width="50" align="right" class="v_uso cz"><?php if($v_uso>0){echo MoedaUsaToBr($v_uso);}else{echo "0,00";}?></td>
            <td width="60"align="right" class="v_total"><?=number_format($total,2,",",".")?></td>
            <td ><?
				//$soma+=$total;
            	if(empty($disabled)){
					echo "<img src='../fontes/img/menos.png' width='18' height='18' onclick='removeItem(this)' class='remove'/>";
				}
				?>
			<span style="display:none;" id="item<?=$cont?>" class="item"><?=$pedido_item->id?></span>
            </td>
            
      </tr>
			
			
			
			
			
			
			
		<?	
		//$total = 0;
		//}
	   }
	//}
	?>
    </tbody>
</table>
<label style="margin-left:40px;">
Observa�ao<br>
<textarea cols="50" rows="10" style="margin-left:40px;" name="ocorrencia" id="ocorrencia" onblur="atualiza_pedido()" <?=$disabled?>>
<?=$pedido->obs_pedido?>
</textarea>
</label>
<input type="hidden" id="pedido_id" value=<?=$pedido_id?> /> 

</form>
<br>
<p style="margin-left:40px;">
Obs. Chegada<br>
<?=$pedido->obs_chegada?>
</p>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
                        <td width="80">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="70">&nbsp;</td>
            <td width="40">&nbsp;</td>
            <td width="80">&nbsp;</td>
            <td width="70">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="70">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="57">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="60" id='valor_total' ><?=moedaUsaToBr($soma);?></td>
 <td></td>
      </tr>
    </thead>
</table>
</div>
<div id='rodape'>
As altera�oes serao salvas automaticamente ao digitar no  campo
</div>
<script>
// Fecha aba de menu

		$("#menu").animate({
			'marginLeft': -210,
			
		  }, 0);
		$("#conteudo").animate({
			'marginLeft': 10
		  }, 0);
		$("#rodape").animate({
			'marginLeft': 10
		  }, 0);
				   $("#some").html("&raquo;")

////

</script>
