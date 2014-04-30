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

//MODULO: divida ativa
//CLASSE DA ENTIDADE certdiv
class cl_certdiv { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $erro_campo = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $v14_certid = 0; 
   var $v14_coddiv = 0; 
   var $v14_vlrhis = 0; 
   var $v14_vlrcor = 0; 
   var $v14_vlrjur = 0; 
   var $v14_vlrmul = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 v14_certid = int4 = certidao 
                 v14_coddiv = int4 = codigo da divida 
                 v14_vlrhis = float8 = valor historico 
                 v14_vlrcor = float8 = valor corrigido 
                 v14_vlrjur = float8 = valor dos juros 
                 v14_vlrmul = float8 = valor da multa 
                 ";
   //funcao construtor da classe 
   function cl_certdiv() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("certdiv"); 
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
       $this->v14_certid = ($this->v14_certid == ""?@$GLOBALS["HTTP_POST_VARS"]["v14_certid"]:$this->v14_certid);
       $this->v14_coddiv = ($this->v14_coddiv == ""?@$GLOBALS["HTTP_POST_VARS"]["v14_coddiv"]:$this->v14_coddiv);
       $this->v14_vlrhis = ($this->v14_vlrhis == ""?@$GLOBALS["HTTP_POST_VARS"]["v14_vlrhis"]:$this->v14_vlrhis);
       $this->v14_vlrcor = ($this->v14_vlrcor == ""?@$GLOBALS["HTTP_POST_VARS"]["v14_vlrcor"]:$this->v14_vlrcor);
       $this->v14_vlrjur = ($this->v14_vlrjur == ""?@$GLOBALS["HTTP_POST_VARS"]["v14_vlrjur"]:$this->v14_vlrjur);
       $this->v14_vlrmul = ($this->v14_vlrmul == ""?@$GLOBALS["HTTP_POST_VARS"]["v14_vlrmul"]:$this->v14_vlrmul);
     }else{
       $this->v14_certid = ($this->v14_certid == ""?@$GLOBALS["HTTP_POST_VARS"]["v14_certid"]:$this->v14_certid);
       $this->v14_coddiv = ($this->v14_coddiv == ""?@$GLOBALS["HTTP_POST_VARS"]["v14_coddiv"]:$this->v14_coddiv);
     }
   }
   // funcao para inclusao
   function incluir ($v14_certid,$v14_coddiv){ 
      $this->atualizacampos();
     if($this->v14_vlrhis == null ){ 
       $this->erro_sql = " Campo valor historico nao Informado.";
       $this->erro_campo = "v14_vlrhis";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v14_vlrcor == null ){ 
       $this->erro_sql = " Campo valor corrigido nao Informado.";
       $this->erro_campo = "v14_vlrcor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v14_vlrjur == null ){ 
       $this->erro_sql = " Campo valor dos juros nao Informado.";
       $this->erro_campo = "v14_vlrjur";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v14_vlrmul == null ){ 
       $this->erro_sql = " Campo valor da multa nao Informado.";
       $this->erro_campo = "v14_vlrmul";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->v14_certid = $v14_certid; 
       $this->v14_coddiv = $v14_coddiv; 
     if(($this->v14_certid == null) || ($this->v14_certid == "") ){ 
       $this->erro_sql = " Campo v14_certid nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->v14_coddiv == null) || ($this->v14_coddiv == "") ){ 
       $this->erro_sql = " Campo v14_coddiv nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into certdiv(
                                       v14_certid 
                                      ,v14_coddiv 
                                      ,v14_vlrhis 
                                      ,v14_vlrcor 
                                      ,v14_vlrjur 
                                      ,v14_vlrmul 
                       )
                values (
                                $this->v14_certid 
                               ,$this->v14_coddiv 
                               ,$this->v14_vlrhis 
                               ,$this->v14_vlrcor 
                               ,$this->v14_vlrjur 
                               ,$this->v14_vlrmul 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " ($this->v14_certid."-".$this->v14_coddiv) nao Incluído. Inclusao Abortada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->v14_certid."-".$this->v14_coddiv;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($v14_certid=null,$v14_coddiv=null) { 
      $this->atualizacampos();
     $sql = " update certdiv set ";
     $virgula = "";
     if(isset($GLOBALS["HTTP_POST_VARS"]["v14_certid"])){ 
       $sql  .= $virgula." v14_certid = $this->v14_certid ";
       $virgula = ",";
       if($this->v14_certid == null ){ 
         $this->erro_sql = " Campo certidao nao Informado.";
         $this->erro_campo = "v14_certid";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v14_coddiv"])){ 
       $sql  .= $virgula." v14_coddiv = $this->v14_coddiv ";
       $virgula = ",";
       if($this->v14_coddiv == null ){ 
         $this->erro_sql = " Campo codigo da divida nao Informado.";
         $this->erro_campo = "v14_coddiv";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v14_vlrhis"])){ 
       $sql  .= $virgula." v14_vlrhis = $this->v14_vlrhis ";
       $virgula = ",";
       if($this->v14_vlrhis == null ){ 
         $this->erro_sql = " Campo valor historico nao Informado.";
         $this->erro_campo = "v14_vlrhis";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v14_vlrcor"])){ 
       $sql  .= $virgula." v14_vlrcor = $this->v14_vlrcor ";
       $virgula = ",";
       if($this->v14_vlrcor == null ){ 
         $this->erro_sql = " Campo valor corrigido nao Informado.";
         $this->erro_campo = "v14_vlrcor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v14_vlrjur"])){ 
       $sql  .= $virgula." v14_vlrjur = $this->v14_vlrjur ";
       $virgula = ",";
       if($this->v14_vlrjur == null ){ 
         $this->erro_sql = " Campo valor dos juros nao Informado.";
         $this->erro_campo = "v14_vlrjur";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v14_vlrmul"])){ 
       $sql  .= $virgula." v14_vlrmul = $this->v14_vlrmul ";
       $virgula = ",";
       if($this->v14_vlrmul == null ){ 
         $this->erro_sql = " Campo valor da multa nao Informado.";
         $this->erro_campo = "v14_vlrmul";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  v14_certid = $this->v14_certid
 and  v14_coddiv = $this->v14_coddiv
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->v14_certid."-".$this->v14_coddiv;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->v14_certid."-".$this->v14_coddiv;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->v14_certid."-".$this->v14_coddiv;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($v14_certid=null,$v14_coddiv=null) { 
     $this->atualizacampos(true);
     $result = @pg_exec(" delete from certdiv
                    where  v14_certid = $this->v14_certid
, v14_coddiv = $this->v14_coddiv
                    ");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->v14_certid."-".$this->v14_coddiv;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->v14_certid."-".$this->v14_coddiv;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->v14_certid."-".$this->v14_coddiv;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
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
        $this->erro_sql   = "Dados do Grupo nao Encontrado";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $v14_certid=null,$v14_coddiv=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from certdiv ";
     $sql .= "      inner join divida on  divida.v01_coddiv = certdiv.v14_coddiv";
     $sql .= "      inner join certid on  certid.v13_certid = certdiv.v14_certid";
     $sql2 = "";
     if($dbwhere==""){
       if($v14_certid!=null ){
         $sql2 .= " where certdiv.v14_certid = $v14_certid "; 
       } 
       if($v14_coddiv!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " certdiv.v14_coddiv = $v14_coddiv "; 
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
}
?>