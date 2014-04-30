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

//MODULO: protocolo
//CLASSE DA ENTIDADE arqproc
class cl_arqproc { 
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
   var $p68_codarquiv = 0; 
   var $p68_codproc = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 p68_codarquiv = int8 = Código do Arquivamento 
                 p68_codproc = int8 = Código do Processo 
                 ";
   //funcao construtor da classe 
   function cl_arqproc() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("arqproc"); 
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
       $this->p68_codarquiv = ($this->p68_codarquiv == ""?@$GLOBALS["HTTP_POST_VARS"]["p68_codarquiv"]:$this->p68_codarquiv);
       $this->p68_codproc = ($this->p68_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["p68_codproc"]:$this->p68_codproc);
     }else{
       $this->p68_codarquiv = ($this->p68_codarquiv == ""?@$GLOBALS["HTTP_POST_VARS"]["p68_codarquiv"]:$this->p68_codarquiv);
       $this->p68_codproc = ($this->p68_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["p68_codproc"]:$this->p68_codproc);
     }
   }
   // funcao para inclusao
   function incluir ($p68_codarquiv,$p68_codproc){ 
      $this->atualizacampos();
       $this->p68_codarquiv = $p68_codarquiv; 
       $this->p68_codproc = $p68_codproc; 
     if(($this->p68_codarquiv == null) || ($this->p68_codarquiv == "") ){ 
       $this->erro_sql = " Campo p68_codarquiv nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->p68_codproc == null) || ($this->p68_codproc == "") ){ 
       $this->erro_sql = " Campo p68_codproc nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into arqproc(
                                       p68_codarquiv 
                                      ,p68_codproc 
                       )
                values (
                                $this->p68_codarquiv 
                               ,$this->p68_codproc 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Reabertrura de Processos ($this->p68_codarquiv."-".$this->p68_codproc) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Reabertrura de Processos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Reabertrura de Processos ($this->p68_codarquiv."-".$this->p68_codproc) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p68_codarquiv."-".$this->p68_codproc;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $resaco = $this->sql_record($this->sql_query_file($this->p68_codarquiv,$this->p68_codproc));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,2499,'$this->p68_codproc','I')");
       $resac = pg_query("insert into db_acountkey values($acount,2500,'$this->p68_codarquiv','I')");
       $resac = pg_query("insert into db_acount values($acount,415,2500,'','".pg_result($resaco,0,'p68_codarquiv')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,415,2499,'','".pg_result($resaco,0,'p68_codproc')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($p68_codarquiv=null,$p68_codproc=null) { 
      $this->atualizacampos();
     $sql = " update arqproc set ";
     $virgula = "";
     if($this->p68_codarquiv!="" || isset($GLOBALS["HTTP_POST_VARS"]["p68_codarquiv"])){ 
       $sql  .= $virgula." p68_codarquiv = $this->p68_codarquiv ";
       $virgula = ",";
       if($this->p68_codarquiv == null ){ 
         $this->erro_sql = " Campo Código do Arquivamento nao Informado.";
         $this->erro_campo = "p68_codarquiv";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if($this->p68_codproc!="" || isset($GLOBALS["HTTP_POST_VARS"]["p68_codproc"])){ 
       $sql  .= $virgula." p68_codproc = $this->p68_codproc ";
       $virgula = ",";
       if($this->p68_codproc == null ){ 
         $this->erro_sql = " Campo Código do Processo nao Informado.";
         $this->erro_campo = "p68_codproc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  p68_codarquiv = $this->p68_codarquiv
 and  p68_codproc = $this->p68_codproc
";
     $resaco = $this->sql_record($this->sql_query_file($this->p68_codarquiv,$this->p68_codproc));
     if($this->numrows>0){       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,2499,'$this->p68_codproc','A')");
       $resac = pg_query("insert into db_acountkey values($acount,2500,'$this->p68_codarquiv','A')");
       if(isset($GLOBALS["HTTP_POST_VARS"]["p68_codarquiv"]))
         $resac = pg_query("insert into db_acount values($acount,415,2500,'".pg_result($resaco,0,'p68_codarquiv')."','$this->p68_codarquiv',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["p68_codproc"]))
         $resac = pg_query("insert into db_acount values($acount,415,2499,'".pg_result($resaco,0,'p68_codproc')."','$this->p68_codproc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Reabertrura de Processos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->p68_codarquiv."-".$this->p68_codproc;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Reabertrura de Processos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->p68_codarquiv."-".$this->p68_codproc;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p68_codarquiv."-".$this->p68_codproc;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($p68_codarquiv=null,$p68_codproc=null) { 
     $this->atualizacampos(true);
     $resaco = $this->sql_record($this->sql_query_file($this->p68_codarquiv,$this->p68_codproc));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,2499,'$this->p68_codproc','E')");
       $resac = pg_query("insert into db_acountkey values($acount,2500,'$this->p68_codarquiv','E')");
       $resac = pg_query("insert into db_acount values($acount,415,2500,'','".pg_result($resaco,0,'p68_codarquiv')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,415,2499,'','".pg_result($resaco,0,'p68_codproc')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     $sql = " delete from arqproc
                    where ";
     $sql2 = "";
      if($this->p68_codarquiv != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " p68_codarquiv = $this->p68_codarquiv ";
}
      if($this->p68_codproc != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " p68_codproc = $this->p68_codproc ";
}
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Reabertrura de Processos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->p68_codarquiv."-".$this->p68_codproc;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Reabertrura de Processos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->p68_codarquiv."-".$this->p68_codproc;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p68_codarquiv."-".$this->p68_codproc;
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
   function sql_query ( $p68_codarquiv=null,$p68_codproc=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from arqproc ";
     $sql .= "      inner join protprocesso  on  protprocesso.p58_codproc = arqproc.p68_codproc";
     $sql .= "      inner join procarquiv  on  procarquiv.p67_codarquiv = arqproc.p68_codarquiv";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = protprocesso.p58_numcgm";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protprocesso.p58_id_usuario";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = protprocesso.p58_coddepto";
     $sql .= "      inner join tipoproc  on  tipoproc.p51_codigo = protprocesso.p58_codigo";
     $sql .= "      inner join protprocesso  on  protprocesso.p58_codproc = procarquiv.p67_codproc";
     $sql2 = "";
     if($dbwhere==""){
       if($p68_codarquiv!=null ){
         $sql2 .= " where arqproc.p68_codarquiv = $p68_codarquiv "; 
       } 
       if($p68_codproc!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " arqproc.p68_codproc = $p68_codproc "; 
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
   function sql_query_file ( $p68_codarquiv=null,$p68_codproc=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from arqproc ";
     $sql2 = "";
     if($dbwhere==""){
       if($p68_codarquiv!=null ){
         $sql2 .= " where arqproc.p68_codarquiv = $p68_codarquiv "; 
       } 
       if($p68_codproc!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " arqproc.p68_codproc = $p68_codproc "; 
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