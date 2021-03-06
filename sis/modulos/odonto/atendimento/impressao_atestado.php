<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	$atestado_id = $_GET['id'];
	global $usuario_id;
	global $vkt_id;
	
	$cliente_vekttor = mysql_fetch_object(mysql_query($t="SELECT * FROM clientes_vekttor WHERE id='$vkt_id'"));
	$atestado = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_atestados WHERE id='$atestado_id'"));
	$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$atestado->cliente_fornecedor_id'"));
	$odontologo = mysql_fetch_object(mysql_query($t="SELECT 
													* 
												FROM 
													usuario u,
													odontologo_odontologo oo,
													cliente_fornecedor cf													
												WHERE
													u.id=oo.usuario_id AND
													oo.cliente_fornecedor_id  = cf.id AND
													u.id = '$usuario_id'
													")); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Atestado - Odont�logo</title>
<style>

	#atestado{
		border:#000 solid 1px;
		width:500px;
		height:620px;
		font-family:Arial, Helvetica, sans-serif;
		
	}	
	#header{
		
	}
	#info_dentista{
		float:left;
		width:65%;
	}
	#logo_clinica{
		float:right;
		width:35%;
	}
	
		
	#titulo_atestado{
		font-family:Arial, Helvetica, sans-serif;
		font-size:15px;
		font-weight:bold;
		margin-top:30%;
		text-align:center;
	}
	
	#regulamento{
		font-size:9px;
		font-weight:normal;
		text-align:center;
		width:58%;
		margin-left:auto;
		margin-right:auto;
	}
	
	#texto_atestado{
		font-size:14px;
		margin-top:5%;
		padding:0 40px 0px 30px;
		height:170px;  
		line-height:25px;
		text-align:justify;
		word-spacing: 2px;
	}
	#cliente{
		font-family:Arial, Helvetica, sans-serif;
		font-size:10px;
		margin-top:25%;
	}
	.trecho_texto,.linha{
		float:left;
	}
	.linha{		
		margin-left:4px;
		height:20px;
		border-bottom: solid 1px #000000;
	}
	#atestado_fins{
		width:285px;
		
	}
	#atestato_cliente{		
		width: 345px;
				
	}
	#atestado_rg{			
		width: 190px;	
	}
	#atestado_endereco{
		width:98%;
	}
	#dias_afastamento{
		width:50px;
		text-align:center;
	}
	#dias_afastamento_extenso{
		width:200px;
		text-align:center;
	}
	.atestado_hora{
		width:145px;
		text-align:center;
	}
	.atestado_data{
		width:40px;
		text-align:center;
	}
	#data_emissao{
		margin-top:40px;
		width:50%;
		float:right;
		margin-right:100px;
		font-size:14px;
	}
	#cid{
		padding:0 40px 0px 30px;
		margin-top:15px;
		font-size:13px;
	}
	#atestado_cid{		
		width:100px;
	}
</style>
</head>

<body>
<div id="atestado">
		
    <div id="header">
    	<div id="info_dentista">
    		Dr(a). <?=$odontologo->nome?>
        	<div style="clear:both"></div>
            <?=$odontologo->ramo_atividade?>
            <div style="clear:both"></div>
            CRO-AM <?=$odontologo->cro?>
        </div> 
        <div id="logo_clinica">
    		
        </div> 
    </div>
    
    <div id="titulo_atestado">
    	ATESTADO ODONTOL�GICO
        <div id="regulamento">
        (Regulamentado pelas leis n&quot; 5081 de 24/08/1996 e 6215 de 30/06/75)
        1&ordf; via: paciente - 2&ordf; via: consult�rio
    	</div>
    </div>
    <div id="texto_atestado">
    	<div class="trecho_texto">Atesto para fim de</div> <div class="linha" id="atestado_fins"></div>, a
         <div style="clear:both"></div>       
        <div class="trecho_texto"> pedido, que</div> <div class="linha" id="atestato_cliente"><?=$cliente->razao_social?></div>
        <div style="clear:both"></div> 
        <div class="trecho_texto">RG N&ordm; </div> <div class="linha" id="atestado_rg"><?=$cliente->rg?></div>  
        
        <div class="trecho_texto">, residente e domiciliado(a) �</div>
        <div class="linha" id="atestado_endereco"> <?=$cliente->endereco?>, <?=$cliente->bairro?> - <?=$cliente->cidade."/".strtoupper($cliente->estado)?></div>
        <div class="trech_texto">,</div>
        <div class="trecho_texto" style="word-spacing:3px;">esteve sob tratamento odontol�gico neste consult�rio, no per�odo</div>
        <div class="trecho_texto">das</div>
                
        <div class="linha atestado_hora"> <?=substr($atestado->hora_inicio,0,5)?></div>
        <div class="trecho_texto" style="margin-left:5px;"> �s </div>
		<div class="linha atestado_hora"> <?=substr($atestado->hora_fim,0,5)?></div>
        
        <div class="trecho_texto" style="margin-left:5px;"> horas do dia </div>
        <div class="linha atestado_data"><?=substr($atestado->data,8,2)?></div>
        <div class="trecho_texto" style="margin-left:5px;">/</div>
        <div class="linha atestado_data"><?=substr($atestado->data,5,2)?></div>
        <div class="trecho_texto" style="margin-left:5px;">/</div>
        <div class="linha atestado_data"><?=substr($atestado->data,0,4)?></div>
        <div class="trecho_texto" style="word-spacing:18px;">, necessitando o(a) mesmo(a) de</div> <div class="linha" id="dias_afastamento"><?=$atestado->dias_afastado?></div> 
        <div class="trecho_texto" style="margin-left:5px;">(</div>
        <div class="linha" id="dias_afastamento_extenso"><?=numero($atestado->dias_afastado,"")?></div> 
   		<div class="trecho_texto">)</div>
        <div class="trecho_texto" style="margin-left:5px;"> dias de repouso.</div>
   </div>
        
    <div id="data_emissao">
    	 <div class="trecho_texto" style="margin-left:5px;">Manaus, </div>
         <div class="linha atestado_data"><?=date('d')?></div>
         <div class="trecho_texto" style="margin-left:5px;">/</div>
        <div class="linha atestado_data"><?=date('m')?></div>
        <div class="trecho_texto" style="margin-left:5px;">/</div>
        <div class="linha atestado_data"><?=date('Y')?></div>
    </div>
     
     <div style="clear:both"></div>
        
     <div id="cid">
    	 <div class="trecho_texto" style="margin-left:5px;">C.I.D</div>
         <div class="linha" id="atestado_cid"><?=$atestado->cid?></div>
    </div>    
    
    <div style="clear:both"></div>
    
     <div id="autorizacao_paciente" style="float:left;width:250px;padding: 0 0 0 30px;">
    	<div class="linha" style="width:150px;"></div>
        <div style="clear:both"></div>
        <div id="regulamento" style="margin-left:2px;text-align:center;">
        autoriza��o do seu paciente ou de seu representante legal
    	</div>
    </div>
    
    <div id="carimbo" style="float:right; width:170px;padding:0 40px 0 0;">
    	<div class="linha" style="width:150px;"></div>
        <div style="clear:both"></div>
        <div id="regulamento" style="text-align:right;">
        carimbo e assinatura
    	</div>
    </div>
    
    <div style="clear:both"></div>
    
    <div id="rodape" style="margin-top:20px;;padding:0 40px 0 30px;">
    	<?=$cliente_vekttor->endereco?> - <?=$cliente_vekttor->bairro?> - <?=$cliente_vekttor->cep?> - <?=$cliente_vekttor->cidade?> - <?=$cliente_vekttor->estado?>
    	<div style="clear:both"></div>
        Fone: <?=$cliente_vekttor->telefone?> 
    </div>
</div>
</body>
</html>