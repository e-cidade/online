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
//CLASSE DA ENTIDADE edital
class cl_edital { 
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
   var $d01_codedi = 0; 
   var $d01_numero = null; 
   var $d01_descr = null; 
   var $d01_idlog = 0; 
   var $d01_data_dia = null; 
   var $d01_data_mes = null; 
   var $d01_data_ano = null; 
   var $d01_data = null; 
   var $d01_perc = 0; 
   var $d01_receit = 0; 
   var $d01_codbco = 0; 
   var $d01_codage = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 d01_codedi = int4 = Codigo Edital 
                 d01_numero = varchar(20) = Número do Edital 
                 d01_descr = text = Descricao do Edital 
                 d01_idlog = int4 = Login 
                 d01_data = date = Data Edital 
                 d01_perc = float8 = Percentual 
                 d01_receit = int4 = Receita 
                 d01_codbco = int4 = Codigo banco 
                 d01_codage = char(5) = Codigo da Agencia 
                 ";
   //funcao construtor da classe 
   function cl_edital() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("edital"); 
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
       $this->d01_codedi = ($this->d01_codedi == ""?@$GLOBALS["HTTP_POST_VARS"]["d01_codedi"]:$this->d01_codedi);
       $this->d01_numero = ($this->d01_numero == ""?@$GLOBALS["HTTP_POST_VARS"]["d01_numero"]:$this->d01_numero);
       $this->d01_descr = ($this->d01_descr == ""?@$GLOBALS["HTTP_POST_VARS"]["d01_descr"]:$this->d01_descr);
       $this->d01_idlog = ($this->d01_idlog == ""?@$GLOBALS["HTTP_POST_VARS"]["d01_idlog"]:$this->d01_idlog);
       if($this->d01_data == ""){
         $this->d01_data_dia = @$GLOBALS["HTTP_POST_VARS"]["d01_data_dia"];
         $this->d01_data_mes = @$GLOBALS["HTTP_POST_VARS"]["d01_data_mes"];
         $this->d01_data_ano = @$GLOBALS["HTTP_POST_VARS"]["d01_data_ano"];
         if($this->d01_data_dia != ""){
            $this->d01_data = $this->d01_data_ano."-".$this->d01_data_mes."-".$this->d01_data_dia;
         }
       }
       $this->d01_perc = ($this->d01_perc == ""?@$GLOBALS["HTTP_POST_VARS"]["d01_perc"]:$this->d01_perc);
       $this->d01_receit = ($this->d01_receit == ""?@$GLOBALS["HTTP_POST_VARS"]["d01_receit"]:$this->d01_receit);
       $this->d01_codbco = ($this->d01_codbco == ""?@$GLOBALS["HTTP_POST_VARS"]["d01_codbco"]:$this->d01_codbco);
       $this->d01_codage = ($this->d01_codage == ""?@$GLOBALS["HTTP_POST_VARS"]["d01_codage"]:$this->d01_codage);
     }else{
       $this->d01_codedi = ($this->d01_codedi == ""?@$GLOBALS["HTTP_POST_VARS"]["d01_codedi"]:$this->d01_codedi);
     }
   }
   // funcao para inclusao
   function incluir ($d01_codedi){ 
      $this->atualizacampos();
     if($this->d01_numero == null ){ 
       $this->erro_sql = " Campo Número do Edital nao Informado.";
       $this->erro_campo = "d01_numero";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->d01_descr == null ){ 
       $this->erro_sql = " Campo Descricao do Edital nao Informado.";
       $this->erro_campo = "d01_descr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->d01_idlog == null ){ 
       $this->erro_sql = " Campo Login nao Informado.";
       $this->erro_campo = "d01_idlog";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->d01_data == null ){ 
       $this->erro_sql = " Campo Data Edital nao Informado.";
       $this->erro_campo = "d01_data";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->d01_perc == null ){ 
       $this->erro_sql = " Campo Percentual nao Informado.";
       $this->erro_campo = "d01_perc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->d01_receit == null ){ 
       $this->erro_sql = " Campo Receita nao Informado.";
       $this->erro_campo = "d01_receit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->d01_codbco == null ){ 
       $this->erro_sql = " Campo Codigo banco nao Informado.";
       $this->erro_campo = "d01_codbco";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->d01_codage == null ){ 
       $this->erro_sql = " Campo Codigo da Agencia nao Informado.";
       $this->erro_campo = "d01_codage";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($d01_codedi == "" || $d01_codedi == null ){
       $result = @pg_query("select nextval('edital_d01_codedi_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: edital_d01_codedi_seq do campo: d01_codedi"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->d01_codedi = pg_result($result,0,0); 
     }else{
       $result = @pg_query("select last_value from edital_d01_codedi_seq");
       if(($result != false) && (pg_result($result,0,0) < $d01_codedi)){
         $this->erro_sql = " Campo d01_codedi maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->d01_codedi = $d01_codedi; 
       }
     }
     if(($this->d01_codedi == null) || ($this->d01_codedi == "") ){ 
       $this->erro_sql = " Campo d01_codedi nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into edital(
                                       d01_codedi 
                                      ,d01_numero 
                                      ,d01_descr 
                                      ,d01_idlog 
                                      ,d01_data 
                                      ,d01_perc 
                                      ,d01_receit 
                                      ,d01_codbco 
                                      ,d01_codage 
                       )
                values (
                                $this->d01_codedi 
                               ,'$this->d01_numero' 
                               ,'$this->d01_descr' 
                               ,$this->d01_idlog 
                               ,".($this->d01_data == "null" || $this->d01_data == ""?"null":"'".$this->d01_data."'")." 
                               ,$this->d01_perc 
                               ,$this->d01_receit 
                               ,$this->d01_codbco 
                               ,'$this->d01_codage' 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " ($this->d01_codedi) nao Incluído. Inclusao Abortada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->d01_codedi;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($d01_codedi=null) { 
      $this->atualizacampos();
     $sql = " update edital set ";
     $virgula = "";
     if(isset($GLOBALS["HTTP_POST_VARS"]["d01_codedi"])){ 
       $sql  .= $virgula." d01_codedi = $this->d01_codedi ";
       $virgula = ",";
       if($this->d01_codedi == null ){ 
         $this->erro_sql = " Campo Codigo Edital nao Informado.";
         $this->erro_campo = "d01_codedi";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d01_numero"])){ 
       $sql  .= $virgula." d01_numero = '$this->d01_numero' ";
       $virgula = ",";
       if($this->d01_numero == null ){ 
         $this->erro_sql = " Campo Número do Edital nao Informado.";
         $this->erro_campo = "d01_numero";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d01_descr"])){ 
       $sql  .= $virgula." d01_descr = '$this->d01_descr' ";
       $virgula = ",";
       if($this->d01_descr == null ){ 
         $this->erro_sql = " Campo Descricao do Edital nao Informado.";
         $this->erro_campo = "d01_descr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d01_idlog"])){ 
       $sql  .= $virgula." d01_idlog = $this->d01_idlog ";
       $virgula = ",";
       if($this->d01_idlog == null ){ 
         $this->erro_sql = " Campo Login nao Informado.";
         $this->erro_campo = "d01_idlog";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d01_data_dia"])){ 
       $sql  .= $virgula." d01_data = '$this->d01_data' ";
       $virgula = ",";
       if($this->d01_data == null ){ 
         $this->erro_sql = " Campo Data Edital nao Informado.";
         $this->erro_campo = "d01_data";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       $sql  .= $virgula." d01_data = null ";
       $virgula = ",";
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d01_perc"])){ 
       $sql  .= $virgula." d01_perc = $this->d01_perc ";
       $virgula = ",";
       if($this->d01_perc == null ){ 
         $this->erro_sql = " Campo Percentual nao Informado.";
         $this->erro_campo = "d01_perc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d01_receit"])){ 
       $sql  .= $virgula." d01_receit = $this->d01_receit ";
       $virgula = ",";
       if($this->d01_receit == null ){ 
         $this->erro_sql = " Campo Receita nao Informado.";
         $this->erro_campo = "d01_receit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d01_codbco"])){ 
       $sql  .= $virgula." d01_codbco = $this->d01_codbco ";
       $virgula = ",";
       if($this->d01_codbco == null ){ 
         $this->erro_sql = " Campo Codigo banco nao Informado.";
         $this->erro_campo = "d01_codbco";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["d01_codage"])){ 
       $sql  .= $virgula." d01_codage = '$this->d01_codage' ";
       $virgula = ",";
       if($this->d01_codage == null ){ 
         $this->erro_sql = " Campo Codigo da Agencia nao Informado.";
         $this->erro_campo = "d01_codage";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  d01_codedi = $this->d01_codedi
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->d01_codedi;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->d01_codedi;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->d01_codedi;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($d01_codedi=null) { 
     $this->atualizacampos(true);
     $result = @pg_exec(" delete from edital
                    where  d01_codedi = $this->d01_codedi
                    ");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->d01_codedi;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->d01_codedi;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->d01_codedi;
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
   function sql_query ( $d01_codedi=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from edital ";
     $sql2 = "";
     if($dbwhere==""){
       if($d01_codedi!=null ){
         $sql2 .= " where edital.d01_codedi = $d01_codedi "; 
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