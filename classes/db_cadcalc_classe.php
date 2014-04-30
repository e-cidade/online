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

//MODULO: issqn
//CLASSE DA ENTIDADE cadcalc
class cl_cadcalc { 
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
   var $q85_codigo = 0; 
   var $q85_descr = null; 
   var $q85_uniref = 0; 
   var $q85_dtoper_dia = null; 
   var $q85_dtoper_mes = null; 
   var $q85_dtoper_ano = null; 
   var $q85_dtoper = null; 
   var $q85_codven = 0; 
   var $q85_var = 'f'; 
   var $q85_fixmes = 'f'; 
   var $q85_forcal = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 q85_codigo = int4 = Codigo do calculo 
                 q85_descr = varchar(40) = descricao do calculo 
                 q85_uniref = float8 = unidade de referencia 
                 q85_dtoper = date = data de operacao 
                 q85_codven = int4 = codigo do vencimento padrao 
                 q85_var = bool = Se variavel ou nao 
                 q85_fixmes = bool = configuracao do variavel fixado 
                 q85_forcal = int4 = forma de calculo 
                 ";
   //funcao construtor da classe 
   function cl_cadcalc() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("cadcalc"); 
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
       $this->q85_codigo = ($this->q85_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["q85_codigo"]:$this->q85_codigo);
       $this->q85_descr = ($this->q85_descr == ""?@$GLOBALS["HTTP_POST_VARS"]["q85_descr"]:$this->q85_descr);
       $this->q85_uniref = ($this->q85_uniref == ""?@$GLOBALS["HTTP_POST_VARS"]["q85_uniref"]:$this->q85_uniref);
       if($this->q85_dtoper == ""){
         $this->q85_dtoper_dia = @$GLOBALS["HTTP_POST_VARS"]["q85_dtoper_dia"];
         $this->q85_dtoper_mes = @$GLOBALS["HTTP_POST_VARS"]["q85_dtoper_mes"];
         $this->q85_dtoper_ano = @$GLOBALS["HTTP_POST_VARS"]["q85_dtoper_ano"];
         if($this->q85_dtoper_dia != ""){
            $this->q85_dtoper = $this->q85_dtoper_ano."-".$this->q85_dtoper_mes."-".$this->q85_dtoper_dia;
         }
       }
       $this->q85_codven = ($this->q85_codven == ""?@$GLOBALS["HTTP_POST_VARS"]["q85_codven"]:$this->q85_codven);
       $this->q85_var = ($this->q85_var == "f"?@$GLOBALS["HTTP_POST_VARS"]["q85_var"]:$this->q85_var);
       $this->q85_fixmes = ($this->q85_fixmes == "f"?@$GLOBALS["HTTP_POST_VARS"]["q85_fixmes"]:$this->q85_fixmes);
       $this->q85_forcal = ($this->q85_forcal == ""?@$GLOBALS["HTTP_POST_VARS"]["q85_forcal"]:$this->q85_forcal);
     }else{
       $this->q85_codigo = ($this->q85_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["q85_codigo"]:$this->q85_codigo);
     }
   }
   // funcao para inclusao
   function incluir ($q85_codigo){ 
      $this->atualizacampos();
     if($this->q85_descr == null ){ 
       $this->erro_sql = " Campo descricao do calculo nao Informado.";
       $this->erro_campo = "q85_descr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q85_uniref == null ){ 
       $this->erro_sql = " Campo unidade de referencia nao Informado.";
       $this->erro_campo = "q85_uniref";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q85_dtoper == null ){ 
       $this->erro_sql = " Campo data de operacao nao Informado.";
       $this->erro_campo = "q85_dtoper_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q85_codven == null ){ 
       $this->erro_sql = " Campo codigo do vencimento padrao nao Informado.";
       $this->erro_campo = "q85_codven";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q85_var == null ){ 
       $this->erro_sql = " Campo Se variavel ou nao nao Informado.";
       $this->erro_campo = "q85_var";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q85_fixmes == null ){ 
       $this->erro_sql = " Campo configuracao do variavel fixado nao Informado.";
       $this->erro_campo = "q85_fixmes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q85_forcal == null ){ 
       $this->erro_sql = " Campo forma de calculo nao Informado.";
       $this->erro_campo = "q85_forcal";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->q85_codigo = $q85_codigo; 
     if(($this->q85_codigo == null) || ($this->q85_codigo == "") ){ 
       $this->erro_sql = " Campo q85_codigo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into cadcalc(
                                       q85_codigo 
                                      ,q85_descr 
                                      ,q85_uniref 
                                      ,q85_dtoper 
                                      ,q85_codven 
                                      ,q85_var 
                                      ,q85_fixmes 
                                      ,q85_forcal 
                       )
                values (
                                $this->q85_codigo 
                               ,'$this->q85_descr' 
                               ,$this->q85_uniref 
                               ,".($this->q85_dtoper == "null" || $this->q85_dtoper == ""?"null":"'".$this->q85_dtoper."'")." 
                               ,$this->q85_codven 
                               ,'$this->q85_var' 
                               ,'$this->q85_fixmes' 
                               ,$this->q85_forcal 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = " ($this->q85_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = " já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = " ($this->q85_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->q85_codigo;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($q85_codigo=null) { 
      $this->atualizacampos();
     $sql = " update cadcalc set ";
     $virgula = "";
     if(isset($GLOBALS["HTTP_POST_VARS"]["q85_codigo"])){ 
       $sql  .= $virgula." q85_codigo = $this->q85_codigo ";
       $virgula = ",";
       if($this->q85_codigo == null ){ 
         $this->erro_sql = " Campo Codigo do calculo nao Informado.";
         $this->erro_campo = "q85_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["q85_descr"])){ 
       $sql  .= $virgula." q85_descr = '$this->q85_descr' ";
       $virgula = ",";
       if($this->q85_descr == null ){ 
         $this->erro_sql = " Campo descricao do calculo nao Informado.";
         $this->erro_campo = "q85_descr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["q85_uniref"])){ 
       $sql  .= $virgula." q85_uniref = $this->q85_uniref ";
       $virgula = ",";
       if($this->q85_uniref == null ){ 
         $this->erro_sql = " Campo unidade de referencia nao Informado.";
         $this->erro_campo = "q85_uniref";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["q85_dtoper_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["q85_dtoper_dia"] !="") ){ 
       $sql  .= $virgula." q85_dtoper = '$this->q85_dtoper' ";
       $virgula = ",";
       if($this->q85_dtoper == null ){ 
         $this->erro_sql = " Campo data de operacao nao Informado.";
         $this->erro_campo = "q85_dtoper_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       $sql  .= $virgula." q85_dtoper = null ";
       $virgula = ",";
       if($this->q85_dtoper == null ){ 
         $this->erro_sql = " Campo data de operacao nao Informado.";
         $this->erro_campo = "q85_dtoper_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["q85_codven"])){ 
       $sql  .= $virgula." q85_codven = $this->q85_codven ";
       $virgula = ",";
       if($this->q85_codven == null ){ 
         $this->erro_sql = " Campo codigo do vencimento padrao nao Informado.";
         $this->erro_campo = "q85_codven";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["q85_var"])){ 
       $sql  .= $virgula." q85_var = '$this->q85_var' ";
       $virgula = ",";
       if($this->q85_var == null ){ 
         $this->erro_sql = " Campo Se variavel ou nao nao Informado.";
         $this->erro_campo = "q85_var";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["q85_fixmes"])){ 
       $sql  .= $virgula." q85_fixmes = '$this->q85_fixmes' ";
       $virgula = ",";
       if($this->q85_fixmes == null ){ 
         $this->erro_sql = " Campo configuracao do variavel fixado nao Informado.";
         $this->erro_campo = "q85_fixmes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["q85_forcal"])){ 
       $sql  .= $virgula." q85_forcal = $this->q85_forcal ";
       $virgula = ",";
       if($this->q85_forcal == null ){ 
         $this->erro_sql = " Campo forma de calculo nao Informado.";
         $this->erro_campo = "q85_forcal";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  q85_codigo = $this->q85_codigo
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->q85_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->q85_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->q85_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($q85_codigo=null) { 
     $this->atualizacampos(true);
     $result = @pg_exec(" delete from cadcalc
                    where  q85_codigo = $this->q85_codigo
                    ");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->q85_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->q85_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->q85_codigo;
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
   function sql_query ( $q85_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from cadcalc ";
     $sql .= "      inner join cadvencdesc  on  cadvencdesc.q92_codigo = cadcalc.q85_codven";
     $sql .= "      inner join forcaldesc  on  forcaldesc.q87_codigo = cadcalc.q85_forcal";
     $sql .= "      inner join arretipo  on  arretipo.k00_tipo = cadvencdesc.q92_tipo";
     $sql .= "      inner join bancos  on  bancos.codbco = cadvencdesc.q92_codbco";
     $sql .= "      inner join cadban  on  cadban.k15_codbco = cadvencdesc.q92_codbco and  cadban.k15_codage = cadvencdesc.q92_codage";
     $sql2 = "";
     if($dbwhere==""){
       if($q85_codigo!=null ){
         $sql2 .= " where cadcalc.q85_codigo = $q85_codigo "; 
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
   function sql_query_file ( $q85_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from cadcalc ";
     $sql2 = "";
     if($dbwhere==""){
       if($q85_codigo!=null ){
         $sql2 .= " where cadcalc.q85_codigo = $q85_codigo "; 
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