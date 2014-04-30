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
//CLASSE DA ENTIDADE saltes
class cl_saltes { 
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
   var $k13_conta = 0; 
   var $k13_saldo = 0; 
   var $k13_ident = null; 
   var $k13_vlratu = 0; 
   var $k13_datvlr_dia = null; 
   var $k13_datvlr_mes = null; 
   var $k13_datvlr_ano = null; 
   var $k13_datvlr = null; 
   var $k13_descr = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 k13_conta = int4 = Código Conta 
                 k13_saldo = float8 = Saldo da Conta 
                 k13_ident = char(15) = Identificacao da conta 
                 k13_vlratu = float8 = Valor Atualizado 
                 k13_datvlr = date = Data Atualização 
                 k13_descr = varchar(40) = Descrição  Conta 
                 ";
   //funcao construtor da classe 
   function cl_saltes() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("saltes"); 
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
       $this->k13_conta = ($this->k13_conta == ""?@$GLOBALS["HTTP_POST_VARS"]["k13_conta"]:$this->k13_conta);
       $this->k13_saldo = ($this->k13_saldo == ""?@$GLOBALS["HTTP_POST_VARS"]["k13_saldo"]:$this->k13_saldo);
       $this->k13_ident = ($this->k13_ident == ""?@$GLOBALS["HTTP_POST_VARS"]["k13_ident"]:$this->k13_ident);
       $this->k13_vlratu = ($this->k13_vlratu == ""?@$GLOBALS["HTTP_POST_VARS"]["k13_vlratu"]:$this->k13_vlratu);
       if($this->k13_datvlr == ""){
         $this->k13_datvlr_dia = @$GLOBALS["HTTP_POST_VARS"]["k13_datvlr_dia"];
         $this->k13_datvlr_mes = @$GLOBALS["HTTP_POST_VARS"]["k13_datvlr_mes"];
         $this->k13_datvlr_ano = @$GLOBALS["HTTP_POST_VARS"]["k13_datvlr_ano"];
         if($this->k13_datvlr_dia != ""){
            $this->k13_datvlr = $this->k13_datvlr_ano."-".$this->k13_datvlr_mes."-".$this->k13_datvlr_dia;
         }
       }
       $this->k13_descr = ($this->k13_descr == ""?@$GLOBALS["HTTP_POST_VARS"]["k13_descr"]:$this->k13_descr);
     }else{
       $this->k13_conta = ($this->k13_conta == ""?@$GLOBALS["HTTP_POST_VARS"]["k13_conta"]:$this->k13_conta);
     }
   }
   // funcao para inclusao
   function incluir ($k13_conta){ 
      $this->atualizacampos();
     if($this->k13_saldo == null ){ 
       $this->erro_sql = " Campo Saldo da Conta nao Informado.";
       $this->erro_campo = "k13_saldo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k13_vlratu == null ){ 
       $this->k13_vlratu = "0";
     }
     if($this->k13_descr == null ){ 
       $this->erro_sql = " Campo Descrição  Conta nao Informado.";
       $this->erro_campo = "k13_descr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->k13_conta = $k13_conta; 
     if(($this->k13_conta == null) || ($this->k13_conta == "") ){ 
       $this->erro_sql = " Campo k13_conta nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into saltes(
                                       k13_conta 
                                      ,k13_saldo 
                                      ,k13_ident 
                                      ,k13_vlratu 
                                      ,k13_datvlr 
                                      ,k13_descr 
                       )
                values (
                                $this->k13_conta 
                               ,$this->k13_saldo 
                               ,'$this->k13_ident' 
                               ,$this->k13_vlratu 
                               ,".($this->k13_datvlr == "null" || $this->k13_datvlr == ""?"null":"'".$this->k13_datvlr."'")." 
                               ,'$this->k13_descr' 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Saldo Tesuoraria ($this->k13_conta) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Saldo Tesuoraria já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Saldo Tesuoraria ($this->k13_conta) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k13_conta;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($k13_conta=null) { 
      $this->atualizacampos();
     $sql = " update saltes set ";
     $virgula = "";
     if(isset($GLOBALS["HTTP_POST_VARS"]["k13_conta"])){ 
       $sql  .= $virgula." k13_conta = $this->k13_conta ";
       $virgula = ",";
       if($this->k13_conta == null ){ 
         $this->erro_sql = " Campo Código Conta nao Informado.";
         $this->erro_campo = "k13_conta";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["k13_saldo"])){ 
       $sql  .= $virgula." k13_saldo = $this->k13_saldo ";
       $virgula = ",";
       if($this->k13_saldo == null ){ 
         $this->erro_sql = " Campo Saldo da Conta nao Informado.";
         $this->erro_campo = "k13_saldo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["k13_ident"])){ 
       $sql  .= $virgula." k13_ident = '$this->k13_ident' ";
       $virgula = ",";
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["k13_vlratu"])){ 
       $sql  .= $virgula." k13_vlratu = $this->k13_vlratu ";
       $virgula = ",";
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["k13_datvlr_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k13_datvlr_dia"] !="") ){ 
       $sql  .= $virgula." k13_datvlr = '$this->k13_datvlr' ";
       $virgula = ",";
     }     else{ 
       $sql  .= $virgula." k13_datvlr = null ";
       $virgula = ",";
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["k13_descr"])){ 
       $sql  .= $virgula." k13_descr = '$this->k13_descr' ";
       $virgula = ",";
       if($this->k13_descr == null ){ 
         $this->erro_sql = " Campo Descrição  Conta nao Informado.";
         $this->erro_campo = "k13_descr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  k13_conta = $this->k13_conta
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Saldo Tesuoraria nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->k13_conta;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Saldo Tesuoraria nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->k13_conta;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k13_conta;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($k13_conta=null) { 
     $this->atualizacampos(true);
     $result = @pg_exec(" delete from saltes
                    where  k13_conta = $this->k13_conta
                    ");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Saldo Tesuoraria nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->k13_conta;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Saldo Tesuoraria nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->k13_conta;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k13_conta;
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
   function sql_query ( $k13_conta=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from saltes ";
     $sql2 = "";
     if($dbwhere==""){
       if($k13_conta!=null ){
         $sql2 .= " where saltes.k13_conta = $k13_conta "; 
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
   function sql_query_file ( $k13_conta=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from saltes ";
     $sql2 = "";
     if($dbwhere==""){
       if($k13_conta!=null ){
         $sql2 .= " where saltes.k13_conta = $k13_conta "; 
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