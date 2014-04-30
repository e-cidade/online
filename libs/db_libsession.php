<?
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


// Salva o conteudo da sessao no banco de dados
function db_savesession($_conn, $_session) {
  
  // Cria tabela temporaria para a conexao corrente
  $sql  = "SELECT fc_startsession();";
  
  $result = pg_query($_conn, $sql) or die("Não foi possível criar sessão no banco de dados (Sql: $sql)!");
  
  if (pg_num_rows($result)==0) {
    return false;
  }

  // Verifica se conseguiu iniciar nova sessao ou se ja existia no banco de dados
  $lInsert = (pg_result($result, 0, 0) == "t");

  // Nome da Sessao
  $sql = "SELECT fc_sessionname()";
  $result = pg_query($_conn, $sql) or die("Não foi possível definir sessão no banco de dados (Sql: $sql)!");
  
  if (pg_num_rows($result)==0) {
    return false;
  }

  // Pega nome da sessao
  $sNomeSessao = pg_result($result, 0, 0);

  // Insere as variaveis da sessao na tabela
  $sql   = $lInsert?"INSERT INTO {$sNomeSessao}(variavel, conteudo) ":"";
  $union = "";
  
  foreach($_session as $key=>$val) {
    
    switch (strtoupper($key)) {
    case "DB_DATAUSU":
      $val = date("Y-m-d", $val);
      break; 
    }
    if (substr($key,0,2) == "DB"){ 
      $val = addslashes($val);

      if ($lInsert) {
        $sql .= $union . "SELECT '".strtoupper($key)."', '$val'";
      } else {
        $sql .= $union . "SELECT fc_putsession('$key', '$val')";
      }
      $union = " UNION ALL ";
    }
  } 
  
  pg_query($_conn, $sql) or die("Não foi possível criar sessão no banco de dados (Sql: $sql)!");
  
  return true;
} 


?>