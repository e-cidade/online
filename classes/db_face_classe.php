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
//CLASSE DA ENTIDADE face
class cl_face { 
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
   var $j37_face = 0; 
   var $j37_setor = null; 
   var $j37_quadra = null; 
   var $j37_codigo = 0; 
   var $j37_lado = null; 
   var $j37_valor = 0; 
   var $j37_exten = 0; 
   var $j37_profr = 0; 
   var $j37_outros = null; 
   var $j37_vlcons = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 j37_face = int4 = Face 
                 j37_setor = char(4) = Setor 
                 j37_quadra = char(4) = Quadra 
                 j37_codigo = int4 = Rua 
                 j37_lado = char(1) = Lado 
                 j37_valor = float8 = Valor M2 
                 j37_exten = float8 = Extensao 
                 j37_profr = float8 = Profundidade Quadra 
                 j37_outros = varchar(40) = Outros Dados 
                 j37_vlcons = float8 = Valor M2 Construção 
                 ";
   //funcao construtor da classe 
   function cl_face() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("face"); 
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
       $this->j37_face = ($this->j37_face == ""?@$GLOBALS["HTTP_POST_VARS"]["j37_face"]:$this->j37_face);
       $this->j37_setor = ($this->j37_setor == ""?@$GLOBALS["HTTP_POST_VARS"]["j37_setor"]:$this->j37_setor);
       $this->j37_quadra = ($this->j37_quadra == ""?@$GLOBALS["HTTP_POST_VARS"]["j37_quadra"]:$this->j37_quadra);
       $this->j37_codigo = ($this->j37_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["j37_codigo"]:$this->j37_codigo);
       $this->j37_lado = ($this->j37_lado == ""?@$GLOBALS["HTTP_POST_VARS"]["j37_lado"]:$this->j37_lado);
       $this->j37_valor = ($this->j37_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["j37_valor"]:$this->j37_valor);
       $this->j37_exten = ($this->j37_exten == ""?@$GLOBALS["HTTP_POST_VARS"]["j37_exten"]:$this->j37_exten);
       $this->j37_profr = ($this->j37_profr == ""?@$GLOBALS["HTTP_POST_VARS"]["j37_profr"]:$this->j37_profr);
       $this->j37_outros = ($this->j37_outros == ""?@$GLOBALS["HTTP_POST_VARS"]["j37_outros"]:$this->j37_outros);
       $this->j37_vlcons = ($this->j37_vlcons == ""?@$GLOBALS["HTTP_POST_VARS"]["j37_vlcons"]:$this->j37_vlcons);
     }else{
       $this->j37_face = ($this->j37_face == ""?@$GLOBALS["HTTP_POST_VARS"]["j37_face"]:$this->j37_face);
     }
   }
   // funcao para inclusao
   function incluir ($j37_face){ 
      $this->atualizacampos();
     if($this->j37_setor == null ){ 
       $this->erro_sql = " Campo Setor nao Informado.";
       $this->erro_campo = "j37_setor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j37_quadra == null ){ 
       $this->erro_sql = " Campo Quadra nao Informado.";
       $this->erro_campo = "j37_quadra";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j37_codigo == null ){ 
       $this->erro_sql = " Campo Rua nao Informado.";
       $this->erro_campo = "j37_codigo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j37_lado == null ){ 
       $this->erro_sql = " Campo Lado nao Informado.";
       $this->erro_campo = "j37_lado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j37_valor == null ){ 
       $this->erro_sql = " Campo Valor M2 nao Informado.";
       $this->erro_campo = "j37_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j37_exten == null ){ 
       $this->erro_sql = " Campo Extensao nao Informado.";
       $this->erro_campo = "j37_exten";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j37_profr == null ){ 
       $this->erro_sql = " Campo Profundidade Quadra nao Informado.";
       $this->erro_campo = "j37_profr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j37_outros == null ){ 
       $this->erro_sql = " Campo Outros Dados nao Informado.";
       $this->erro_campo = "j37_outros";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j37_vlcons == null ){ 
       $this->j37_vlcons = "0";
     }
       $this->j37_face = $j37_face; 
     if(($this->j37_face == null) || ($this->j37_face == "") ){ 
       $this->erro_sql = " Campo j37_face nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into face(
                                       j37_face 
                                      ,j37_setor 
                                      ,j37_quadra 
                                      ,j37_codigo 
                                      ,j37_lado 
                                      ,j37_valor 
                                      ,j37_exten 
                                      ,j37_profr 
                                      ,j37_outros 
                                      ,j37_vlcons 
                       )
                values (
                                $this->j37_face 
                               ,'$this->j37_setor' 
                               ,'$this->j37_quadra' 
                               ,$this->j37_codigo 
                               ,'$this->j37_lado' 
                               ,$this->j37_valor 
                               ,$this->j37_exten 
                               ,$this->j37_profr 
                               ,'$this->j37_outros' 
                               ,$this->j37_vlcons 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = " ($this->j37_face) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = " já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = " ($this->j37_face) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j37_face;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($j37_face=null) { 
      $this->atualizacampos();
     $sql = " update face set ";
     $virgula = "";
     if(isset($GLOBALS["HTTP_POST_VARS"]["j37_face"])){ 
       $sql  .= $virgula." j37_face = $this->j37_face ";
       $virgula = ",";
       if($this->j37_face == null ){ 
         $this->erro_sql = " Campo Face nao Informado.";
         $this->erro_campo = "j37_face";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j37_setor"])){ 
       $sql  .= $virgula." j37_setor = '$this->j37_setor' ";
       $virgula = ",";
       if($this->j37_setor == null ){ 
         $this->erro_sql = " Campo Setor nao Informado.";
         $this->erro_campo = "j37_setor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j37_quadra"])){ 
       $sql  .= $virgula." j37_quadra = '$this->j37_quadra' ";
       $virgula = ",";
       if($this->j37_quadra == null ){ 
         $this->erro_sql = " Campo Quadra nao Informado.";
         $this->erro_campo = "j37_quadra";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j37_codigo"])){ 
       $sql  .= $virgula." j37_codigo = $this->j37_codigo ";
       $virgula = ",";
       if($this->j37_codigo == null ){ 
         $this->erro_sql = " Campo Rua nao Informado.";
         $this->erro_campo = "j37_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j37_lado"])){ 
       $sql  .= $virgula." j37_lado = '$this->j37_lado' ";
       $virgula = ",";
       if($this->j37_lado == null ){ 
         $this->erro_sql = " Campo Lado nao Informado.";
         $this->erro_campo = "j37_lado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j37_valor"])){ 
       $sql  .= $virgula." j37_valor = $this->j37_valor ";
       $virgula = ",";
       if($this->j37_valor == null ){ 
         $this->erro_sql = " Campo Valor M2 nao Informado.";
         $this->erro_campo = "j37_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j37_exten"])){ 
       $sql  .= $virgula." j37_exten = $this->j37_exten ";
       $virgula = ",";
       if($this->j37_exten == null ){ 
         $this->erro_sql = " Campo Extensao nao Informado.";
         $this->erro_campo = "j37_exten";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j37_profr"])){ 
       $sql  .= $virgula." j37_profr = $this->j37_profr ";
       $virgula = ",";
       if($this->j37_profr == null ){ 
         $this->erro_sql = " Campo Profundidade Quadra nao Informado.";
         $this->erro_campo = "j37_profr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j37_outros"])){ 
       $sql  .= $virgula." j37_outros = '$this->j37_outros' ";
       $virgula = ",";
       if($this->j37_outros == null ){ 
         $this->erro_sql = " Campo Outros Dados nao Informado.";
         $this->erro_campo = "j37_outros";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j37_vlcons"])){ 
       $sql  .= $virgula." j37_vlcons = $this->j37_vlcons ";
       $virgula = ",";
     }
     $sql .= " where  j37_face = $this->j37_face
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->j37_face;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->j37_face;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j37_face;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($j37_face=null) { 
     $this->atualizacampos(true);
     $result = @pg_exec(" delete from face
                    where  j37_face = $this->j37_face
                    ");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->j37_face;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->j37_face;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j37_face;
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
   function sql_query ( $j37_face=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from face ";
     $sql .= "      inner join ruas  on  ruas.j14_codigo = face.j37_codigo";
     $sql .= "      inner join setor  on  setor.j30_codi = face.j37_setor";
     $sql2 = "";
     if($dbwhere==""){
       if($j37_face!=null ){
         $sql2 .= " where face.j37_face = $j37_face "; 
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
   function sql_query_file ( $j37_face=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from face ";
     $sql2 = "";
     if($dbwhere==""){
       if($j37_face!=null ){
         $sql2 .= " where face.j37_face = $j37_face "; 
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