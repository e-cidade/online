<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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

require_once("libs/db_conecta.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");

$oPost    = db_utils::postMemory($_POST);
$oJson    = new services_json();

$lErro    = false;
$sMsgErro = '';


if ( $oPost->tipo == "consultaMes" ) {
  

  $sSqlCalculoMes = " select distinct rh02_mesusu as codigo, 
                                      case when rh02_mesusu = 1  then 'Janeiro'  
                                           when rh02_mesusu = 2  then 'Fevereiro' 
                                           when rh02_mesusu = 3  then 'Março'
                                           when rh02_mesusu = 4  then 'Abril'
                                           when rh02_mesusu = 5  then 'Maio'
                                           when rh02_mesusu = 6  then 'Junho'
                                           when rh02_mesusu = 7  then 'Julho'
                                           when rh02_mesusu = 8  then 'Agosto'
                                           when rh02_mesusu = 9  then 'Setembro'
                                           when rh02_mesusu = 10 then 'Outubro'
                                           when rh02_mesusu = 11 then 'Novembro '
                                           when rh02_mesusu = 12 then 'Dezembro'  end as descr
                           from rhpessoalmov 
                                left join rhpesrescisao on rh05_seqpes = rh02_seqpes
                          where rh02_regist  = {$oPost->matric} 
                            and rh02_anousu  = {$oPost->anousu}
                            and rh02_instit  = {$oPost->instit} 
                            and case when rh02_anousu = fc_anofolha({$oPost->instit}) 
                                      and rh02_mesusu = fc_mesfolha({$oPost->instit}) then false else true end
                          order by rh02_mesusu desc ";
                            
  $rsCalculoMes = db_query($sSqlCalculoMes);
    
  if ( $rsCalculoMes ) {
    $aRetorno = db_utils::getColectionByRecord($rsCalculoMes,false,false,true);
  } else {
    $sMsgErro = pg_last_error();
    $lErro    = true;
  }   
  
  
  if ( $lErro ) {
    $aRetorno  = array( "sMsg" =>urlencode($sMsgErro),
                        "lErro"=>true );    
  } else {
    $aRetorno  = array( "aLista"=>$aRetorno,
                        "lErro" =>false );
  }
  
  echo $oJson->encode($aRetorno); 
  

} else if ( $oPost->tipo == "consultaTipoCalc" ) {
  
  
    $sSqlTipoCalculo = "select distinct 'r14' as codigo ,case when r14_regist is not null then 'Salário' end as descr 
                           from gerfsal 
                          where r14_regist = {$oPost->matric} 
                            and r14_anousu = {$oPost->anousu}
                            and r14_mesusu = {$oPost->mesusu}   
                        union all
                       select distinct 'r22' as codigo,case when r22_regist is not null then 'Adiantamento' end as descr 
                           from gerfadi
                          where r22_regist = {$oPost->matric} 
                            and r22_anousu = {$oPost->anousu}
                            and r22_mesusu = {$oPost->mesusu}
                        union all
                       select distinct 'r48' as codigo,case when r48_regist is not null then 'Complementar' end as descr 
                           from gerfcom
                          where r48_regist = {$oPost->matric} 
                            and r48_anousu = {$oPost->anousu}
                            and r48_mesusu = {$oPost->mesusu}
                       union all
                       select distinct 'r35' as codigo,case when r35_regist is not null then '13º Salário' end as descr 
                           from gerfs13
                          where r35_regist = {$oPost->matric} 
                            and r35_anousu = {$oPost->anousu}
                            and r35_mesusu = {$oPost->mesusu}
                        union all
                       select distinct 'r20' as codigo,case when r20_regist is not null then 'Rescisão' end as descr 
                           from gerfres
                          where r20_regist = {$oPost->matric} 
                            and r20_anousu = {$oPost->anousu}
                            and r20_mesusu = {$oPost->mesusu}  ";
    
    $rsTipoCalculo   = db_query($sSqlTipoCalculo);
    
    if ( $rsTipoCalculo ) {
      $aRetorno = db_utils::getColectionByRecord($rsTipoCalculo,false,false,true);
    } else {
      $sMsgErro = pg_last_error();
      $lErro    = true;
    } 

  
  if ( $lErro ) {
    $aRetorno  = array( "sMsg" =>urlencode($sMsgErro),
                        "lErro"=>true );    
  } else {
    $aRetorno  = array( "aLista"=>$aRetorno,
                        "lErro" =>false );
  }
  
  echo $oJson->encode($aRetorno);
    
}
  
?>