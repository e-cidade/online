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

//MODULO: cadastro
//CLASSE DA ENTIDADE iptuconstr
class cl_iptuconstr { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $j39_matric = 0; 
   var $j39_idcons = 0; 
   var $j39_ano = 0; 
   var $j39_area = 0; 
   var $j39_areap = 0; 
   var $j39_dtlan_dia = null; 
   var $j39_dtlan_mes = null; 
   var $j39_dtlan_ano = null; 
   var $j39_dtlan = null; 
   var $j39_codigo = 0; 
   var $j39_numero = 0; 
   var $j39_compl = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 j39_matric = int4 = Matricula 
                 j39_idcons = int4 = Codigo Construcao 
                 j39_ano = int4 = Ano Construcao 
                 j39_area = float8 = Area M2 
                 j39_areap = float8 = Area Privada 
                 j39_dtlan = date = Data Inclusao 
                 j39_codigo = int4 = Rua 
                 j39_numero = int4 = Numero 
                 j39_compl = varchar(20) = Complemento 
                 ";
   //funcao construtor da classe 
   function cl_iptuconstr() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("iptuconstr"); 
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
   // funcao para inclusao
   function atualizacampos($exclusao=false) {
     if($exclusao==false){
       $this->j39_matric = ($this->j39_matric == ""?@$GLOBALS["HTTP_POST_VARS"]["j39_matric"]:$this->j39_matric);
       $this->j39_idcons = ($this->j39_idcons == ""?@$GLOBALS["HTTP_POST_VARS"]["j39_idcons"]:$this->j39_idcons);
       $this->j39_ano = ($this->j39_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["j39_ano"]:$this->j39_ano);
       $this->j39_area = ($this->j39_area == ""?@$GLOBALS["HTTP_POST_VARS"]["j39_area"]:$this->j39_area);
       $this->j39_areap = ($this->j39_areap == ""?@$GLOBALS["HTTP_POST_VARS"]["j39_areap"]:$this->j39_areap);
       $this->j39_dtlan = ($this->j39_dtlan == ""?@$GLOBALS["HTTP_POST_VARS"]["j39_dtlan_ano"]."-".@$GLOBALS["HTTP_POST_VARS"]["j39_dtlan_mes"]."-".@$GLOBALS["HTTP_POST_VARS"]["j39_dtlan_dia"]:$this->j39_dtlan);
       $this->j39_codigo = ($this->j39_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["j39_codigo"]:$this->j39_codigo);
       $this->j39_numero = ($this->j39_numero == ""?@$GLOBALS["HTTP_POST_VARS"]["j39_numero"]:$this->j39_numero);
       $this->j39_compl = ($this->j39_compl == ""?@$GLOBALS["HTTP_POST_VARS"]["j39_compl"]:$this->j39_compl);
     }else{
       $this->j39_matric = ($this->j39_matric == ""?@$GLOBALS["HTTP_POST_VARS"]["j39_matric"]:$this->j39_matric);
       $this->j39_idcons = ($this->j39_idcons == ""?@$GLOBALS["HTTP_POST_VARS"]["j39_idcons"]:$this->j39_idcons);
     }
   }
   // funcao para inclusao
   function incluir ($j39_matric,$j39_idcons){ 
      $this->atualizacampos();
     if($this->j39_ano == null ){ 
       $this->erro_sql = " Campo j39_ano nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j39_area == null ){ 
       $this->erro_sql = " Campo j39_area nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j39_areap == null ){ 
       $this->erro_sql = " Campo j39_areap nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j39_dtlan == null ){ 
       $this->erro_sql = " Campo j39_dtlan nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j39_codigo == null ){ 
       $this->erro_sql = " Campo j39_codigo nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j39_numero == null ){ 
       $this->erro_sql = " Campo j39_numero nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j39_compl == null ){ 
       $this->erro_sql = " Campo j39_compl nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->j39_matric = $j39_matric; 
       $this->j39_idcons = $j39_idcons; 
     if(($this->j39_matric == null) || ($this->j39_matric == "") ){ 
       $this->erro_sql = " Campo j39_matric nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->j39_idcons == null) || ($this->j39_idcons == "") ){ 
       $this->erro_sql = " Campo j39_idcons nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into iptuconstr(
                                       j39_matric 
                                      ,j39_idcons 
                                      ,j39_ano 
                                      ,j39_area 
                                      ,j39_areap 
                                      ,j39_dtlan 
                                      ,j39_codigo 
                                      ,j39_numero 
                                      ,j39_compl 
                       )
                values (
                                $this->j39_matric 
                               ,$this->j39_idcons 
                               ,$this->j39_ano 
                               ,$this->j39_area 
                               ,$this->j39_areap 
                               ,'$this->j39_dtlan' 
                               ,$this->j39_codigo 
                               ,$this->j39_numero 
                               ,'$this->j39_compl' 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " ($this->j39_matric."-".$this->j39_idcons) nao Incluído. Inclusao Abortada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
     $this->erro_sql .= "Valores : ".$this->j39_matric."-".$this->j39_idcons;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($j39_matric=null,$j39_idcons=null) { 
      $this->atualizacampos();
     $sql = " update iptuconstr set ";
     $virgula = "";
     if($this->j39_matric != null ){ 
       $sql  .= $virgula." j39_matric = $this->j39_matric ";
       $virgula = ",";
     }
     if($this->j39_idcons != null ){ 
       $sql  .= $virgula." j39_idcons = $this->j39_idcons ";
       $virgula = ",";
     }
     if($this->j39_ano != null ){ 
       $sql  .= $virgula." j39_ano = $this->j39_ano ";
       $virgula = ",";
     }
     if($this->j39_area != null ){ 
       $sql  .= $virgula." j39_area = $this->j39_area ";
       $virgula = ",";
     }
     if($this->j39_areap != null ){ 
       $sql  .= $virgula." j39_areap = $this->j39_areap ";
       $virgula = ",";
     }
     if($this->j39_dtlan != null && $this->j39_dtlan != "--"){ 
       $sql  .= $virgula." j39_dtlan = '$this->j39_dtlan' ";
       $virgula = ",";
     }     else{ 
       $sql  .= $virgula." j39_dtlan = null ";
       $virgula = ",";
     }
     if($this->j39_codigo != null ){ 
       $sql  .= $virgula." j39_codigo = $this->j39_codigo ";
       $virgula = ",";
     }
     if($this->j39_numero != null ){ 
       $sql  .= $virgula." j39_numero = $this->j39_numero ";
       $virgula = ",";
     }
     if($this->j39_compl != null ){ 
       $sql  .= $virgula." j39_compl = '$this->j39_compl' ";
       $virgula = ",";
     }
     $sql .= " where  j39_matric = $this->j39_matric
, j39_idcons = $this->j39_idcons
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->j39_matric."-".$this->j39_idcons;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->j39_matric."-".$this->j39_idcons;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j39_matric."-".$this->j39_idcons;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($j39_matric=null,$j39_idcons=null) { 
     $this->atualizacampos(true);
     $result = @pg_exec(" delete from iptuconstr
                    where  j39_matric = $this->j39_matric
, j39_idcons = $this->j39_idcons
                    ");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->j39_matric."-".$this->j39_idcons;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->j39_matric."-".$this->j39_idcons;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j39_matric."-".$this->j39_idcons;
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
     return $result;
   }
   // funcao do sql 
   function sql_query ( $j39_matric=null$j39_idcons=null,$campos="*",$ordem=null){ 
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
     $sql .= " from iptuconstr ";
     if($j39_matric!=null ){
       $sql .= " where j39_matric = $j39_matric"; 
     } 
     if($j39_idcons!=null ){
       if($j39_matric!=null ){
          $sql .= " and ";
       }else{
          $sql .= " where ";
       } 
       $sql .= j39_idcons = $j39_idcons; 
     } 
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