<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */


class regraEmissao {

  private $iConvenio 		         = null;
  private $iModCarnePadrao       = null;                                                                                         
  private $oSpdf	     	         = null;
  public  $oObjPdf	     	       = null;
  private $oObjLayout     	     = null;
  private $lArrecadacao    	     = false;
  private $lCobranca    	       = false;
  private $iCodConvenioCobranca  = false;
  
  /**
   * se Deve gerar novo objeto pdf, ou usar um j� existente
   *
   * @var boolean
   */
  private $lNovoPdf              = true;
  private $lOpenUnico            = false;
  public  $oPdfUnico             = null;
  
  function __construct($iArretipo=null,$iTipoMod,$iInstit,$dDatahj,$sIp=null, $lNovoPdf = true, $oPdfUnico = null) {

    $this->lNovoPdf  = $lNovoPdf;
    $this->oPdfUnico = $oPdfUnico;
     
    $sWhereModCarne  = "   where k48_dataini  <= '{$dDatahj}' ";
    $sWhereModCarne .= "     and k48_datafim  >= '{$dDatahj}' ";
    $sWhereModCarne .= "     and k48_instit     = {$iInstit}  ";
    $sWhereModCarne .= "     and k48_cadtipomod = {$iTipoMod} ";
  	
  	$sSqlTipoExecessao  = " select distinct k48_sequencial,                                                                               ";
  	$sSqlTipoExecessao .= "        k49_tipo,                                                                                              ";
  	$sSqlTipoExecessao .= "        k36_ip                                                                                                 ";
    $sSqlTipoExecessao .= "   from modcarnepadrao                                                                                         ";      
    $sSqlTipoExecessao .= "        left  join modcarnepadraotipo on modcarnepadraotipo.k49_modcarnepadrao = modcarnepadrao.k48_sequencial ";
    $sSqlTipoExecessao .= "        left  join modcarneexcessao   on modcarneexcessao.k36_modcarnepadrao   = modcarnepadrao.k48_sequencial ";  	
    $sSqlTipoExecessao .= $sWhereModCarne;  	
  	
    $rsConsultaTipoExcessao = db_query($sSqlTipoExecessao);
    $iNroLinhasTipoExcessao = pg_num_rows($rsConsultaTipoExcessao);
  	
    $iCodModCarnePadrao     = '';
  	
    // Valida��o de Tipo e Excess�o
    
  	for ( $iInd=0; $iInd < $iNroLinhasTipoExcessao; $iInd++ ) {
  		
  		$oTipoExcessao = db_utils::fieldsMemory($rsConsultaTipoExcessao,$iInd);

  		if ( $oTipoExcessao->k49_tipo != '' || $oTipoExcessao->k36_ip != '' ) {
  			
	  		if (!empty($iArretipo) && !empty($sIp)) {
	  			if( $oTipoExcessao->k49_tipo != '' && $oTipoExcessao->k36_ip != '' ){
		  			if ( trim($iArretipo) == trim($oTipoExcessao->k49_tipo) && $sIp == $oTipoExcessao->k36_ip) {
		  				$iCodModCarnePadrao = $oTipoExcessao->k48_sequencial;
		  			}
	  			} else if( $oTipoExcessao->k36_ip != ''){
	  			  if ( $sIp == $oTipoExcessao->k36_ip) {
              $iCodModCarnePadrao = $oTipoExcessao->k48_sequencial;
            }	  				
	  			} else {
	  			  if ( trim($iArretipo) == trim($oTipoExcessao->k49_tipo)) {
              $iCodModCarnePadrao = $oTipoExcessao->k48_sequencial;
            }	  				
	  			}
	  		} else if ( !empty($sIp) ) {
	  		  if ( $sIp == $oTipoExcessao->k36_ip ) {
	          $iCodModCarnePadrao = $oTipoExcessao->k48_sequencial;
	        }  			
	  		} else if ( !empty($iArretipo) ) {
	  		  if ( trim($iArretipo) == trim($oTipoExcessao->k49_tipo) && $oTipoExcessao->k36_ip == "") {
	          $iCodModCarnePadrao = $oTipoExcessao->k48_sequencial;
	        }  			
	  		} else {
	 			  $iCodModCarnePadrao = $oTipoExcessao->k48_sequencial;
	  		}
	  		
	  	// Caso n�o tenha retornado nenhum tipo ou excess�o e a vari�vel $iCodModCarnePadrao estiver vazia ent�o � atribu�do
	  	// a ela o c�digo do molelo padr�o	
  		} else if (trim($iCodModCarnePadrao) == '') {
        $iCodModCarnePadrao = $oTipoExcessao->k48_sequencial;  			
  		}
  		
  	}
    
  	
  	if ( $iCodModCarnePadrao != "" ) {
  	
	  	$sSql  = "  select k48_sequencial,                                                                                         				 	                  ";
	    $sSql .= "  	     k48_cadconvenio,                                                                                        				 	                  ";	
	    $sSql .= "  	     ar12_cadconveniomodalidade,                                                                                			                  ";    
	    $sSql .= "  	     m01_sequencial,                                                                                         				 	                  ";	
	    $sSql .= "  	     m02_sequencial,                                                                                         				 	                  ";
	    $sSql .= "  	     k47_sequencial,                                                                                         					                  ";        
			$sSql .= "         k47_descr,                                                                                              					                  ";
			$sSql .= "         k47_obs,                                                                                                				 	                  ";
			$sSql .= "         k47_altura,                                                                                             				 	                  ";
			$sSql .= "         k47_largura,                                                                                            				 	                  ";
			$sSql .= "         k47_orientacao                                                                                          					                  ";
			$sSql .= "    from modcarnepadrao																								                                                  	                  ";    	
	    $sSql .= "  	     inner join cadconvenio                on cadconvenio.ar11_sequencial                  = modcarnepadrao.k48_cadconvenio             ";
	    $sSql .= "  	     inner join cadtipoconvenio            on cadtipoconvenio.ar12_sequencial              = cadconvenio.ar11_cadtipoconvenio           ";
	    $sSql .= "  	     left  join conveniocobranca           on conveniocobranca.ar13_cadconvenio  	         = cadconvenio.ar11_sequencial                ";
			$sSql .= "         left  join modcarnepadraocadmodcarne  on modcarnepadraocadmodcarne.m01_modcarnepadrao = modcarnepadrao.k48_sequencial 	            ";
			$sSql .= "         left  join cadmodcarne 				       on cadmodcarne.k47_sequencial	                 = modcarnepadraocadmodcarne.m01_cadmodcarne 	";	
			$sSql .= "         left  join modcarnepadraolayouttxt    on modcarnepadraolayouttxt.m02_modcarnepadrao   = modcarnepadrao.k48_sequencial 	            ";
			$sSql .= "         left  join db_layouttxt 				       on db_layouttxt.db50_codigo 		                 = modcarnepadraolayouttxt.m02_db_layouttxt 	";
	    $sSql .= "   where k48_sequencial = {$iCodModCarnePadrao}                                                                                             ";
			
			$rsConsultaRegra = pg_query($sSql);
			$iNroLinhas		   = pg_num_rows($rsConsultaRegra);
			
			if ( $iNroLinhas > 0 ) {
		    
			  $oModCarne = db_utils::fieldsMemory($rsConsultaRegra,0);
		
			  $this->iModCarnePadrao = $oModCarne->k48_sequencial;
			  $this->iConvenio 			 = $oModCarne->k48_cadconvenio;
		
			  if ( !empty($oModCarne->m01_sequencial) ) { 
			    $this->setObjPdf($oModCarne->k47_altura,$oModCarne->k47_largura,$oModCarne->k47_orientacao,$oModCarne->k47_sequencial);
			  } else if (!empty($oModCarne->m02_sequencial)) {
				  $this->setObjLayout();
			  }
				
			  if ( !empty($oModCarne->ar13_sequencial)) {
			  	 $this->iCodConvenioCobranca = $oModCarne->ar13_sequencial; 
			  } else {
			  	 $this->iCodConvenioCobranca = 0;
			  }
			  
			  if ($oModCarne->ar12_cadconveniomodalidade == 1 ){
			  	$this->lArrecadacao = false;
			  	$this->lCobranca    = true; 
			  } else if ($oModCarne->ar12_cadconveniomodalidade == 2 ) {
			  	$this->lArrecadacao = true;
			  	$this->lCobranca    = false;	  	
			  }
			  
			} else {
			  throw new Exception("Nenhum conv�nio encontrado! TipoMod:{$iTipoMod}, Tipo D�bito: {$iArretipo}");
			}
  	} else {
		  throw new Exception("Nenhum modelo padr�o encontrado! TipoMod:{$iTipoMod}, Tipo D�bito: {$iArretipo}"); 
  	}
  }
  
  function getObj(){
  	
  	if ($this->isPdf()){
  	  return $this->getObjPdf();
  	}else{
  	  return $this->getObjLayout();
  	}
  	
  }
  
  
  function setObjPdf($iAltura="",$iLargura="",$sOrientacao="",$iCadModCarne){
  	
  	require_once("fpdf151/impcarne.php");
  	
  	if ($this->lNovoPdf) {
    	if ( $iAltura != 0 && $iLargura != 0 && $sOrientacao != ""){
  
    	  $aMedidas 	 = array($iAltura,$iLargura);
  	    $this->oSpdf = new scpdf($sOrientacao,"mm",$aMedidas);
  	    
    	} else {
  	     $this->oSpdf = new scpdf();
  	  }
  	  $this->oSpdf->Open();
  	  $this->oObjPdf = new db_impcarne(&$this->oSpdf,$iCadModCarne);
  	  
    } else {

      if (!$this->lOpenUnico) {
        $this->oPdfUnico->open();
        $this->lOpenUnico = true;
      }
      $this->oObjPdf = new db_impcarne(&$this->oPdfUnico, $iCadModCarne); 
    }
    
  }
  
  function setObjLayout(){
	 $this->oObjLayout = "";  	
  }
  
  function getObjPdf(){
	  return $this->oObjPdf;  	
  }

  function getObjLayout(){
  	return $this->oObjLayout;
  }
  
  function getConvenio(){
  	return $this->iConvenio;
  }
  
  function getModCarnePadrao(){
  	return $this->iModCarnePadrao;
  }
  
  function setPdfUnico($oPdf) {
    $this->oPdfUnico = $oPdf;
  }
  function getSpdf(){
  	return $this->oSpdf;
  }

  function isPdf(){
  	if(!empty($this->oObjPdf)){
  	  return true; 	
  	} else {
  	  return false;
  	}
  }
  
  function isArrecadacao(){
	  return $this->lArrecadacao;
  }

  function isCobranca(){ 
  	return $this->lCobranca;
  }
  
  function getCodConvenioCobranca(){
  	return $this->iCodConvenioCobranca;
  }
  
}

?>