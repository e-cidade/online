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

error_reporting('** CONSULTA FUNCIONAL! **');
session_start();

include("libs/db_conecta.php");
include("libs/db_stdlib.php");
include("libs/db_sql.php");
include("libs/db_utils.php");
include("dbforms/db_funcoes.php");

validaUsuarioLogado();

$aRetorno = array();
parse_str(base64_decode($HTTP_SERVER_VARS["QUERY_STRING"]),$aRetorno);

$id_usuario  = $aRetorno['id_usuario'];
$matricula   = $aRetorno['matricula'];
$instituicao = $aRetorno['instituicao'];
$numcgm      = db_getsession("DB_login");
$anoFolha    = db_anofolha($instituicao);
$mesFolha    = db_mesfolha($instituicao);

db_logs("","",0,"Consulta Funcional.");

$sUrl       = base64_encode("iMatric=".$matricula."&iInstit=".$instituicao);
$sUrlAverba = base64_encode("&averba");

/**
 * Caso o cliente seja Bage (codcli = 15) 
 * Ent�o a vari�vel lBloqueio passa a ser true e n�o mostrar� os menus:
 * - Assentamento 
 * - Averba��o do tempo de servi�o 
 * - F�rias
 * 
 * Do contr�rio todos os menus s�o mostrados normalmente.
 */
$lBloqueio = false;
$rsCodCli  = db_query("select db21_codcli from db_config where prefeitura is true limit 1");
$iCodCli   = db_utils::fieldsmemory($rsCodCli)->db21_codcli;
if ($iCodCli == 15 ) {
  $lBloqueio = true; 
}

?>
<html>
<head>
<title><?=$w01_titulo?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="config/portalservidor.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="scripts/db_script.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="<?=$w01_corbody?>">
<table width="100%" border="0" bordercolor="#cccccc" cellpadding="2" cellspacing="0" class="texto">
 <tr>
  <td><br></td>
 </tr>
</table>
<?
  if ($id_usuario != "") { 
?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="texto">
  <tr>
    <td valign="top" width="10%">
     <table width="200" height="10%" id="navigation" border="0">
        <tr>
           <td nowrap="nowrap" width="100%">
             <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('dadosCadastrais');">Consulta Dados Cadastrais</span>
           </td>
        </tr>
        
        <? if ($lBloqueio == false ) { ?>
        <tr>
           <td nowrap="nowrap" width="100%">
             <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('assentamentos');">Assentamentos</span>
           </td>
        </tr>     
        <tr>
           <td nowrap="nowrap" width="100%">
             <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('averbacao');">Averba��o de Tempo de Servi�o</span>
           </td>
        </tr>
        <? } ?>
        
        <tr>
            <td nowrap="nowrap" width="100%">
              <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('dependentes');">Dependentes</span>
            </td>
         </tr>
         
        <? if ($lBloqueio == false ) { ?>
         <tr>
            <td nowrap="nowrap" width="100%">
              <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('ferias');">F�rias</span>
            </td>
         </tr>
        <? } ?>
                    
         <tr>
             <td nowrap="nowrap" width="100%">
               <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('comprovanteRendimentos');">Comprovante de Rendimentos</span>
             </td>
         </tr>                              
         <tr>
            <td nowrap="nowrap" width="100%">
              <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('fichaFinanceira');">Ficha Financeira</span>
            </td>
         </tr>
         <tr>
             <td nowrap="nowrap" width="100%">&nbsp;</td>
         </tr>                        
         <tr>
           <td nowrap="nowrap" width="100%">
             <span class="navText" style="cursor: pointer;" onClick="js_voltar('<?=$id_usuario?>');">Voltar</span>
           </td>
         </tr>          
     </table>
    </td>
    <td valign="top" width="97%">
      <iframe id="iframePortalServidor" name="iframe" src="centro_pref.php" width="100%" height="500px;" style="border:hidden;"></iframe>
    </td width="3%"> 
    <td>&nbsp;</td>       
  </tr>  
</table>
<? 
  } else if ($w13_permfornsemlog == "f") {
?>
 <table width="300" align="center" border="0" bordercolor="#cccccc" cellpadding="2" cellspacing="0" class="texto">
  <tr height="220">
   <td align="center">
    <img src="imagens/atencao.gif"><br>
    Para acessar suas informa��es, efetue login.
   </td>
  </tr>
 </table>
<?
}
?>
</body>
</html>
<script>
function imprimir(){
 jan=window.open('',
                 '',
                 'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
                 
 jan.moveTo(0,0);
}

function js_voltar(id){
  var idusuario = id;
  document.location.href = 'cons_funcional.php?id_usuario='+idusuario;
}

function js_atualizaFrame( sOpcao ){

  var sQuery = '<?=$sUrl?>'; 
 
  if ( sOpcao == 'dadosCadastrais') {
    document.getElementById('iframePortalServidor').src = 'dadosfuncionario.php?'+sQuery;
  } else if (sOpcao == 'assentamentos') {
    document.getElementById('iframePortalServidor').src = 'dadosassentamentos.php?'+sQuery;
  } else if (sOpcao == 'averbacao') {
    document.getElementById('iframePortalServidor').src = 'dadosassentamentos.php?'+sQuery+'<?=$sUrlAverba?>';
  } else if (sOpcao == 'dependentes') {
    document.getElementById('iframePortalServidor').src = 'dependentesservidor.php?'+sQuery;
  } else if (sOpcao == 'ferias') {
    document.getElementById('iframePortalServidor').src = 'feriasservidor.php?'+sQuery;
  } else if (sOpcao == 'comprovanteRendimentos') {
    document.getElementById('iframePortalServidor').src = 'comprovanterendimentosservidor.php?'+sQuery;
  } else if (sOpcao == 'fichaFinanceira') {
    document.getElementById('iframePortalServidor').src = 'fichafinanceiraservidor.php?'+sQuery;
  } 
  

}
</script>