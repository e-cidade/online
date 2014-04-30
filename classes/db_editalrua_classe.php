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

//MODULO: contrib
//CLASSE DA ENTIDADE editalrua
class cl_editalrua { 
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
   var $d02_contri = 0; 
   var $d02_codedi = 0; 
   var $d02_codigo = 0; 
   var $d02_dtauto_dia = null; 
   var $d02_dtauto_mes = null; 
   var $d02_dtauto_ano = null; 
   var $d02_dtauto = null; 
   var $d02_autori = 'f'; 
   var $d02_idlog = 0; 
   var $d02_data_dia = null; 
   var $d02_data_mes = null; 
   var $d02_data_ano = null; 
   var $d02_data = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 d02_contri = int4 = Constribuicao 
                 d02_codedi = int4 = Codigo Edital 
                 d02_codigo = int4 = Rua/Avenida 
                 d02_dtauto = date = Data Autorizacao 
                 d02_autori = bool = Autorizado 
                 d02_idlog = int4 = Codigo do Usuario 
                 d02_data = date = Data de inclusao 
                 ";
   //funcao construtor da classe 
   function cl_editalrua() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("editalrua"); 
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
       $this->d02_contri = ($this->d02_contri == ""?@$GLOBALS["HTTP_POST_VARS"]["d02_contri"]:$this->d02_contri);
       $this->d02_codedi = ($this->d02_codedi == ""?@$GLOBALS["HTTP_POST_VARS"]["d02_codedi"]:$this->d02_codedi);
       $this->d02_codigo = ($this->d02_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["d02_codigo"]:$this->d02_codigo);
       if($this->d02_dtauto == ""){
         $this->d02_dtauto_dia = @$GLOBALS["HTTP_POST_VARS"]["d02_dtauto_dia"];
         $this->d02_dtauto_mes = @$GLOBALS["HTTP_POST_VARS"]["d02_dtauto_mes"];
         $this->d02_dtauto_ano = @$GLOBALS["HTTP_POST_VARS"]["d02_dtauto_ano"];
         if($this->d02_dtauto_dia != ""){
            $this->d02_dtauto = $this->d02_dtauto_ano."-".$this->d02_dtauto_mes."-".$this->d02_dtauto_dia;
         }
       }
       $this->d02_autori = ($this->d02_autori == "f"?@$GLOBALS["HTTP_POST_VARS"]["d02_autori"]:$this->d02_autori);
       $this->d02_idlog = ($this->d02_idlog == ""?@$GLOBALS["HTTP_POST_VARS"]["d02_idlog"]:$this->d02_idlog);
       if($this->d02_data == ""){
         $this->d02_data_dia = @$GLOBALS["HTTP_POST_VARS"]["d02_data_dia"];
         $this->d02_data_mes = @$GLOBALS["HTTP_POST_VARS"]["d02_data_mes"];
         $this->d02_data_ano = @$GLOBALS["HTTP_POST_VARS"]["d02_data_ano"];
         if($this->d02_data_dia != ""){
            $this->d02_data = $this->d02_data_ano."-".$this->d02_data_mes."-".$this->d02_data_dia;
         }
       }
     }else{
       $this->d02_contri = ($this->d02_contri == ""?@$GLOBALS["HTTP_POST_VARS"]["d02_contri"]:$this->d02_contri);
     }
   }
   // funcao para inclusao
   function incluir ($d02_contri){ 
      $this->atualizacampos();
     if($this->d02_codedi == null ){ 
       $this->erro_sql = " Campo Codigo Edital nao Informado.";
       $this->erro_campo = "d02_codedi";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->d02_codigo == null ){ 
       $this->erro_sql = " Campo Rua/Avenida nao Informado.";
       $this->erro_campo = "d02_codigo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->d02_dtauto == null ){ 
       $this->erro_sql = " Campo Data Autorizacao nao Informado.";
       $this->erro_campo = "d02_dtauto_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->d02_autori == null ){ 
       $this->erro_sql = " Campo Autorizado nao Informado.";
       $this->erro_campo = "d02_autori";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->d02_idlog == null ){ 
       $this->erro_sql = " Campo Codigo do Usuario nao Informado.";
       $this->erro_campo = "d02_idlog";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->d02_data == null ){ 
       $this->erro_sql = " Campo Data de inclusao nao Informado.";
       $this->erro_campo = "d02_data_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($d02_contri == "" || $d02_contri == null ){
       $result = @pg_query("select nextval('editalrua_d02_contri_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: editalrua_d02_contri_seq do campo: d02_contri"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->d02_contri = pg_result($result,0,0); 
     }else{
       $result = pg_query("select last_value from editalrua_d02_contri_seq");
       if(($result != false) && (pg_result($result,0,0) < $d02_contri)){
         $this->erro_sql = " Campo d02_contri maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->d02_contri = $d02_contri; 
       }
     }
     if(($this->d02_contri == null) || ($this->d02_contri == "") ){ 
       $this->erro_sql = " Campo d02_contri nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into editalrua(
                                       d02_contri 
                                      ,d02_codedi 
                                      ,d02_codigo 
                                      ,d02_dtauto 
                                      ,d02_autori 
                                      ,d02_idlog 
                                      ,d02_data 
                       )
                values (
                                $this->d02_contri 
                               ,$this->d02_codedi 
                               ,$this->d02_codigo 
                               ,".($this->d02_dtauto == "null" || $this->d02_dtauto == ""?"null":"'".$this->d02_dtauto."'")." 
                               ,'$this->d02_autori' 
                               ,$this->d02_idlog 
                               ,".($this->d02_data == "null" || $this->d02_data == ""?"null":"'".$this->d02_data."'")." 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " ($this->d02_contri) nao Incluído. Inclusao Abortada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->d02_contri;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($d02_contri=null) { 
      $this->atualizacampos();
     $sql = " update editalrua set ";
     $virgula = "";
     if(isset($GLOBALS["HTTP_POST_VARS"]["d02_contri"])){ 
       $sql  .= $virgula." d02_contri = $this->d02_contri ";
       $virgula = ",";
       if($this->d02_contri == null ){ 
         $this->erro_sql = " Campo Constribuicao nao Informado.";
         $this->erro_campo = "d02_contri";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d02_codedi"])){ 
       $sql  .= $virgula." d02_codedi = $this->d02_codedi ";
       $virgula = ",";
       if($this->d02_codedi == null ){ 
         $this->erro_sql = " Campo Codigo Edital nao Informado.";
         $this->erro_campo = "d02_codedi";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d02_codigo"])){ 
       $sql  .= $virgula." d02_codigo = $this->d02_codigo ";
       $virgula = ",";
       if($this->d02_codigo == null ){ 
         $this->erro_sql = " Campo Rua/Avenida nao Informado.";
         $this->erro_campo = "d02_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d02_dtauto_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["d02_dtauto_dia"] !="") ){ 
       $sql  .= $virgula." d02_dtauto = '$this->d02_dtauto' ";
       $virgula = ",";
       if($this->d02_dtauto == null ){ 
         $this->erro_sql = " Campo Data Autorizacao nao Informado.";
         $this->erro_campo = "d02_dtauto_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       $sql  .= $virgula." d02_dtauto = null ";
       $virgula = ",";
       if($this->d02_dtauto == null ){ 
         $this->erro_sql = " Campo Data Autorizacao nao Informado.";
         $this->erro_campo = "d02_dtauto_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d02_autori"])){ 
       $sql  .= $virgula." d02_autori = '$this->d02_autori' ";
       $virgula = ",";
       if($this->d02_autori == null ){ 
         $this->erro_sql = " Campo Autorizado nao Informado.";
         $this->erro_campo = "d02_autori";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d02_idlog"])){ 
       $sql  .= $virgula." d02_idlog = $this->d02_idlog ";
       $virgula = ",";
       if($this->d02_idlog == null ){ 
         $this->erro_sql = " Campo Codigo do Usuario nao Informado.";
         $this->erro_campo = "d02_idlog";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d02_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["d02_data_dia"] !="") ){ 
       $sql  .= $virgula." d02_data = '$this->d02_data' ";
       $virgula = ",";
       if($this->d02_data == null ){ 
         $this->erro_sql = " Campo Data de inclusao nao Informado.";
         $this->erro_campo = "d02_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       $sql  .= $virgula." d02_data = null ";
       $virgula = ",";
	   
       if($this->d02_data == null ){ 
         $this->erro_sql = " Campo Data de inclusao nao Informado.";
         $this->erro_campo = "d02_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
   $sql .= " where  d02_contri = $this->d02_contri
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->d02_contri;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->d02_contri;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->d02_contri;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($d02_contri=null) { 
     $this->atualizacampos(true);
     $result = @pg_exec(" delete from editalrua
                    where  d02_contri = $this->d02_contri
                    ");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->d02_contri;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->d02_contri;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->d02_contri;
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
   function sql_query ( $d02_contri=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from editalrua ";
     $sql .= "      inner join ruas on  ruas.j14_codigo = editalrua.d02_codigo";
     $sql .= "      inner join db_usuarios on  db_usuarios.id_usuario = editalrua.d02_idlog";
     $sql .= "      inner join edital on  edital.d01_codedi = editalrua.d02_codedi";
     $sql2 = "";
     if($dbwhere==""){
       if($d02_contri!=null ){
         $sql2 .= " where editalrua.d02_contri = $d02_contri "; 
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