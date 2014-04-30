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
//CLASSE DA ENTIDADE testada
class cl_testada { 
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
   var $j36_idbql = 0; 
   var $j36_face = 0; 
   var $j36_codigo = 0; 
   var $j36_testad = 0; 
   var $j36_testle = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 j36_idbql = int4 = Id lote 
                 j36_face = int4 = Face 
                 j36_codigo = int4 = Rua 
                 j36_testad = float8 = Testada Ml 
                 j36_testle = float8 = Testada Medida 
                 ";
   //funcao construtor da classe 
   function cl_testada() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("testada"); 
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
       $this->j36_idbql = ($this->j36_idbql == ""?@$GLOBALS["HTTP_POST_VARS"]["j36_idbql"]:$this->j36_idbql);
       $this->j36_face = ($this->j36_face == ""?@$GLOBALS["HTTP_POST_VARS"]["j36_face"]:$this->j36_face);
       $this->j36_codigo = ($this->j36_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["j36_codigo"]:$this->j36_codigo);
       $this->j36_testad = ($this->j36_testad == ""?@$GLOBALS["HTTP_POST_VARS"]["j36_testad"]:$this->j36_testad);
       $this->j36_testle = ($this->j36_testle == ""?@$GLOBALS["HTTP_POST_VARS"]["j36_testle"]:$this->j36_testle);
     }else{
       $this->j36_idbql = ($this->j36_idbql == ""?@$GLOBALS["HTTP_POST_VARS"]["j36_idbql"]:$this->j36_idbql);
       $this->j36_face = ($this->j36_face == ""?@$GLOBALS["HTTP_POST_VARS"]["j36_face"]:$this->j36_face);
     }
   }
   // funcao para inclusao
   function incluir ($j36_idbql,$j36_face){ 
      $this->atualizacampos();
     if($this->j36_codigo == null ){ 
       $this->erro_sql = " Campo Rua nao Informado.";
       $this->erro_campo = "j36_codigo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j36_testad == null ){ 
       $this->erro_sql = " Campo Testada Ml nao Informado.";
       $this->erro_campo = "j36_testad";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j36_testle == null ){ 
       $this->erro_sql = " Campo Testada Medida nao Informado.";
       $this->erro_campo = "j36_testle";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->j36_idbql = $j36_idbql; 
       $this->j36_face = $j36_face; 
     if(($this->j36_idbql == null) || ($this->j36_idbql == "") ){ 
       $this->erro_sql = " Campo j36_idbql nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->j36_face == null) || ($this->j36_face == "") ){ 
       $this->erro_sql = " Campo j36_face nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into testada(
                                       j36_idbql 
                                      ,j36_face 
                                      ,j36_codigo 
                                      ,j36_testad 
                                      ,j36_testle 
                       )
                values (
                                $this->j36_idbql 
                               ,$this->j36_face 
                               ,$this->j36_codigo 
                               ,$this->j36_testad 
                               ,$this->j36_testle 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Testada ($this->j36_idbql."-".$this->j36_face) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Testada já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Testada ($this->j36_idbql."-".$this->j36_face) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j36_idbql."-".$this->j36_face;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($j36_idbql=null,$j36_face=null) { 
      $this->atualizacampos();
     $sql = " update testada set ";
     $virgula = "";
     if(isset($GLOBALS["HTTP_POST_VARS"]["j36_idbql"])){ 
       $sql  .= $virgula." j36_idbql = $this->j36_idbql ";
       $virgula = ",";
       if($this->j36_idbql == null ){ 
         $this->erro_sql = " Campo Id lote nao Informado.";
         $this->erro_campo = "j36_idbql";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j36_face"])){ 
       $sql  .= $virgula." j36_face = $this->j36_face ";
       $virgula = ",";
       if($this->j36_face == null ){ 
         $this->erro_sql = " Campo Face nao Informado.";
         $this->erro_campo = "j36_face";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j36_codigo"])){ 
       $sql  .= $virgula." j36_codigo = $this->j36_codigo ";
       $virgula = ",";
       if($this->j36_codigo == null ){ 
         $this->erro_sql = " Campo Rua nao Informado.";
         $this->erro_campo = "j36_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j36_testad"])){ 
       $sql  .= $virgula." j36_testad = $this->j36_testad ";
       $virgula = ",";
       if($this->j36_testad == null ){ 
         $this->erro_sql = " Campo Testada Ml nao Informado.";
         $this->erro_campo = "j36_testad";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j36_testle"])){ 
       $sql  .= $virgula." j36_testle = $this->j36_testle ";
       $virgula = ",";
       if($this->j36_testle == null ){ 
         $this->erro_sql = " Campo Testada Medida nao Informado.";
         $this->erro_campo = "j36_testle";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  j36_idbql = $this->j36_idbql
 and  j36_face = $this->j36_face
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Testada nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->j36_idbql."-".$this->j36_face;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Testada nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->j36_idbql."-".$this->j36_face;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j36_idbql."-".$this->j36_face;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($j36_idbql=null,$j36_face=null) { 
     $this->atualizacampos(true);
     $sql = " delete from testada
                    where ";
     $sql2 = "";
      if($this->j36_idbql != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " j36_idbql = $this->j36_idbql ";
}
      if($this->j36_face != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " j36_face = $this->j36_face ";
}
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Testada nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->j36_idbql."-".$this->j36_face;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Testada nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->j36_idbql."-".$this->j36_face;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j36_idbql."-".$this->j36_face;
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
   function sql_query ( $j36_idbql=null,$j36_face=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from testada ";
     $sql .= "      inner join ruas  on  ruas.j14_codigo = testada.j36_codigo";
     $sql .= "      inner join lote  on  lote.j34_idbql = testada.j36_idbql";
     $sql .= "      inner join bairro  on  bairro.j13_codi = lote.j34_bairro";
     $sql .= "      inner join setor  on  setor.j30_codi = lote.j34_setor";
     $sql2 = "";
     if($dbwhere==""){
       if($j36_idbql!=null ){
         $sql2 .= " where testada.j36_idbql = $j36_idbql "; 
       } 
       if($j36_face!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " testada.j36_face = $j36_face "; 
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
   function sql_query_file ( $j36_idbql=null,$j36_face=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from testada ";
     $sql2 = "";
     if($dbwhere==""){
       if($j36_idbql!=null ){
         $sql2 .= " where testada.j36_idbql = $j36_idbql "; 
       } 
       if($j36_face!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " testada.j36_face = $j36_face "; 
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