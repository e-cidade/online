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

//MODULO: caixa
//CLASSE DA ENTIDADE cancdebitosproc
class cl_cancdebitosproc { 
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
   var $k23_codigo = 0; 
   var $k23_data_dia = null; 
   var $k23_data_mes = null; 
   var $k23_data_ano = null; 
   var $k23_data = null; 
   var $k23_hora = null; 
   var $k23_usuario = 0; 
   var $k23_obs = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 k23_codigo = int8 = Código 
                 k23_data = date = Data 
                 k23_hora = varchar(5) = Hora 
                 k23_usuario = int4 = Cod. Usuário 
                 k23_obs = text = Observação 
                 ";
   //funcao construtor da classe 
   function cl_cancdebitosproc() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("cancdebitosproc"); 
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
       $this->k23_codigo = ($this->k23_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["k23_codigo"]:$this->k23_codigo);
       if($this->k23_data == ""){
         $this->k23_data_dia = ($this->k23_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k23_data_dia"]:$this->k23_data_dia);
         $this->k23_data_mes = ($this->k23_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k23_data_mes"]:$this->k23_data_mes);
         $this->k23_data_ano = ($this->k23_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k23_data_ano"]:$this->k23_data_ano);
         if($this->k23_data_dia != ""){
            $this->k23_data = $this->k23_data_ano."-".$this->k23_data_mes."-".$this->k23_data_dia;
         }
       }
       $this->k23_hora = ($this->k23_hora == ""?@$GLOBALS["HTTP_POST_VARS"]["k23_hora"]:$this->k23_hora);
       $this->k23_usuario = ($this->k23_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["k23_usuario"]:$this->k23_usuario);
       $this->k23_obs = ($this->k23_obs == ""?@$GLOBALS["HTTP_POST_VARS"]["k23_obs"]:$this->k23_obs);
     }else{
       $this->k23_codigo = ($this->k23_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["k23_codigo"]:$this->k23_codigo);
     }
   }
   // funcao para inclusao
   function incluir ($k23_codigo){ 
      $this->atualizacampos();
     if($this->k23_data == null ){ 
       $this->erro_sql = " Campo Data nao Informado.";
       $this->erro_campo = "k23_data_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k23_hora == null ){ 
       $this->erro_sql = " Campo Hora nao Informado.";
       $this->erro_campo = "k23_hora";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k23_usuario == null ){ 
       $this->erro_sql = " Campo Cod. Usuário nao Informado.";
       $this->erro_campo = "k23_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($k23_codigo == "" || $k23_codigo == null ){
       $result = @pg_query("select nextval('cancdebitosproc_k23_codigo_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: cancdebitosproc_k23_codigo_seq do campo: k23_codigo"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->k23_codigo = pg_result($result,0,0); 
     }else{
       $result = @pg_query("select last_value from cancdebitosproc_k23_codigo_seq");
       if(($result != false) && (pg_result($result,0,0) < $k23_codigo)){
         $this->erro_sql = " Campo k23_codigo maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->k23_codigo = $k23_codigo; 
       }
     }
     if(($this->k23_codigo == null) || ($this->k23_codigo == "") ){ 
       $this->erro_sql = " Campo k23_codigo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into cancdebitosproc(
                                       k23_codigo 
                                      ,k23_data 
                                      ,k23_hora 
                                      ,k23_usuario 
                                      ,k23_obs 
                       )
                values (
                                $this->k23_codigo 
                               ,".($this->k23_data == "null" || $this->k23_data == ""?"null":"'".$this->k23_data."'")." 
                               ,'$this->k23_hora' 
                               ,$this->k23_usuario 
                               ,'$this->k23_obs' 
                      )";
     //echo "<br> $sql";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Processamento dos Debitos Cancelados ($this->k23_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Processamento dos Debitos Cancelados já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Processamento dos Debitos Cancelados ($this->k23_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k23_codigo;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->k23_codigo));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,7405,'$this->k23_codigo','I')");
       $resac = pg_query("insert into db_acount values($acount,1233,7405,'','".AddSlashes(pg_result($resaco,0,'k23_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1233,7406,'','".AddSlashes(pg_result($resaco,0,'k23_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1233,7407,'','".AddSlashes(pg_result($resaco,0,'k23_hora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1233,7408,'','".AddSlashes(pg_result($resaco,0,'k23_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1233,7409,'','".AddSlashes(pg_result($resaco,0,'k23_obs'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($k23_codigo=null) { 
      $this->atualizacampos();
     $sql = " update cancdebitosproc set ";
     $virgula = "";
     if(trim($this->k23_codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k23_codigo"])){ 
       $sql  .= $virgula." k23_codigo = $this->k23_codigo ";
       $virgula = ",";
       if(trim($this->k23_codigo) == null ){ 
         $this->erro_sql = " Campo Código nao Informado.";
         $this->erro_campo = "k23_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k23_data)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k23_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k23_data_dia"] !="") ){ 
       $sql  .= $virgula." k23_data = '$this->k23_data' ";
       $virgula = ",";
       if(trim($this->k23_data) == null ){ 
         $this->erro_sql = " Campo Data nao Informado.";
         $this->erro_campo = "k23_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["k23_data_dia"])){ 
         $sql  .= $virgula." k23_data = null ";
         $virgula = ",";
         if(trim($this->k23_data) == null ){ 
           $this->erro_sql = " Campo Data nao Informado.";
           $this->erro_campo = "k23_data_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->k23_hora)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k23_hora"])){ 
       $sql  .= $virgula." k23_hora = '$this->k23_hora' ";
       $virgula = ",";
       if(trim($this->k23_hora) == null ){ 
         $this->erro_sql = " Campo Hora nao Informado.";
         $this->erro_campo = "k23_hora";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k23_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k23_usuario"])){ 
       $sql  .= $virgula." k23_usuario = $this->k23_usuario ";
       $virgula = ",";
       if(trim($this->k23_usuario) == null ){ 
         $this->erro_sql = " Campo Cod. Usuário nao Informado.";
         $this->erro_campo = "k23_usuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k23_obs)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k23_obs"])){ 
       $sql  .= $virgula." k23_obs = '$this->k23_obs' ";
       $virgula = ",";
     }
     $sql .= " where ";
     if($k23_codigo!=null){
       $sql .= " k23_codigo = $this->k23_codigo";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->k23_codigo));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,7405,'$this->k23_codigo','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k23_codigo"]))
           $resac = pg_query("insert into db_acount values($acount,1233,7405,'".AddSlashes(pg_result($resaco,$conresaco,'k23_codigo'))."','$this->k23_codigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k23_data"]))
           $resac = pg_query("insert into db_acount values($acount,1233,7406,'".AddSlashes(pg_result($resaco,$conresaco,'k23_data'))."','$this->k23_data',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k23_hora"]))
           $resac = pg_query("insert into db_acount values($acount,1233,7407,'".AddSlashes(pg_result($resaco,$conresaco,'k23_hora'))."','$this->k23_hora',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k23_usuario"]))
           $resac = pg_query("insert into db_acount values($acount,1233,7408,'".AddSlashes(pg_result($resaco,$conresaco,'k23_usuario'))."','$this->k23_usuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k23_obs"]))
           $resac = pg_query("insert into db_acount values($acount,1233,7409,'".AddSlashes(pg_result($resaco,$conresaco,'k23_obs'))."','$this->k23_obs',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Processamento dos Debitos Cancelados nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->k23_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Processamento dos Debitos Cancelados nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->k23_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k23_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($k23_codigo=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($k23_codigo));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,7405,'$k23_codigo','E')");
         $resac = pg_query("insert into db_acount values($acount,1233,7405,'','".AddSlashes(pg_result($resaco,$iresaco,'k23_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1233,7406,'','".AddSlashes(pg_result($resaco,$iresaco,'k23_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1233,7407,'','".AddSlashes(pg_result($resaco,$iresaco,'k23_hora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1233,7408,'','".AddSlashes(pg_result($resaco,$iresaco,'k23_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1233,7409,'','".AddSlashes(pg_result($resaco,$iresaco,'k23_obs'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from cancdebitosproc
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($k23_codigo != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " k23_codigo = $k23_codigo ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Processamento dos Debitos Cancelados nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$k23_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Processamento dos Debitos Cancelados nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$k23_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$k23_codigo;
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
        $this->erro_sql   = "Record Vazio na Tabela:cancdebitosproc";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $k23_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from cancdebitosproc ";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = cancdebitosproc.k23_usuario";
     $sql2 = "";
     if($dbwhere==""){
       if($k23_codigo!=null ){
         $sql2 .= " where cancdebitosproc.k23_codigo = $k23_codigo "; 
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
   function sql_query_file ( $k23_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from cancdebitosproc ";
     $sql2 = "";
     if($dbwhere==""){
       if($k23_codigo!=null ){
         $sql2 .= " where cancdebitosproc.k23_codigo = $k23_codigo "; 
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