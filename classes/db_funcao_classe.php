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

//MODULO: pessoal
//CLASSE DA ENTIDADE funcao
class cl_funcao { 
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
   var $r37_anousu = 0; 
   var $r37_mesusu = 0; 
   var $r37_funcao = 0; 
   var $r37_descr = null; 
   var $r37_vagas = 0; 
   var $r37_cbo = null; 
   var $r37_lei = 0; 
   var $r37_class = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 r37_anousu = int4 = Ano do Exercicio 
                 r37_mesusu = int4 = Mes do Exercicio 
                 r37_funcao = int4 = Codigo da funcao 
                 r37_descr = char(    30) = Descricao da funcao 
                 r37_vagas = int4 = Numero de vagas 
                 r37_cbo = char(     5) = Codigo Brasileiro de Ocupacoes 
                 r37_lei = float4 = Lei 
                 r37_class = varchar(5) = Classificação 
                 ";
   //funcao construtor da classe 
   function cl_funcao() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("funcao"); 
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
       $this->r37_anousu = ($this->r37_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["r37_anousu"]:$this->r37_anousu);
       $this->r37_mesusu = ($this->r37_mesusu == ""?@$GLOBALS["HTTP_POST_VARS"]["r37_mesusu"]:$this->r37_mesusu);
       $this->r37_funcao = ($this->r37_funcao == ""?@$GLOBALS["HTTP_POST_VARS"]["r37_funcao"]:$this->r37_funcao);
       $this->r37_descr = ($this->r37_descr == ""?@$GLOBALS["HTTP_POST_VARS"]["r37_descr"]:$this->r37_descr);
       $this->r37_vagas = ($this->r37_vagas == ""?@$GLOBALS["HTTP_POST_VARS"]["r37_vagas"]:$this->r37_vagas);
       $this->r37_cbo = ($this->r37_cbo == ""?@$GLOBALS["HTTP_POST_VARS"]["r37_cbo"]:$this->r37_cbo);
       $this->r37_lei = ($this->r37_lei == ""?@$GLOBALS["HTTP_POST_VARS"]["r37_lei"]:$this->r37_lei);
       $this->r37_class = ($this->r37_class == ""?@$GLOBALS["HTTP_POST_VARS"]["r37_class"]:$this->r37_class);
     }else{
       $this->r37_anousu = ($this->r37_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["r37_anousu"]:$this->r37_anousu);
       $this->r37_mesusu = ($this->r37_mesusu == ""?@$GLOBALS["HTTP_POST_VARS"]["r37_mesusu"]:$this->r37_mesusu);
       $this->r37_funcao = ($this->r37_funcao == ""?@$GLOBALS["HTTP_POST_VARS"]["r37_funcao"]:$this->r37_funcao);
     }
   }
   // funcao para inclusao
   function incluir ($r37_anousu,$r37_mesusu,$r37_funcao){ 
      $this->atualizacampos();
     if($this->r37_descr == null ){ 
       $this->erro_sql = " Campo Descricao da funcao nao Informado.";
       $this->erro_campo = "r37_descr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->r37_vagas == null ){ 
       $this->erro_sql = " Campo Numero de vagas nao Informado.";
       $this->erro_campo = "r37_vagas";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->r37_cbo == null ){ 
       $this->erro_sql = " Campo Codigo Brasileiro de Ocupacoes nao Informado.";
       $this->erro_campo = "r37_cbo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->r37_lei == null ){ 
       $this->erro_sql = " Campo Lei nao Informado.";
       $this->erro_campo = "r37_lei";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->r37_class == null ){ 
       $this->erro_sql = " Campo Classificação nao Informado.";
       $this->erro_campo = "r37_class";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->r37_anousu = $r37_anousu; 
       $this->r37_mesusu = $r37_mesusu; 
       $this->r37_funcao = $r37_funcao; 
     if(($this->r37_anousu == null) || ($this->r37_anousu == "") ){ 
       $this->erro_sql = " Campo r37_anousu nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->r37_mesusu == null) || ($this->r37_mesusu == "") ){ 
       $this->erro_sql = " Campo r37_mesusu nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->r37_funcao == null) || ($this->r37_funcao == "") ){ 
       $this->erro_sql = " Campo r37_funcao nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into funcao(
                                       r37_anousu 
                                      ,r37_mesusu 
                                      ,r37_funcao 
                                      ,r37_descr 
                                      ,r37_vagas 
                                      ,r37_cbo 
                                      ,r37_lei 
                                      ,r37_class 
                       )
                values (
                                $this->r37_anousu 
                               ,$this->r37_mesusu 
                               ,$this->r37_funcao 
                               ,'$this->r37_descr' 
                               ,$this->r37_vagas 
                               ,'$this->r37_cbo' 
                               ,$this->r37_lei 
                               ,'$this->r37_class' 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Cadastro de funcoes                                ($this->r37_anousu."-".$this->r37_mesusu."-".$this->r37_funcao) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Cadastro de funcoes                                já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Cadastro de funcoes                                ($this->r37_anousu."-".$this->r37_mesusu."-".$this->r37_funcao) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->r37_anousu."-".$this->r37_mesusu."-".$this->r37_funcao;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($r37_anousu=null,$r37_mesusu=null,$r37_funcao=null) { 
      $this->atualizacampos();
     $sql = " update funcao set ";
     $virgula = "";
     if(isset($GLOBALS["HTTP_POST_VARS"]["r37_anousu"])){ 
       $sql  .= $virgula." r37_anousu = $this->r37_anousu ";
       $virgula = ",";
       if($this->r37_anousu == null ){ 
         $this->erro_sql = " Campo Ano do Exercicio nao Informado.";
         $this->erro_campo = "r37_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["r37_mesusu"])){ 
       $sql  .= $virgula." r37_mesusu = $this->r37_mesusu ";
       $virgula = ",";
       if($this->r37_mesusu == null ){ 
         $this->erro_sql = " Campo Mes do Exercicio nao Informado.";
         $this->erro_campo = "r37_mesusu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["r37_funcao"])){ 
       $sql  .= $virgula." r37_funcao = $this->r37_funcao ";
       $virgula = ",";
       if($this->r37_funcao == null ){ 
         $this->erro_sql = " Campo Codigo da funcao nao Informado.";
         $this->erro_campo = "r37_funcao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["r37_descr"])){ 
       $sql  .= $virgula." r37_descr = '$this->r37_descr' ";
       $virgula = ",";
       if($this->r37_descr == null ){ 
         $this->erro_sql = " Campo Descricao da funcao nao Informado.";
         $this->erro_campo = "r37_descr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["r37_vagas"])){ 
       $sql  .= $virgula." r37_vagas = $this->r37_vagas ";
       $virgula = ",";
       if($this->r37_vagas == null ){ 
         $this->erro_sql = " Campo Numero de vagas nao Informado.";
         $this->erro_campo = "r37_vagas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["r37_cbo"])){ 
       $sql  .= $virgula." r37_cbo = '$this->r37_cbo' ";
       $virgula = ",";
       if($this->r37_cbo == null ){ 
         $this->erro_sql = " Campo Codigo Brasileiro de Ocupacoes nao Informado.";
         $this->erro_campo = "r37_cbo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["r37_lei"])){ 
       $sql  .= $virgula." r37_lei = $this->r37_lei ";
       $virgula = ",";
       if($this->r37_lei == null ){ 
         $this->erro_sql = " Campo Lei nao Informado.";
         $this->erro_campo = "r37_lei";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["r37_class"])){ 
       $sql  .= $virgula." r37_class = '$this->r37_class' ";
       $virgula = ",";
       if($this->r37_class == null ){ 
         $this->erro_sql = " Campo Classificação nao Informado.";
         $this->erro_campo = "r37_class";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  r37_anousu = $this->r37_anousu
 and  r37_mesusu = $this->r37_mesusu
 and  r37_funcao = $this->r37_funcao
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro de funcoes                                nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->r37_anousu."-".$this->r37_mesusu."-".$this->r37_funcao;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro de funcoes                                nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->r37_anousu."-".$this->r37_mesusu."-".$this->r37_funcao;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->r37_anousu."-".$this->r37_mesusu."-".$this->r37_funcao;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($r37_anousu=null,$r37_mesusu=null,$r37_funcao=null) { 
     $this->atualizacampos(true);
     $result = @pg_exec(" delete from funcao
                    where  r37_anousu = $this->r37_anousu
, r37_mesusu = $this->r37_mesusu
, r37_funcao = $this->r37_funcao
                    ");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro de funcoes                                nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->r37_anousu."-".$this->r37_mesusu."-".$this->r37_funcao;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro de funcoes                                nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->r37_anousu."-".$this->r37_mesusu."-".$this->r37_funcao;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->r37_anousu."-".$this->r37_mesusu."-".$this->r37_funcao;
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
   function sql_query ( $r37_anousu=null,$r37_mesusu=null,$r37_funcao=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from funcao ";
     $sql2 = "";
     if($dbwhere==""){
       if($r37_anousu!=null ){
         $sql2 .= " where funcao.r37_anousu = $r37_anousu "; 
       } 
       if($r37_mesusu!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " funcao.r37_mesusu = $r37_mesusu "; 
       } 
       if($r37_funcao!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " funcao.r37_funcao = $r37_funcao "; 
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
   function sql_query_file ( $r37_anousu=null,$r37_mesusu=null,$r37_funcao=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from funcao ";
     $sql2 = "";
     if($dbwhere==""){
       if($r37_anousu!=null ){
         $sql2 .= " where funcao.r37_anousu = $r37_anousu "; 
       } 
       if($r37_mesusu!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " funcao.r37_mesusu = $r37_mesusu "; 
       } 
       if($r37_funcao!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " funcao.r37_funcao = $r37_funcao "; 
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