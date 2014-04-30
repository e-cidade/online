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

//MODULO: issqn
//CLASSE DA ENTIDADE parissqn
class cl_parissqn { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $numrows_incluir = 0; 
   var $numrows_alterar = 0; 
   var $numrows_excluir = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $erro_campo = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $q60_receit = 0; 
   var $q60_tipo = 0; 
   var $q60_aliq = 0; 
   var $q60_codvencvar = 0; 
   var $q60_histsemmov = 0; 
   var $q60_impcodativ = 'f'; 
   var $q60_impobsativ = 'f'; 
   var $q60_impdatas = 'f'; 
   var $q60_impobsissqn = 'f'; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 q60_receit = int4 = Receita 
                 q60_tipo = int4 = tipo de debito 
                 q60_aliq = int4 = Aliquota padrão 
                 q60_codvencvar = int4 = codigo do vencimento 
                 q60_histsemmov = int4 = Hist.Calc. 
                 q60_impcodativ = bool = Imprime Código Atividade 
                 q60_impobsativ = bool = Imprime Observação Atividade 
                 q60_impdatas = bool = Imprime Datas 
                 q60_impobsissqn = bool = Observação do ISSQN 
                 ";
   //funcao construtor da classe 
   function cl_parissqn() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("parissqn"); 
     $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
   }
   //funcao erro 
   function erro($mostra,$retorna) { 
     if(($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )){
        echo "<script>alert(\"".$this->erro_msg."\");</script>";
        if($retorna==true){
           echo "<script>location.href='".$this->pagina_retorno."'</script>";
        }
     }
   }
   // funcao para atualizar campos
   function atualizacampos($exclusao=false) {
     if($exclusao==false){
       $this->q60_receit = ($this->q60_receit == ""?@$GLOBALS["HTTP_POST_VARS"]["q60_receit"]:$this->q60_receit);
       $this->q60_tipo = ($this->q60_tipo == ""?@$GLOBALS["HTTP_POST_VARS"]["q60_tipo"]:$this->q60_tipo);
       $this->q60_aliq = ($this->q60_aliq == ""?@$GLOBALS["HTTP_POST_VARS"]["q60_aliq"]:$this->q60_aliq);
       $this->q60_codvencvar = ($this->q60_codvencvar == ""?@$GLOBALS["HTTP_POST_VARS"]["q60_codvencvar"]:$this->q60_codvencvar);
       $this->q60_histsemmov = ($this->q60_histsemmov == ""?@$GLOBALS["HTTP_POST_VARS"]["q60_histsemmov"]:$this->q60_histsemmov);
       $this->q60_impcodativ = ($this->q60_impcodativ == "f"?@$GLOBALS["HTTP_POST_VARS"]["q60_impcodativ"]:$this->q60_impcodativ);
       $this->q60_impobsativ = ($this->q60_impobsativ == "f"?@$GLOBALS["HTTP_POST_VARS"]["q60_impobsativ"]:$this->q60_impobsativ);
       $this->q60_impdatas = ($this->q60_impdatas == "f"?@$GLOBALS["HTTP_POST_VARS"]["q60_impdatas"]:$this->q60_impdatas);
       $this->q60_impobsissqn = ($this->q60_impobsissqn == "f"?@$GLOBALS["HTTP_POST_VARS"]["q60_impobsissqn"]:$this->q60_impobsissqn);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){ 
      $this->atualizacampos();
     if($this->q60_receit == null ){ 
       $this->erro_sql = " Campo Receita nao Informado.";
       $this->erro_campo = "q60_receit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q60_tipo == null ){ 
       $this->erro_sql = " Campo tipo de debito nao Informado.";
       $this->erro_campo = "q60_tipo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q60_aliq == null ){ 
       $this->erro_sql = " Campo Aliquota padrão nao Informado.";
       $this->erro_campo = "q60_aliq";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q60_codvencvar == null ){ 
       $this->erro_sql = " Campo codigo do vencimento nao Informado.";
       $this->erro_campo = "q60_codvencvar";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q60_histsemmov == null ){ 
       $this->erro_sql = " Campo Hist.Calc. nao Informado.";
       $this->erro_campo = "q60_histsemmov";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q60_impcodativ == null ){ 
       $this->erro_sql = " Campo Imprime Código Atividade nao Informado.";
       $this->erro_campo = "q60_impcodativ";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q60_impobsativ == null ){ 
       $this->erro_sql = " Campo Imprime Observação Atividade nao Informado.";
       $this->erro_campo = "q60_impobsativ";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q60_impdatas == null ){ 
       $this->erro_sql = " Campo Imprime Datas nao Informado.";
       $this->erro_campo = "q60_impdatas";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q60_impobsissqn == null ){ 
       $this->erro_sql = " Campo Observação do ISSQN nao Informado.";
       $this->erro_campo = "q60_impobsissqn";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into parissqn(
                                       q60_receit 
                                      ,q60_tipo 
                                      ,q60_aliq 
                                      ,q60_codvencvar 
                                      ,q60_histsemmov 
                                      ,q60_impcodativ 
                                      ,q60_impobsativ 
                                      ,q60_impdatas 
                                      ,q60_impobsissqn 
                       )
                values (
                                $this->q60_receit 
                               ,$this->q60_tipo 
                               ,$this->q60_aliq 
                               ,$this->q60_codvencvar 
                               ,$this->q60_histsemmov 
                               ,'$this->q60_impcodativ' 
                               ,'$this->q60_impobsativ' 
                               ,'$this->q60_impdatas' 
                               ,'$this->q60_impobsissqn' 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Valores padrões do ISSQN () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Valores padrões do ISSQN já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Valores padrões do ISSQN () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   } 
   // funcao para alteracao
   function alterar ( $oid=null ) { 
      $this->atualizacampos();
     $sql = " update parissqn set ";
     $virgula = "";
     if(trim($this->q60_receit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q60_receit"])){ 
       $sql  .= $virgula." q60_receit = $this->q60_receit ";
       $virgula = ",";
       if(trim($this->q60_receit) == null ){ 
         $this->erro_sql = " Campo Receita nao Informado.";
         $this->erro_campo = "q60_receit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q60_tipo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q60_tipo"])){ 
       $sql  .= $virgula." q60_tipo = $this->q60_tipo ";
       $virgula = ",";
       if(trim($this->q60_tipo) == null ){ 
         $this->erro_sql = " Campo tipo de debito nao Informado.";
         $this->erro_campo = "q60_tipo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q60_aliq)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q60_aliq"])){ 
       $sql  .= $virgula." q60_aliq = $this->q60_aliq ";
       $virgula = ",";
       if(trim($this->q60_aliq) == null ){ 
         $this->erro_sql = " Campo Aliquota padrão nao Informado.";
         $this->erro_campo = "q60_aliq";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q60_codvencvar)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q60_codvencvar"])){ 
       $sql  .= $virgula." q60_codvencvar = $this->q60_codvencvar ";
       $virgula = ",";
       if(trim($this->q60_codvencvar) == null ){ 
         $this->erro_sql = " Campo codigo do vencimento nao Informado.";
         $this->erro_campo = "q60_codvencvar";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q60_histsemmov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q60_histsemmov"])){ 
       $sql  .= $virgula." q60_histsemmov = $this->q60_histsemmov ";
       $virgula = ",";
       if(trim($this->q60_histsemmov) == null ){ 
         $this->erro_sql = " Campo Hist.Calc. nao Informado.";
         $this->erro_campo = "q60_histsemmov";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q60_impcodativ)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q60_impcodativ"])){ 
       $sql  .= $virgula." q60_impcodativ = '$this->q60_impcodativ' ";
       $virgula = ",";
       if(trim($this->q60_impcodativ) == null ){ 
         $this->erro_sql = " Campo Imprime Código Atividade nao Informado.";
         $this->erro_campo = "q60_impcodativ";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q60_impobsativ)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q60_impobsativ"])){ 
       $sql  .= $virgula." q60_impobsativ = '$this->q60_impobsativ' ";
       $virgula = ",";
       if(trim($this->q60_impobsativ) == null ){ 
         $this->erro_sql = " Campo Imprime Observação Atividade nao Informado.";
         $this->erro_campo = "q60_impobsativ";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q60_impdatas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q60_impdatas"])){ 
       $sql  .= $virgula." q60_impdatas = '$this->q60_impdatas' ";
       $virgula = ",";
       if(trim($this->q60_impdatas) == null ){ 
         $this->erro_sql = " Campo Imprime Datas nao Informado.";
         $this->erro_campo = "q60_impdatas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q60_impobsissqn)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q60_impobsissqn"])){ 
       $sql  .= $virgula." q60_impobsissqn = '$this->q60_impobsissqn' ";
       $virgula = ",";
       if(trim($this->q60_impobsissqn) == null ){ 
         $this->erro_sql = " Campo Observação do ISSQN nao Informado.";
         $this->erro_campo = "q60_impobsissqn";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
$sql .= "oid = '$oid'";     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Valores padrões do ISSQN nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Valores padrões do ISSQN nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ( $oid=null ,$dbwhere=null) { 
     $sql = " delete from parissqn
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
       $sql2 = "oid = '$oid'";
     }else{
       $sql2 = $dbwhere;
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Valores padrões do ISSQN nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Valores padrões do ISSQN nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   function sql_record($sql) { 
     $result = @pg_query($sql);
     if($result==false){
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:parissqn";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $oid = null,$campos="parissqn.oid,*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from parissqn ";
     $sql .= "      inner join cadvencdesc  on  cadvencdesc.q92_codigo = parissqn.q60_codvencvar";
     $sql .= "      inner join histcalc  on  histcalc.k01_codigo = parissqn.q60_histsemmov";
     $sql .= "      inner join tabrec  on  tabrec.k02_codigo = parissqn.q60_receit";
     $sql .= "      inner join arretipo  on  arretipo.k00_tipo = parissqn.q60_tipo";
     $sql .= "      inner join histcalc  as a on   a.k01_codigo = cadvencdesc.q92_hist";
     $sql .= "      inner join arretipo  as b on   b.k00_tipo = cadvencdesc.q92_tipo";
     $sql .= "      inner join tabrecjm  on  tabrecjm.k02_codjm = tabrec.k02_codjm";
     $sql .= "      inner join cadtipo  on  cadtipo.k03_tipo = arretipo.k03_tipo";
     $sql2 = "";
     if($dbwhere==""){
       if( $oid != "" && $oid != null){
          $sql2 = " where parissqn.oid = '$oid'";
       }
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
   // funcao do sql 
   function sql_query_file ( $oid = null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from parissqn ";
     $sql2 = "";
     if($dbwhere==""){
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
}
?>