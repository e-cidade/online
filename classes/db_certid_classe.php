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

//MODULO: dividaativa
//CLASSE DA ENTIDADE certid
class cl_certid { 
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
   var $v13_certid = 0; 
   var $v13_dtemis_dia = null; 
   var $v13_dtemis_mes = null; 
   var $v13_dtemis_ano = null; 
   var $v13_dtemis = null; 
   var $v13_memo = 0; 
   var $v13_login = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 v13_certid = int4 = certidao 
                 v13_dtemis = date = data de emissao 
                 v13_memo = oid = texto da certidao 
                 v13_login = varchar(8) = login do usuario 
                 ";
   //funcao construtor da classe 
   function cl_certid() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("certid"); 
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
       $this->v13_certid = ($this->v13_certid == ""?@$GLOBALS["HTTP_POST_VARS"]["v13_certid"]:$this->v13_certid);
       if($this->v13_dtemis == ""){
         $this->v13_dtemis_dia = ($this->v13_dtemis_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["v13_dtemis_dia"]:$this->v13_dtemis_dia);
         $this->v13_dtemis_mes = ($this->v13_dtemis_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["v13_dtemis_mes"]:$this->v13_dtemis_mes);
         $this->v13_dtemis_ano = ($this->v13_dtemis_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["v13_dtemis_ano"]:$this->v13_dtemis_ano);
         if($this->v13_dtemis_dia != ""){
            $this->v13_dtemis = $this->v13_dtemis_ano."-".$this->v13_dtemis_mes."-".$this->v13_dtemis_dia;
         }
       }
       $this->v13_memo = ($this->v13_memo == ""?@$GLOBALS["HTTP_POST_VARS"]["v13_memo"]:$this->v13_memo);
       $this->v13_login = ($this->v13_login == ""?@$GLOBALS["HTTP_POST_VARS"]["v13_login"]:$this->v13_login);
     }else{
       $this->v13_certid = ($this->v13_certid == ""?@$GLOBALS["HTTP_POST_VARS"]["v13_certid"]:$this->v13_certid);
     }
   }
   // funcao para inclusao
   function incluir ($v13_certid){ 
      $this->atualizacampos();
     if($this->v13_dtemis == null ){ 
       $this->erro_sql = " Campo data de emissao nao Informado.";
       $this->erro_campo = "v13_dtemis_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v13_memo == null ){ 
       $this->erro_sql = " Campo texto da certidao nao Informado.";
       $this->erro_campo = "v13_memo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v13_login == null ){ 
       $this->erro_sql = " Campo login do usuario nao Informado.";
       $this->erro_campo = "v13_login";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->v13_certid = $v13_certid; 
     if(($this->v13_certid == null) || ($this->v13_certid == "") ){ 
       $this->erro_sql = " Campo v13_certid nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into certid(
                                       v13_certid 
                                      ,v13_dtemis 
                                      ,v13_memo 
                                      ,v13_login 
                       )
                values (
                                $this->v13_certid 
                               ,".($this->v13_dtemis == "null" || $this->v13_dtemis == ""?"null":"'".$this->v13_dtemis."'")." 
                               ,$this->v13_memo 
                               ,'$this->v13_login' 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = " ($this->v13_certid) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = " já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = " ($this->v13_certid) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->v13_certid;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->v13_certid));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,527,'$this->v13_certid','I')");
       $resac = pg_query("insert into db_acount values($acount,100,527,'','".AddSlashes(pg_result($resaco,0,'v13_certid'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,100,528,'','".AddSlashes(pg_result($resaco,0,'v13_dtemis'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,100,529,'','".AddSlashes(pg_result($resaco,0,'v13_memo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,100,530,'','".AddSlashes(pg_result($resaco,0,'v13_login'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($v13_certid=null) { 
      $this->atualizacampos();
     $sql = " update certid set ";
     $virgula = "";
     if(trim($this->v13_certid)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v13_certid"])){ 
       $sql  .= $virgula." v13_certid = $this->v13_certid ";
       $virgula = ",";
       if(trim($this->v13_certid) == null ){ 
         $this->erro_sql = " Campo certidao nao Informado.";
         $this->erro_campo = "v13_certid";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->v13_dtemis)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v13_dtemis_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["v13_dtemis_dia"] !="") ){ 
       $sql  .= $virgula." v13_dtemis = '$this->v13_dtemis' ";
       $virgula = ",";
       if(trim($this->v13_dtemis) == null ){ 
         $this->erro_sql = " Campo data de emissao nao Informado.";
         $this->erro_campo = "v13_dtemis_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["v13_dtemis_dia"])){ 
         $sql  .= $virgula." v13_dtemis = null ";
         $virgula = ",";
         if(trim($this->v13_dtemis) == null ){ 
           $this->erro_sql = " Campo data de emissao nao Informado.";
           $this->erro_campo = "v13_dtemis_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->v13_memo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v13_memo"])){ 
       $sql  .= $virgula." v13_memo = $this->v13_memo ";
       $virgula = ",";
       if(trim($this->v13_memo) == null ){ 
         $this->erro_sql = " Campo texto da certidao nao Informado.";
         $this->erro_campo = "v13_memo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->v13_login)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v13_login"])){ 
       $sql  .= $virgula." v13_login = '$this->v13_login' ";
       $virgula = ",";
       if(trim($this->v13_login) == null ){ 
         $this->erro_sql = " Campo login do usuario nao Informado.";
         $this->erro_campo = "v13_login";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($v13_certid!=null){
       $sql .= " v13_certid = $this->v13_certid";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->v13_certid));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,527,'$this->v13_certid','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["v13_certid"]))
           $resac = pg_query("insert into db_acount values($acount,100,527,'".AddSlashes(pg_result($resaco,$conresaco,'v13_certid'))."','$this->v13_certid',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["v13_dtemis"]))
           $resac = pg_query("insert into db_acount values($acount,100,528,'".AddSlashes(pg_result($resaco,$conresaco,'v13_dtemis'))."','$this->v13_dtemis',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["v13_memo"]))
           $resac = pg_query("insert into db_acount values($acount,100,529,'".AddSlashes(pg_result($resaco,$conresaco,'v13_memo'))."','$this->v13_memo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["v13_login"]))
           $resac = pg_query("insert into db_acount values($acount,100,530,'".AddSlashes(pg_result($resaco,$conresaco,'v13_login'))."','$this->v13_login',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->v13_certid;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->v13_certid;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->v13_certid;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($v13_certid=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($v13_certid));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,527,'$v13_certid','E')");
         $resac = pg_query("insert into db_acount values($acount,100,527,'','".AddSlashes(pg_result($resaco,$iresaco,'v13_certid'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,100,528,'','".AddSlashes(pg_result($resaco,$iresaco,'v13_dtemis'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,100,529,'','".AddSlashes(pg_result($resaco,$iresaco,'v13_memo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,100,530,'','".AddSlashes(pg_result($resaco,$iresaco,'v13_login'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from certid
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($v13_certid != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " v13_certid = $v13_certid ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$v13_certid;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$v13_certid;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$v13_certid;
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
        $this->erro_sql   = "Record Vazio na Tabela:certid";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $v13_certid=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from certid ";
     $sql2 = "";
     if($dbwhere==""){
       if($v13_certid!=null ){
         $sql2 .= " where certid.v13_certid = $v13_certid "; 
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
   function sql_query_file ( $v13_certid=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from certid ";
     $sql2 = "";
     if($dbwhere==""){
       if($v13_certid!=null ){
         $sql2 .= " where certid.v13_certid = $v13_certid "; 
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



  // funcao do sql 
   function sql_query_ini ( $v13_certid=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from certid ";
     $sql .= "       left join inicialcert on certid.v13_certid=inicialcert.v51_certidao ";
     $sql2 = "";
     if($dbwhere==""){
       if($v13_certid!=null ){
         $sql2 .= " where certid.v13_certid = $v13_certid "; 
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
  function sql_query_tip ( $v13_certid=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from certid ";
     $sql .= "       left join certdiv on certid.v13_certid=certdiv.v14_certid ";
     $sql .= "       left join certter on certid.v13_certid=certter.v14_certid ";
     $sql .= "       left join divida on certdiv.v14_coddiv=divida.v01_coddiv ";
     $sql .= "       left join proced on proced.v03_codigo=divida.v01_proced ";
     $sql2 = "";
     if($dbwhere==""){
       if($v13_certid!=null ){
         $sql2 .= " where certid.v13_certid = $v13_certid "; 
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