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

//MODULO: itbi
//CLASSE DA ENTIDADE itbidadosimovel
class cl_itbidadosimovel { 
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
   var $it22_sequencial = 0; 
   var $it22_itbi = 0; 
   var $it22_setor = null; 
   var $it22_quadra = null; 
   var $it22_lote = null; 
   var $it22_descrlograd = null; 
   var $it22_numero = 0; 
   var $it22_compl = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 it22_sequencial = int4 = Sequencia 
                 it22_itbi = int8 = Número da guia de ITBI 
                 it22_setor = char(4) = Setor 
                 it22_quadra = char(4) = Quadra 
                 it22_lote = char(4) = Lote 
                 it22_descrlograd = varchar(40) = Descrição do logradouro 
                 it22_numero = int8 = Numero 
                 it22_compl = varchar(20) = Complemento 
                 ";
   //funcao construtor da classe 
   function cl_itbidadosimovel() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("itbidadosimovel"); 
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
       $this->it22_sequencial = ($this->it22_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["it22_sequencial"]:$this->it22_sequencial);
       $this->it22_itbi = ($this->it22_itbi == ""?@$GLOBALS["HTTP_POST_VARS"]["it22_itbi"]:$this->it22_itbi);
       $this->it22_setor = ($this->it22_setor == ""?@$GLOBALS["HTTP_POST_VARS"]["it22_setor"]:$this->it22_setor);
       $this->it22_quadra = ($this->it22_quadra == ""?@$GLOBALS["HTTP_POST_VARS"]["it22_quadra"]:$this->it22_quadra);
       $this->it22_lote = ($this->it22_lote == ""?@$GLOBALS["HTTP_POST_VARS"]["it22_lote"]:$this->it22_lote);
       $this->it22_descrlograd = ($this->it22_descrlograd == ""?@$GLOBALS["HTTP_POST_VARS"]["it22_descrlograd"]:$this->it22_descrlograd);
       $this->it22_numero = ($this->it22_numero == ""?@$GLOBALS["HTTP_POST_VARS"]["it22_numero"]:$this->it22_numero);
       $this->it22_compl = ($this->it22_compl == ""?@$GLOBALS["HTTP_POST_VARS"]["it22_compl"]:$this->it22_compl);
     }else{
       $this->it22_sequencial = ($this->it22_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["it22_sequencial"]:$this->it22_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($it22_sequencial){ 
      $this->atualizacampos();
     if($this->it22_itbi == null ){ 
       $this->erro_sql = " Campo Número da guia de ITBI nao Informado.";
       $this->erro_campo = "it22_itbi";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it22_numero == null ){ 
       $this->it22_numero = "0";
     }
     if($it22_sequencial == "" || $it22_sequencial == null ){
       $result = @pg_query("select nextval('itbidadosimovel_it22_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: itbidadosimovel_it22_sequencial_seq do campo: it22_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->it22_sequencial = pg_result($result,0,0); 
     }else{
       $result = @pg_query("select last_value from itbidadosimovel_it22_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $it22_sequencial)){
         $this->erro_sql = " Campo it22_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->it22_sequencial = $it22_sequencial; 
       }
     }
     if(($this->it22_sequencial == null) || ($this->it22_sequencial == "") ){ 
       $this->erro_sql = " Campo it22_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into itbidadosimovel(
                                       it22_sequencial 
                                      ,it22_itbi 
                                      ,it22_setor 
                                      ,it22_quadra 
                                      ,it22_lote 
                                      ,it22_descrlograd 
                                      ,it22_numero 
                                      ,it22_compl 
                       )
                values (
                                $this->it22_sequencial 
                               ,$this->it22_itbi 
                               ,'$this->it22_setor' 
                               ,'$this->it22_quadra' 
                               ,'$this->it22_lote' 
                               ,'$this->it22_descrlograd' 
                               ,$this->it22_numero 
                               ,'$this->it22_compl' 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Dados do imovel ($this->it22_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Dados do imovel já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Dados do imovel ($this->it22_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->it22_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->it22_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,9001,'$this->it22_sequencial','I')");
       $resac = pg_query("insert into db_acount values($acount,1540,9001,'','".AddSlashes(pg_result($resaco,0,'it22_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1540,9002,'','".AddSlashes(pg_result($resaco,0,'it22_itbi'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1540,9003,'','".AddSlashes(pg_result($resaco,0,'it22_setor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1540,9004,'','".AddSlashes(pg_result($resaco,0,'it22_quadra'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1540,9005,'','".AddSlashes(pg_result($resaco,0,'it22_lote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1540,9006,'','".AddSlashes(pg_result($resaco,0,'it22_descrlograd'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1540,9007,'','".AddSlashes(pg_result($resaco,0,'it22_numero'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1540,9008,'','".AddSlashes(pg_result($resaco,0,'it22_compl'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($it22_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update itbidadosimovel set ";
     $virgula = "";
     if(trim($this->it22_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it22_sequencial"])){ 
       $sql  .= $virgula." it22_sequencial = $this->it22_sequencial ";
       $virgula = ",";
       if(trim($this->it22_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencia nao Informado.";
         $this->erro_campo = "it22_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it22_itbi)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it22_itbi"])){ 
       $sql  .= $virgula." it22_itbi = $this->it22_itbi ";
       $virgula = ",";
       if(trim($this->it22_itbi) == null ){ 
         $this->erro_sql = " Campo Número da guia de ITBI nao Informado.";
         $this->erro_campo = "it22_itbi";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it22_setor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it22_setor"])){ 
       $sql  .= $virgula." it22_setor = '$this->it22_setor' ";
       $virgula = ",";
     }
     if(trim($this->it22_quadra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it22_quadra"])){ 
       $sql  .= $virgula." it22_quadra = '$this->it22_quadra' ";
       $virgula = ",";
     }
     if(trim($this->it22_lote)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it22_lote"])){ 
       $sql  .= $virgula." it22_lote = '$this->it22_lote' ";
       $virgula = ",";
     }
     if(trim($this->it22_descrlograd)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it22_descrlograd"])){ 
       $sql  .= $virgula." it22_descrlograd = '$this->it22_descrlograd' ";
       $virgula = ",";
     }
     if(trim($this->it22_numero)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it22_numero"])){ 
        if(trim($this->it22_numero)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it22_numero"])){ 
           $this->it22_numero = "0" ; 
        } 
       $sql  .= $virgula." it22_numero = $this->it22_numero ";
       $virgula = ",";
     }
     if(trim($this->it22_compl)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it22_compl"])){ 
       $sql  .= $virgula." it22_compl = '$this->it22_compl' ";
       $virgula = ",";
     }
     $sql .= " where ";
     if($it22_sequencial!=null){
       $sql .= " it22_sequencial = $this->it22_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->it22_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,9001,'$this->it22_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it22_sequencial"]))
           $resac = pg_query("insert into db_acount values($acount,1540,9001,'".AddSlashes(pg_result($resaco,$conresaco,'it22_sequencial'))."','$this->it22_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it22_itbi"]))
           $resac = pg_query("insert into db_acount values($acount,1540,9002,'".AddSlashes(pg_result($resaco,$conresaco,'it22_itbi'))."','$this->it22_itbi',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it22_setor"]))
           $resac = pg_query("insert into db_acount values($acount,1540,9003,'".AddSlashes(pg_result($resaco,$conresaco,'it22_setor'))."','$this->it22_setor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it22_quadra"]))
           $resac = pg_query("insert into db_acount values($acount,1540,9004,'".AddSlashes(pg_result($resaco,$conresaco,'it22_quadra'))."','$this->it22_quadra',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it22_lote"]))
           $resac = pg_query("insert into db_acount values($acount,1540,9005,'".AddSlashes(pg_result($resaco,$conresaco,'it22_lote'))."','$this->it22_lote',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it22_descrlograd"]))
           $resac = pg_query("insert into db_acount values($acount,1540,9006,'".AddSlashes(pg_result($resaco,$conresaco,'it22_descrlograd'))."','$this->it22_descrlograd',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it22_numero"]))
           $resac = pg_query("insert into db_acount values($acount,1540,9007,'".AddSlashes(pg_result($resaco,$conresaco,'it22_numero'))."','$this->it22_numero',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it22_compl"]))
           $resac = pg_query("insert into db_acount values($acount,1540,9008,'".AddSlashes(pg_result($resaco,$conresaco,'it22_compl'))."','$this->it22_compl',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Dados do imovel nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->it22_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Dados do imovel nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->it22_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->it22_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($it22_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($it22_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,9001,'$it22_sequencial','E')");
         $resac = pg_query("insert into db_acount values($acount,1540,9001,'','".AddSlashes(pg_result($resaco,$iresaco,'it22_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1540,9002,'','".AddSlashes(pg_result($resaco,$iresaco,'it22_itbi'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1540,9003,'','".AddSlashes(pg_result($resaco,$iresaco,'it22_setor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1540,9004,'','".AddSlashes(pg_result($resaco,$iresaco,'it22_quadra'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1540,9005,'','".AddSlashes(pg_result($resaco,$iresaco,'it22_lote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1540,9006,'','".AddSlashes(pg_result($resaco,$iresaco,'it22_descrlograd'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1540,9007,'','".AddSlashes(pg_result($resaco,$iresaco,'it22_numero'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1540,9008,'','".AddSlashes(pg_result($resaco,$iresaco,'it22_compl'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from itbidadosimovel
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($it22_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " it22_sequencial = $it22_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Dados do imovel nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$it22_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Dados do imovel nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$it22_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$it22_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:itbidadosimovel";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $it22_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from itbidadosimovel ";
     $sql .= "      inner join itbi  on  itbi.it01_guia = itbidadosimovel.it22_itbi";
     $sql .= "      inner join itbitransacao  on  itbitransacao.it04_codigo = itbi.it01_tipotransacao";
     $sql2 = "";
     if($dbwhere==""){
       if($it22_sequencial!=null ){
         $sql2 .= " where itbidadosimovel.it22_sequencial = $it22_sequencial "; 
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
   function sql_query_file ( $it22_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from itbidadosimovel ";
     $sql2 = "";
     if($dbwhere==""){
       if($it22_sequencial!=null ){
         $sql2 .= " where itbidadosimovel.it22_sequencial = $it22_sequencial "; 
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