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
//CLASSE DA ENTIDADE notificacao
class cl_notificacao { 
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
   var $k50_notifica = 0; 
   var $k50_procede = 0; 
   var $k50_dtemite_dia = null; 
   var $k50_dtemite_mes = null; 
   var $k50_dtemite_ano = null; 
   var $k50_dtemite = null; 
   var $k50_obs = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 k50_notifica = int4 = Notificação 
                 k50_procede = int4 = Procedência 
                 k50_dtemite = date = Data Emissão 
                 k50_obs = text = Observação 
                 ";
   //funcao construtor da classe 
   function cl_notificacao() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("notificacao"); 
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
       $this->k50_notifica = ($this->k50_notifica == ""?@$GLOBALS["HTTP_POST_VARS"]["k50_notifica"]:$this->k50_notifica);
       $this->k50_procede = ($this->k50_procede == ""?@$GLOBALS["HTTP_POST_VARS"]["k50_procede"]:$this->k50_procede);
       if($this->k50_dtemite == ""){
         $this->k50_dtemite_dia = @$GLOBALS["HTTP_POST_VARS"]["k50_dtemite_dia"];
         $this->k50_dtemite_mes = @$GLOBALS["HTTP_POST_VARS"]["k50_dtemite_mes"];
         $this->k50_dtemite_ano = @$GLOBALS["HTTP_POST_VARS"]["k50_dtemite_ano"];
         if($this->k50_dtemite_dia != ""){
            $this->k50_dtemite = $this->k50_dtemite_ano."-".$this->k50_dtemite_mes."-".$this->k50_dtemite_dia;
         }
       }
       $this->k50_obs = ($this->k50_obs == ""?@$GLOBALS["HTTP_POST_VARS"]["k50_obs"]:$this->k50_obs);
     }else{
       $this->k50_notifica = ($this->k50_notifica == ""?@$GLOBALS["HTTP_POST_VARS"]["k50_notifica"]:$this->k50_notifica);
     }
   }
   // funcao para inclusao
   function incluir ($k50_notifica){ 
      $this->atualizacampos();
     if($this->k50_procede == null ){ 
       $this->erro_sql = " Campo Procedência nao Informado.";
       $this->erro_campo = "k50_procede";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k50_dtemite == null ){ 
       $this->erro_sql = " Campo Data Emissão nao Informado.";
       $this->erro_campo = "k50_dtemite_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($k50_notifica == "" || $k50_notifica == null ){
       $result = @pg_query("select nextval('notificacao_k50_notifica_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: notificacao_k50_notifica_seq do campo: k50_notifica"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->k50_notifica = pg_result($result,0,0); 
     }else{
       $result = @pg_query("select last_value from notificacao_k50_notifica_seq");
       if(($result != false) && (pg_result($result,0,0) < $k50_notifica)){
         $this->erro_sql = " Campo k50_notifica maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->k50_notifica = $k50_notifica; 
       }
     }
     if(($this->k50_notifica == null) || ($this->k50_notifica == "") ){ 
       $this->erro_sql = " Campo k50_notifica nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into notificacao(
                                       k50_notifica 
                                      ,k50_procede 
                                      ,k50_dtemite 
                                      ,k50_obs 
                       )
                values (
                                $this->k50_notifica 
                               ,$this->k50_procede 
                               ,".($this->k50_dtemite == "null" || $this->k50_dtemite == ""?"null":"'".$this->k50_dtemite."'")." 
                               ,'$this->k50_obs' 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Notificação de Débitos ($this->k50_notifica) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Notificação de Débitos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Notificação de Débitos ($this->k50_notifica) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k50_notifica;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $resaco = $this->sql_record($this->sql_query_file($this->k50_notifica));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,4703,'$this->k50_notifica','I')");
       $resac = pg_query("insert into db_acount values($acount,621,4703,'','".pg_result($resaco,0,'k50_notifica')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,621,4704,'','".pg_result($resaco,0,'k50_procede')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,621,4705,'','".pg_result($resaco,0,'k50_dtemite')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,621,4706,'','".pg_result($resaco,0,'k50_obs')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($k50_notifica=null) { 
      $this->atualizacampos();
     $sql = " update notificacao set ";
     $virgula = "";
     if(trim($this->k50_notifica)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k50_notifica"])){ 
        if(trim($this->k50_notifica)=="" && isset($GLOBALS["HTTP_POST_VARS"]["k50_notifica"])){ 
           $this->k50_notifica = "0" ; 
        } 
       $sql  .= $virgula." k50_notifica = $this->k50_notifica ";
       $virgula = ",";
       if(trim($this->k50_notifica) == null ){ 
         $this->erro_sql = " Campo Notificação nao Informado.";
         $this->erro_campo = "k50_notifica";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k50_procede)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k50_procede"])){ 
        if(trim($this->k50_procede)=="" && isset($GLOBALS["HTTP_POST_VARS"]["k50_procede"])){ 
           $this->k50_procede = "0" ; 
        } 
       $sql  .= $virgula." k50_procede = $this->k50_procede ";
       $virgula = ",";
       if(trim($this->k50_procede) == null ){ 
         $this->erro_sql = " Campo Procedência nao Informado.";
         $this->erro_campo = "k50_procede";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k50_dtemite)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k50_dtemite_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k50_dtemite_dia"] !="") ){ 
       $sql  .= $virgula." k50_dtemite = '$this->k50_dtemite' ";
       $virgula = ",";
       if(trim($this->k50_dtemite) == null ){ 
         $this->erro_sql = " Campo Data Emissão nao Informado.";
         $this->erro_campo = "k50_dtemite_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["k50_dtemite_dia"])){ 
         $sql  .= $virgula." k50_dtemite = null ";
         $virgula = ",";
         if(trim($this->k50_dtemite) == null ){ 
           $this->erro_sql = " Campo Data Emissão nao Informado.";
           $this->erro_campo = "k50_dtemite_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->k50_obs)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k50_obs"])){ 
       $sql  .= $virgula." k50_obs = '$this->k50_obs' ";
       $virgula = ",";
     }
     $sql .= " where  k50_notifica = $this->k50_notifica
";
     $resaco = $this->sql_record($this->sql_query_file($this->k50_notifica));
     if($this->numrows>0){       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,4703,'$this->k50_notifica','A')");
       if(isset($GLOBALS["HTTP_POST_VARS"]["k50_notifica"]))
         $resac = pg_query("insert into db_acount values($acount,621,4703,'".pg_result($resaco,0,'k50_notifica')."','$this->k50_notifica',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["k50_procede"]))
         $resac = pg_query("insert into db_acount values($acount,621,4704,'".pg_result($resaco,0,'k50_procede')."','$this->k50_procede',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["k50_dtemite"]))
         $resac = pg_query("insert into db_acount values($acount,621,4705,'".pg_result($resaco,0,'k50_dtemite')."','$this->k50_dtemite',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["k50_obs"]))
         $resac = pg_query("insert into db_acount values($acount,621,4706,'".pg_result($resaco,0,'k50_obs')."','$this->k50_obs',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Notificação de Débitos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->k50_notifica;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Notificação de Débitos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->k50_notifica;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k50_notifica;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($k50_notifica=null) { 
     $this->atualizacampos(true);
     $resaco = $this->sql_record($this->sql_query_file($this->k50_notifica));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,4703,'".pg_result($resaco,$iresaco,'k50_notifica')."','E')");
       $resac = pg_query("insert into db_acount values($acount,621,4703,'','".pg_result($resaco,0,'k50_notifica')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,621,4704,'','".pg_result($resaco,0,'k50_procede')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,621,4705,'','".pg_result($resaco,0,'k50_dtemite')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,621,4706,'','".pg_result($resaco,0,'k50_obs')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     $sql = " delete from notificacao
                    where ";
     $sql2 = "";
      if($this->k50_notifica != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " k50_notifica = $this->k50_notifica ";
}
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Notificação de Débitos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->k50_notifica;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Notificação de Débitos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->k50_notifica;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k50_notifica;
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
   function sql_query ( $k50_notifica=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from notificacao ";
     $sql .= "      inner join notitipo  on  notitipo.k51_procede = notificacao.k50_procede";
     $sql .= "      left outer join notiusu on notificacao.k50_notifica = notiusu.k52_notifica";
     $sql .= "      left outer join notimatric on notificacao.k50_notifica = notimatric.k55_notifica";
     $sql .= "      left outer join notiinscr on notificacao.k50_notifica = notiinscr.k56_notifica";
     $sql .= "      left outer join notinumcgm on notificacao.k50_notifica = notinumcgm.k57_notifica";
     $sql .= "      left outer join noticonf on notificacao.k50_notifica = noticonf.k54_notifica";
     $sql2 = "";
     if($dbwhere==""){
       if($k50_notifica!=null ){
         $sql2 .= " where notificacao.k50_notifica = $k50_notifica "; 
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
   function sql_query_file ( $k50_notifica=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from notificacao ";
     $sql2 = "";
     if($dbwhere==""){
       if($k50_notifica!=null ){
         $sql2 .= " where notificacao.k50_notifica = $k50_notifica "; 
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
   function sql_noticontri ( $d08_contri=null,$d08_matric=null,$d08_notif=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from contrinot ";
     $sql .= "      inner join contricalc on  contricalc.d09_contri = contrinot.d08_contri and  contricalc.d09_matric = contrinot.d08_matric";
     $sql .= "      inner join notificacao on  notificacao.k50_notifica = contrinot.d08_notif";
     $sql .= "      inner join contrib  on  contrib.d07_contri = contricalc.d09_contri and  contrib.d07_matric = contricalc.d09_matric";
     $sql .= "      inner join editalrua on   editalrua.d02_contri = contricalc.d09_contri ";
     $sql .= "      inner join edital on   editalrua.d02_codedi = edital.d01_codedi ";
     $sql .= "      inner join ruas on   editalrua.d02_codigo = ruas.j14_codigo ";
     $sql .= "      inner join notitipo  on  notitipo.k51_procede = notificacao.k50_procede";
     $sql .= "      inner join proprietario on proprietario.j01_matric = contrib.d07_matric ";
     $sql2 = "";
     if($dbwhere==""){
       if($d08_contri!=null ){
         $sql2 .= " where contrinot.d08_contri = $d08_contri ";
       }
       if($d08_matric!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         }
         $sql2 .= " contrinot.d08_matric = $d08_matric ";
       }
       if($d08_notif!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         }
         $sql2 .= " contrinot.d08_notif = $d08_notif ";
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
   function sql_query_nome( $k50_notifica=null,$dbwhere="",$ordem=null){
$sql = "select k50_notifica,";
$sql .= "           k50_procede, ";
$sql .= "           k50_dtemite, ";
$sql .= "           k50_obs, ";
$sql .= "           k55_matric, ";
$sql .= "           k56_inscr, ";
$sql .= "           k57_numcgm, ";
$sql .= "          substr(z01_nome,1,6)::integer as z01_numcgm, ";
$sql .= "          substr(z01_nome,8,40)::varchar(40) as z01_nome ";
$sql .= "from ( ";
$sql .= "select notificacao.*, ";
$sql .= "       k55_matric, ";
$sql .= "       k56_inscr, ";
$sql .= "       k57_numcgm, ";
$sql .= "       case when k55_matric is not null ";
$sql .= "            then (select lpad(z01_numcgm,6,0)||' '||z01_nome ";
$sql .= "                  from proprietario_nome ";
$sql .= "                  where j01_matric = k55_matric limit 1) ";
$sql .= "            else case when k56_inscr is not null ";
$sql .= "                      then (select lpad(q02_numcgm,6,0)||' '||z01_nome ";
$sql .= "                            from empresa ";
$sql .= "                            where q02_inscr = k56_inscr limit 1) ";
$sql .= "                 else (select lpad(z01_numcgm,6,0)||' '||z01_nome ";
$sql .= "                       from cgm ";
$sql .= "                       where z01_numcgm = k57_numcgm) ";
$sql .= "                 end";
$sql .= "        end as z01_nome ";
$sql .= "from notificacao ";
$sql .= "     left outer join notimatric on k50_notifica = k55_notifica ";
$sql .= "     left join notiinscr on k50_notifica = k56_notifica ";
$sql .= "     left join notinumcgm on k50_notifica = k57_notifica) as x ";
$sql2 = "";

     if($dbwhere==""){
       if($k50_notifica!=null ){
         $sql2 .= " where k50_notifica = $k50_notifica ";
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