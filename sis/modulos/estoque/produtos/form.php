<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div style="width:600px">
<div id='aSerCarregado'>
<div>
<div >

	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Produto</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data" id="form_cadastro_produtos">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informa��es</strong></a>
            <a onclick="aba_form(this,1)">Fornecedores</a>
            <?php
            	if($obj->id>0){
					echo "<a onclick='aba_form(this,2)'>Fotos</a>";
				}
			?>
		</legend>
		<!--<label width style=" width:90px;">Codigo
        <input type="text" /></label>-->
        <label style="width:300px;">
			Codigo
			<input type="text" id='codigo' name="codigo" value="<?=$obj->codigo?>" autocomplete='off' maxlength="44"/>
		</label>
        <div style="clear:both"></div>
        <label style="width:260px;">
			Nome
			<input type="text" id='nome' name="nome" value="<?=$obj->nome?>" autocomplete='off' maxlength="44" busca="modulos/cozinha/ficha_tecnica/busca_materia_prima.php,@r0,@r0-value>nome,0"/>
		</label>
        <label width style=" width:100px;">Grupo
        
        <select name="produto_grupo_id">
		<?
			$grupo_q = mysql_query("SELECT * FROM produto_grupo WHERE vkt_id='$vkt_id' ORDER BY nome ASC");
			while($grupo=mysql_fetch_object($grupo_q)){
			if($obj->produto_grupo_id==$grupo->id){$sel='selected="selected"';}else{$sel='';}
		?>
        	<option <?=$sel?> value="<? echo $grupo->id?>"><? echo $grupo->nome ?></option>
        <?
		}
        ?>
        </select>
        
        
        
        </label>        
        <div style="clear:both;"></div>
		<label style="width:100px">
		Unidade Compra
            <select name="unidade"  class="unidade">
				
            	<option <? if($obj->unidade=="Fardo")echo 'selected="selected"'; ?>  value="Fardo">Fardo</option>
				<option <? if($obj->unidade=="Kg")echo 'selected="selected"'; ?>  value="Kg">Kg</option>
				<option <? if($obj->unidade=="g")echo 'selected="selected"'; ?>  value="g">g</option>
				<option <? if($obj->unidade=="Litro")echo 'selected="selected"'; ?>  value="Litro">Litro</option>
				<option <? if($obj->unidade=="ml")echo 'selected="selected"'; ?>  value="ml">ml</option>
				<option <? if($obj->unidade=="Caixa")echo 'selected="selected"'; ?>  value="Caixa">Caixa</option>
				<option <? if($obj->unidade=="Unidade")echo 'selected="selected"'; ?>  value="Unidade">Unidade</option>
				<option <? if($obj->unidade=="Saco")echo 'selected="selected"'; ?>  value="Saco">Saco</option>
				<option <? if($obj->unidade=="Pacote")echo 'selected="selected"'; ?>  value="Pacote">Pacote</option>
				<option <? if($obj->unidade=="Lata")echo 'selected="selected"'; ?>  value="Lata">Lata</option>
                <option <? if($obj->unidade=="Metro")echo 'selected="selected"'; ?>  value="Metro">Metro</option>
				<option <? if($obj->unidade=="M2")echo 'selected="selected"'; ?>  value="M2">Metro Quadrado</option>				
            </select>
        </label>
        <label style="width:60px;">Convers&atilde;o
       	  <input type="text"  id="conversao1" name="conversao1" onkeyup="calculaPreco('conversao')"  value="<? echo qtdUsaToBr($obj->conversao);?>" />
        </label>
<label style="width:100px">
		Unid. Embalagem
            <select name="unidade_embalagem" class="unidade_embalagem">
				
            	<option <? if($obj->unidade_embalagem=="Fardo")echo 'selected="selected"'; ?>  value="Fardo">Fardo</option>
				<option <? if($obj->unidade_embalagem=="Kg")echo 'selected="selected"'; ?>  value="Kg">Kg</option>
				<option <? if($obj->unidade_embalagem=="g")echo 'selected="selected"'; ?>  value="g">g</option>
				<option <? if($obj->unidade_embalagem=="Litro")echo 'selected="selected"'; ?>  value="Litro">Litro</option>
				<option <? if($obj->unidade_embalagem=="ml")echo 'selected="selected"'; ?>  value="ml">ml</option>
				<option <? if($obj->unidade_embalagem=="Caixa")echo 'selected="selected"'; ?>  value="Caixa">Caixa</option>
				<option <? if($obj->unidade_embalagem=="Unidade")echo 'selected="selected"'; ?>  value="Unidade">Unidade</option>
				<option <? if($obj->unidade_embalagem=="Saco")echo 'selected="selected"'; ?>  value="Saco">Saco</option>
				<option <? if($obj->unidade_embalagem=="Pacote")echo 'selected="selected"'; ?>  value="Pacote">Pacote</option>
				<option <? if($obj->unidade_embalagem=="Lata")echo 'selected="selected"'; ?>  value="Lata">Lata</option>
				<option <? if($obj->unidade=="Metro")echo 'selected="selected"'; ?>  value="Metro">Metro</option>
				<option <? if($obj->unidade=="M2")echo 'selected="selected"'; ?>  value="M2">Metro Quadrado</option>
            </select>
        </label>
        <label style="width:60px;">Convers&atilde;o
        	<input type="text" id="conversao2" name="conv  sao2" onkeyup="calculaPreco('conversao')"   value="<? echo qtdUsaToBr($obj->conversao2);?>" />
        </label>
 	<label style="width:100px"> Unidade Uso
          <select name="unidade_uso" class="unidade_uso">
            <option <? if($obj->unidade_uso=="Fardo")echo 'selected="selected"'; ?>  value="Fardo">Fardo</option>
            <option <? if($obj->unidade_uso=="Kg")echo 'selected="selected"'; ?>  value="Kg">Kg</option>
            <option <? if($obj->unidade_uso=="g")echo 'selected="selected"'; ?>  value="g">g</option>
            <option <? if($obj->unidade_uso=="Litro")echo 'selected="selected"'; ?>  value="Litro">Litro</option>
            <option <? if($obj->unidade_uso=="ml")echo 'selected="selected"'; ?>  value="ml">ml</option>
            <option <? if($obj->unidade_uso=="Caixa")echo 'selected="selected"'; ?>  value="Caixa">Caixa</option>
            <option <? if($obj->unidade_uso=="Unidade")echo 'selected="selected"'; ?>  value="Unidade">Unidade</option>
            <option <? if($obj->unidade_uso=="Saco")echo 'selected="selected"'; ?>  value="Saco">Saco</option>
            <option <? if($obj->unidade_uso=="Pacote")echo 'selected="selected"'; ?>  value="Pacote">Pacote</option>
            <option <? if($obj->unidade_uso=="Lata")echo 'selected="selected"'; ?>  value="Lata">Lata</option>
            <option <? if($obj->unidade=="Metro")echo 'selected="selected"'; ?>  value="Metro">Metro</option>
			<option <? if($obj->unidade=="M2")echo 'selected="selected"'; ?>  value="M2">Metro Quadrado</option>
          </select>
        </label>
<div style="clear:both;"></div>
		<label style="width:110px; margin-right:23px;">
			Estoque Min.:
			<input type="text" name="estoque_min" id="estoque_min" value="<?=$obj->estoque_min?>" maxlength="23" sonumero="1" style="text-align:right;width:50px; " valida_valor='0.01,999999999999999' retorno='focus|O campo Estoque Min. n�o pode ser menor do que 1,00.' /><span class="unidade_info"><?=$obj->unidade_embalagem?></span>
		</label>
		<label style="width:110px; margin-right:23px;">
			Estoque Max.:
			<input name="estoque_max" id='estoque_max' type="text" value="<?=$obj->estoque_max?>" maxlength="23" sonumero="1" style="text-align:right;width:50px; " valida_valor='0.01,999999999999999' retorno='focus|O campo Estoque Max. n�o pode ser menor do que 1,00.' /> <span class="unidade_info"><?=$obj->unidade_embalagem?></span>
		</label>
       <label style="width:150px; margin-right:23px;">
			Tempo de Entrega.:
			  <input name="tempo_reposicao" id='tempo_reposicao' type="text" value="<?=$obj->tempo_reposicao?>" maxlength="23" style="text-align:right;width:50px; " valida_valor='0.01,999999999999999' retorno='focus|Preencha o tempo de entrega' /> dias
		</label>
        <div style="clear:both;"></div>
        <label style="width:130px;">Custo / <span class="unidade_info_compra"><?=$obj->unidade?></span>
        	<br />
        	<input type="text" name="custo" id="custo" value="<?=moedaUsaToBr($obj->custo)?>" sonumero="1" decimal="2" style="width:60px;" onkeyup="calculaPreco('compra')"/>
        </label>
        <label style="width:130px;">Custo / <span class="unidade_info"><?=$obj->unidade_embalagem?></span>
        	<br />
        	<input type="text" name="custo_embalagem" id="custo_embalagem" decimal="2" value="<?php if($obj->custo!=''){echo number_format($obj->custo/$obj->conversao,2,',','.');};?>" style="width:60px;" onkeyup="calculaPreco('embalagem')" >
        </label>
        <label style="width:130px;">Custo / <span class="unidade_info_uso"><?=$obj->unidade_uso?></span>
        	<br />
        	<input type="text" name="custo_uso" id="custo_uso" sonumero="1" decimal="5" value="<?php if($obj->custo!=''){echo number_format(@($obj->custo/$obj->conversao/$obj->conversao2),5,',','.');};?>"style="width:60px;" onkeyup="calculaPreco('uso')" />
        </label>
        <br />
        <label style="width:100px;">Gramatura Per Capita
        	
        	<input type="text" name="gramatura" id="gramatura" value="<?php if($obj->gramatura!=''){echo number_format($obj->gramatura,2,',','.');};?>" style="width:60px;" onkeyup="calculaPreco('uso')" />
        </label>
        <div style="clear:both;"></div>
        <label style="width:130px;">Pre�o de Venda
        	<input type="text" name="preco_venda" sonumero="1" decimal="2" value="<?=number_format($obj->preco_venda,2,',','.')?>"/>
        </label>
            
        <label style="width:200px">Foto<input type="file" name="foto" id="foto" value="<?=$obj->foto?>" /></label>
        <div style="clear:both;"></div>
        Descri��o<br>
		<label style="width:300px;">
			<textarea name="descricao" style="height:80px;"><?=$obj->descricao?></textarea>
		</label>
        <? if($id>0){ ?>
        <img id="foto_produto" src="<?="modulos/estoque/produtos/fotos_produtos/".$obj->id.".jpg"?>" height="90"/>
        <a style="display:block;" href="#" onclick="document.getElementById('foto_produto').setAttribute('src',''); window.open('modulos/estoque/produtos/deletar_foto.php?id=<?=$obj->id?>','carregador')">Remover Foto</a>
        <? } ?>
	</fieldset>
    
    <fieldset  id='campos_2' style="display:none">
		<legend>
			<a onclick="aba_form(this,0)">Informa��es</a>
            <a onclick="aba_form(this,1)"><strong>Fornecedores</strong></a>
           <?php
		   	if($obj->id>0){
		   ?>
            <a onclick="aba_form(this,2)">Fotos</a>
           <?php
			}
		   ?>
		</legend>
          <label style="width:260px;">
			Fornecedor
			<input type="text" id='busca_fornecedor' name="busca_fornecedor" value="" autocomplete='off' maxlength="44" busca="modulos/financeiro/busca_clientes.php?tipo=Fornecedor,@r0,@r0-value>busca_fornecedor|@r1-value>fornecedor_id|@r2-value>cnpj_cpf,0" title="Digite para pesquisar um fornecedor" data-placement='right' rel="tip"/>
			<input type="hidden" id="fornecedor_id" name="fornecedor_id"/>
            
        </label>
          <label style="margin-left:30px;margin-top:20px;">                
                <a href="#" title="Selecione um fornecedor e clique aqui para associ�-lo ao produto"  id="add_fornecedor"><img src="../fontes/img/mais.png"/></a>
         </label>
		<!--<label width style=" width:90px;">Codigo
        <input type="text" /></label>-->
        <table cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:500px;">Nome</td>
                        
                        <td style="width:50;">Excluir</td>                        
                    </tr>
                 </thead>
          </table>
          <table id="dados_fornecedores" cellpadding="0" cellspacing="0" width="100%"  style="max-height:400px;overflow:auto;">
                  <tbody>
		<?
			
			$produto_has_fornecedores = mysql_query($t="SELECT * FROM produto_has_fornecedor WHERE produto_id='$obj->id' AND produto_id>0 AND vkt_id='$vkt_id'");
			
			
			while($produto_has_fornecedor = @mysql_fetch_object($produto_has_fornecedores)){
				$fornecedor = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id' AND id='$produto_has_fornecedor->fornecedor_id'"));	
				//echo $t;
			?>
				<tr>
                	<td style="width:500px;" <?=$fornecedor->id?>><?=$fornecedor->razao_social?><input type='hidden' name='produto_has_fornecedor[]' class='produto_has_fornecedor' value="<?=$fornecedor->id?>"></td>
                    
                    <td style="width:50px;" align="center"><img src="../fontes/img/menos.png" class="remove_fornecedor"/></td>
				</tr>
		<?
		
        	}
		?>
        
           </tbody>
                </table>
	</fieldset>
<?php
	if($obj->id>0){
?>
	 <fieldset  id='campos_3' style="display:none">
		<legend>
			<a onclick="aba_form(this,0)">Informa��es</a>
            <a onclick="aba_form(this,1)">Fornecedores</a>
           <a onclick="aba_form(this,2)">Fotos</a>
		</legend>
		<!--<label width style=" width:90px;">Codigo
        <input type="text" /></label>-->
        <label style="width:200">
     	Nome: <input type="text" name="foto_nome" id="foto_nome" /> 
     	</label>
        <label style="width:200">
     	Foto: <input type="file" name="foto_produto_arquivo" id="foto_produto_arquivo" /> 
     	</label>
         <label style="width:200;margin-top:18px;">
     	<img src="../fontes/img/mais.png" id="add_foto"/> 
     	</label>
		<table cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:500px;">Nome</td>
                        
                        <td style="width:70px;">Download</td>                        
                    </tr>
                 </thead>
          </table>
          <table id="dados_fotos" cellpadding="0" cellspacing="0" width="100%"  style="max-height:400px;overflow:auto;">
                  <tbody>
		<?
			
			$fotos_produtos = mysql_query($t="SELECT * FROM produto_fotos WHERE produto_id='$obj->id' AND vkt_id='$vkt_id'");
			//echo $t;
			
			while($foto_produto = mysql_fetch_object($fotos_produtos)){
				
				//echo $t;
			?>
				<tr id="<?=$foto_produto->id?>">
                	<td style="width:500px;"><img src="../fontes/img/menos.png" class="remove_foto"/><?=$foto_produto->nome?></td>
                    
                    <td style="width:70px;" align="center"><a class="download_foto"><img src='modulos/odonto/consulta/baixar.png'></a></td>
				</tr>
		<?
		     
        	}
		?>
        
           </tbody>
                </table>
                <input type="hidden" name="id_foto_exclusao" id="id_foto_exclusao"  />
    </fieldset>
<?php
	}
?>	
	<input name="id" id ="id" type="hidden" value="<?=$obj->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($obj->id>0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<input name="action2" type="hidden"  id='action2' style="float:right"  />
<div style="clear:both"></div>
</div>
</form>

</div>
</div>
</div>

<script>top.openForm()</script>