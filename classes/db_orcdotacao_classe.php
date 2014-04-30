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

//MODULO: orcamento
//CLASSE DA ENTIDADE orcdotacao
class cl_orcdotacao { 
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
   var $o58_anousu = 0; 
   var $o58_coddot = 0; 
   var $o58_orgao = 0; 
   var $o58_unidade = 0; 
   var $o58_funcao = 0; 
   var $o58_subfuncao = 0; 
   var $o58_programa = 0; 
   var $o58_projativ = 0; 
   var $o58_codele = 0; 
   var $o58_codigo = 0; 
   var $o58_valor = 0; 
   var $o58_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 o58_anousu = int4 = Exercício 
                 o58_coddot = int4 = Código da Dotação 
                 o58_orgao = int4 = Código Orgão 
                 o58_unidade = int4 = Código Unidade 
                 o58_funcao = int4 = Código da Função 
                 o58_subfuncao = int4 = Sub Função 
                 o58_programa = int4 = Programas Orçamento 
                 o58_projativ = int4 = Projetos / Atividades 
                 o58_codele = int4 = Código Elemento 
                 o58_codigo = int4 = Codigo do Tipo de Recurso 
                 o58_valor = float8 = Previsão 
                 o58_instit = int4 = Institução 
                 ";
   //funcao construtor da classe 
   function cl_orcdotacao() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("orcdotacao"); 
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
       $this->o58_anousu = ($this->o58_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_anousu"]:$this->o58_anousu);
       $this->o58_coddot = ($this->o58_coddot == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_coddot"]:$this->o58_coddot);
       $this->o58_orgao = ($this->o58_orgao == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_orgao"]:$this->o58_orgao);
       $this->o58_unidade = ($this->o58_unidade == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_unidade"]:$this->o58_unidade);
       $this->o58_funcao = ($this->o58_funcao == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_funcao"]:$this->o58_funcao);
       $this->o58_subfuncao = ($this->o58_subfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_subfuncao"]:$this->o58_subfuncao);
       $this->o58_programa = ($this->o58_programa == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_programa"]:$this->o58_programa);
       $this->o58_projativ = ($this->o58_projativ == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_projativ"]:$this->o58_projativ);
       $this->o58_codele = ($this->o58_codele == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_codele"]:$this->o58_codele);
       $this->o58_codigo = ($this->o58_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_codigo"]:$this->o58_codigo);
       $this->o58_valor = ($this->o58_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_valor"]:$this->o58_valor);
       $this->o58_instit = ($this->o58_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_instit"]:$this->o58_instit);
     }else{
       $this->o58_anousu = ($this->o58_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_anousu"]:$this->o58_anousu);
       $this->o58_coddot = ($this->o58_coddot == ""?@$GLOBALS["HTTP_POST_VARS"]["o58_coddot"]:$this->o58_coddot);
     }
   }
   // funcao para inclusao
   function incluir ($o58_anousu,$o58_coddot){ 
      $this->atualizacampos();
     if($this->o58_orgao == null ){ 
       $this->erro_sql = " Campo Código Orgão nao Informado.";
       $this->erro_campo = "o58_orgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o58_unidade == null ){ 
       $this->erro_sql = " Campo Código Unidade nao Informado.";
       $this->erro_campo = "o58_unidade";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o58_funcao == null ){ 
       $this->erro_sql = " Campo Código da Função nao Informado.";
       $this->erro_campo = "o58_funcao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o58_subfuncao == null ){ 
       $this->erro_sql = " Campo Sub Função nao Informado.";
       $this->erro_campo = "o58_subfuncao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o58_programa == null ){ 
       $this->erro_sql = " Campo Programas Orçamento nao Informado.";
       $this->erro_campo = "o58_programa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o58_projativ == null ){ 
       $this->erro_sql = " Campo Projetos / Atividades nao Informado.";
       $this->erro_campo = "o58_projativ";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o58_codele == null ){ 
       $this->erro_sql = " Campo Código Elemento nao Informado.";
       $this->erro_campo = "o58_codele";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o58_codigo == null ){ 
       $this->erro_sql = " Campo Codigo do Tipo de Recurso nao Informado.";
       $this->erro_campo = "o58_codigo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o58_valor == null ){ 
       $this->erro_sql = " Campo Previsão nao Informado.";
       $this->erro_campo = "o58_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o58_instit == null ){ 
       $this->erro_sql = " Campo Institução nao Informado.";
       $this->erro_campo = "o58_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->o58_anousu = $o58_anousu; 
       $this->o58_coddot = $o58_coddot; 
     if(($this->o58_anousu == null) || ($this->o58_anousu == "") ){ 
       $this->erro_sql = " Campo o58_anousu nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->o58_coddot == null) || ($this->o58_coddot == "") ){ 
       $this->erro_sql = " Campo o58_coddot nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into orcdotacao(
                                       o58_anousu 
                                      ,o58_coddot 
                                      ,o58_orgao 
                                      ,o58_unidade 
                                      ,o58_funcao 
                                      ,o58_subfuncao 
                                      ,o58_programa 
                                      ,o58_projativ 
                                      ,o58_codele 
                                      ,o58_codigo 
                                      ,o58_valor 
                                      ,o58_instit 
                       )
                values (
                                $this->o58_anousu 
                               ,$this->o58_coddot 
                               ,$this->o58_orgao 
                               ,$this->o58_unidade 
                               ,$this->o58_funcao 
                               ,$this->o58_subfuncao 
                               ,$this->o58_programa 
                               ,$this->o58_projativ 
                               ,$this->o58_codele 
                               ,$this->o58_codigo 
                               ,$this->o58_valor 
                               ,$this->o58_instit 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Dotações Lançadas ($this->o58_anousu."-".$this->o58_coddot) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Dotações Lançadas já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Dotações Lançadas ($this->o58_anousu."-".$this->o58_coddot) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o58_anousu."-".$this->o58_coddot;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $resaco = $this->sql_record($this->sql_query_file($this->o58_anousu,$this->o58_coddot));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,5098,'$this->o58_anousu','I')");
       $resac = pg_query("insert into db_acountkey values($acount,5099,'$this->o58_coddot','I')");
       $resac = pg_query("insert into db_acount values($acount,728,5098,'','".pg_result($resaco,0,'o58_anousu')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,728,5099,'','".pg_result($resaco,0,'o58_coddot')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,728,5109,'','".pg_result($resaco,0,'o58_orgao')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,728,5110,'','".pg_result($resaco,0,'o58_unidade')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,728,5111,'','".pg_result($resaco,0,'o58_funcao')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,728,5113,'','".pg_result($resaco,0,'o58_subfuncao')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,728,5114,'','".pg_result($resaco,0,'o58_programa')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,728,5115,'','".pg_result($resaco,0,'o58_projativ')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,728,5116,'','".pg_result($resaco,0,'o58_codele')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,728,5117,'','".pg_result($resaco,0,'o58_codigo')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,728,5118,'','".pg_result($resaco,0,'o58_valor')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,728,5123,'','".pg_result($resaco,0,'o58_instit')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($o58_anousu=null,$o58_coddot=null) { 
      $this->atualizacampos();
     $sql = " update orcdotacao set ";
     $virgula = "";
     if(trim($this->o58_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o58_anousu"])){ 
       $sql  .= $virgula." o58_anousu = $this->o58_anousu ";
       $virgula = ",";
       if(trim($this->o58_anousu) == null ){ 
         $this->erro_sql = " Campo Exercício nao Informado.";
         $this->erro_campo = "o58_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o58_coddot)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o58_coddot"])){ 
       $sql  .= $virgula." o58_coddot = $this->o58_coddot ";
       $virgula = ",";
       if(trim($this->o58_coddot) == null ){ 
         $this->erro_sql = " Campo Código da Dotação nao Informado.";
         $this->erro_campo = "o58_coddot";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o58_orgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o58_orgao"])){ 
       $sql  .= $virgula." o58_orgao = $this->o58_orgao ";
       $virgula = ",";
       if(trim($this->o58_orgao) == null ){ 
         $this->erro_sql = " Campo Código Orgão nao Informado.";
         $this->erro_campo = "o58_orgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o58_unidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o58_unidade"])){ 
       $sql  .= $virgula." o58_unidade = $this->o58_unidade ";
       $virgula = ",";
       if(trim($this->o58_unidade) == null ){ 
         $this->erro_sql = " Campo Código Unidade nao Informado.";
         $this->erro_campo = "o58_unidade";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o58_funcao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o58_funcao"])){ 
       $sql  .= $virgula." o58_funcao = $this->o58_funcao ";
       $virgula = ",";
       if(trim($this->o58_funcao) == null ){ 
         $this->erro_sql = " Campo Código da Função nao Informado.";
         $this->erro_campo = "o58_funcao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o58_subfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o58_subfuncao"])){ 
       $sql  .= $virgula." o58_subfuncao = $this->o58_subfuncao ";
       $virgula = ",";
       if(trim($this->o58_subfuncao) == null ){ 
         $this->erro_sql = " Campo Sub Função nao Informado.";
         $this->erro_campo = "o58_subfuncao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o58_programa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o58_programa"])){ 
       $sql  .= $virgula." o58_programa = $this->o58_programa ";
       $virgula = ",";
       if(trim($this->o58_programa) == null ){ 
         $this->erro_sql = " Campo Programas Orçamento nao Informado.";
         $this->erro_campo = "o58_programa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o58_projativ)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o58_projativ"])){ 
       $sql  .= $virgula." o58_projativ = $this->o58_projativ ";
       $virgula = ",";
       if(trim($this->o58_projativ) == null ){ 
         $this->erro_sql = " Campo Projetos / Atividades nao Informado.";
         $this->erro_campo = "o58_projativ";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o58_codele)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o58_codele"])){ 
       $sql  .= $virgula." o58_codele = $this->o58_codele ";
       $virgula = ",";
       if(trim($this->o58_codele) == null ){ 
         $this->erro_sql = " Campo Código Elemento nao Informado.";
         $this->erro_campo = "o58_codele";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o58_codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o58_codigo"])){ 
       $sql  .= $virgula." o58_codigo = $this->o58_codigo ";
       $virgula = ",";
       if(trim($this->o58_codigo) == null ){ 
         $this->erro_sql = " Campo Codigo do Tipo de Recurso nao Informado.";
         $this->erro_campo = "o58_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o58_valor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o58_valor"])){ 
       $sql  .= $virgula." o58_valor = $this->o58_valor ";
       $virgula = ",";
       if(trim($this->o58_valor) == null ){ 
         $this->erro_sql = " Campo Previsão nao Informado.";
         $this->erro_campo = "o58_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o58_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o58_instit"])){ 
       $sql  .= $virgula." o58_instit = $this->o58_instit ";
       $virgula = ",";
       if(trim($this->o58_instit) == null ){ 
         $this->erro_sql = " Campo Institução nao Informado.";
         $this->erro_campo = "o58_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  o58_anousu = $this->o58_anousu
 and  o58_coddot = $this->o58_coddot
";
     $resaco = $this->sql_record($this->sql_query_file($this->o58_anousu,$this->o58_coddot));
     if($this->numrows>0){       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,5098,'$this->o58_anousu','A')");
       $resac = pg_query("insert into db_acountkey values($acount,5099,'$this->o58_coddot','A')");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o58_anousu"]))
         $resac = pg_query("insert into db_acount values($acount,728,5098,'".pg_result($resaco,0,'o58_anousu')."','$this->o58_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o58_coddot"]))
         $resac = pg_query("insert into db_acount values($acount,728,5099,'".pg_result($resaco,0,'o58_coddot')."','$this->o58_coddot',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o58_orgao"]))
         $resac = pg_query("insert into db_acount values($acount,728,5109,'".pg_result($resaco,0,'o58_orgao')."','$this->o58_orgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o58_unidade"]))
         $resac = pg_query("insert into db_acount values($acount,728,5110,'".pg_result($resaco,0,'o58_unidade')."','$this->o58_unidade',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o58_funcao"]))
         $resac = pg_query("insert into db_acount values($acount,728,5111,'".pg_result($resaco,0,'o58_funcao')."','$this->o58_funcao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o58_subfuncao"]))
         $resac = pg_query("insert into db_acount values($acount,728,5113,'".pg_result($resaco,0,'o58_subfuncao')."','$this->o58_subfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o58_programa"]))
         $resac = pg_query("insert into db_acount values($acount,728,5114,'".pg_result($resaco,0,'o58_programa')."','$this->o58_programa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o58_projativ"]))
         $resac = pg_query("insert into db_acount values($acount,728,5115,'".pg_result($resaco,0,'o58_projativ')."','$this->o58_projativ',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o58_codele"]))
         $resac = pg_query("insert into db_acount values($acount,728,5116,'".pg_result($resaco,0,'o58_codele')."','$this->o58_codele',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o58_codigo"]))
         $resac = pg_query("insert into db_acount values($acount,728,5117,'".pg_result($resaco,0,'o58_codigo')."','$this->o58_codigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o58_valor"]))
         $resac = pg_query("insert into db_acount values($acount,728,5118,'".pg_result($resaco,0,'o58_valor')."','$this->o58_valor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o58_instit"]))
         $resac = pg_query("insert into db_acount values($acount,728,5123,'".pg_result($resaco,0,'o58_instit')."','$this->o58_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Dotações Lançadas nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->o58_anousu."-".$this->o58_coddot;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Dotações Lançadas nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->o58_anousu."-".$this->o58_coddot;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o58_anousu."-".$this->o58_coddot;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($o58_anousu=null,$o58_coddot=null) { 
     $resaco = $this->sql_record($this->sql_query_file($o58_anousu,$o58_coddot));
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5098,'$this->o58_anousu','E')");
         $resac = pg_query("insert into db_acountkey values($acount,5099,'$this->o58_coddot','E')");
         $resac = pg_query("insert into db_acount values($acount,728,5098,'','".pg_result($resaco,$iresaco,'o58_anousu')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,728,5099,'','".pg_result($resaco,$iresaco,'o58_coddot')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,728,5109,'','".pg_result($resaco,$iresaco,'o58_orgao')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,728,5110,'','".pg_result($resaco,$iresaco,'o58_unidade')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,728,5111,'','".pg_result($resaco,$iresaco,'o58_funcao')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,728,5113,'','".pg_result($resaco,$iresaco,'o58_subfuncao')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,728,5114,'','".pg_result($resaco,$iresaco,'o58_programa')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,728,5115,'','".pg_result($resaco,$iresaco,'o58_projativ')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,728,5116,'','".pg_result($resaco,$iresaco,'o58_codele')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,728,5117,'','".pg_result($resaco,$iresaco,'o58_codigo')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,728,5118,'','".pg_result($resaco,$iresaco,'o58_valor')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,728,5123,'','".pg_result($resaco,$iresaco,'o58_instit')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from orcdotacao
                    where ";
     $sql2 = "";
      if($o58_anousu != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " o58_anousu = $o58_anousu ";
}
      if($o58_coddot != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " o58_coddot = $o58_coddot ";
}
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Dotações Lançadas nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$o58_anousu."-".$o58_coddot;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Dotações Lançadas nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$o58_anousu."-".$o58_coddot;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$o58_anousu."-".$o58_coddot;
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
   function sql_query_ele ( $o58_anousu=null,$o58_coddot=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcdotacao ";
     $sql .= "      inner join db_config  on  db_config.codigo = orcdotacao.o58_instit and db_config.codigo = ".db_getsession("DB_instit");
     $sql .= "      inner join orcelemento  on  orcelemento.o56_codele = orcdotacao.o58_codele";
     $sql2 = "";
     if($dbwhere==""){
       if($o58_anousu!=null ){
         $sql2 .= " where orcdotacao.o58_anousu = $o58_anousu "; 
       } 
       if($o58_coddot!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " orcdotacao.o58_coddot = $o58_coddot "; 
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
   function sql_query ( $o58_anousu=null,$o58_coddot=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     // não altere aqui sem contactar Paulo !
     $sql .= " from orcdotacao ";
     $sql .= "      inner join db_config  on  db_config.codigo = orcdotacao.o58_instit";
     $sql .= "      inner join orctiporec  on  orctiporec.o15_codigo = orcdotacao.o58_codigo";
     $sql .= "      inner join orcfuncao  on  orcfuncao.o52_funcao = orcdotacao.o58_funcao";
     $sql .= "      inner join orcsubfuncao  on  orcsubfuncao.o53_subfuncao = orcdotacao.o58_subfuncao";
     $sql .= "      inner join orcprograma  on  orcprograma.o54_anousu = orcdotacao.o58_anousu and  orcprograma.o54_programa = orcdotacao.o58_programa";
     $sql .= "      inner join orcprojativ  on  orcprojativ.o55_anousu = orcdotacao.o58_anousu and  orcprojativ.o55_projativ = orcdotacao.o58_projativ";
     $sql .= "      inner join orcelemento  on  orcelemento.o56_codele = orcdotacao.o58_codele";
     $sql .= "      inner join orcorgao  on  orcorgao.o40_anousu = orcdotacao.o58_anousu and  orcorgao.o40_orgao = orcdotacao.o58_orgao";
     $sql .= "      inner join orcunidade  on  orcunidade.o41_anousu = orcdotacao.o58_anousu and  orcunidade.o41_orgao = orcdotacao.o58_orgao and  orcunidade.o41_unidade = orcdotacao.o58_unidade";
     $sql .= "      inner join orcorgao  as d on   d.o40_anousu = orcunidade.o41_anousu and   d.o40_orgao = orcunidade.o41_orgao";
     $sql .= "      left outer join orcdotacaocontr  on orcdotacaocontr.o61_anousu = orcdotacao.o58_anousu and  orcdotacaocontr.o61_coddot = orcdotacao.o58_coddot";
     $sql2 = "";
     if($dbwhere==""){
       if($o58_anousu!=null ){
         $sql2 .= " where orcdotacao.o58_anousu = $o58_anousu "; 
       } 
       if($o58_coddot!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " orcdotacao.o58_coddot = $o58_coddot "; 
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
   function sql_query_file ( $o58_anousu=null,$o58_coddot=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcdotacao ";
     $sql2 = "";
     if($dbwhere==""){
       if($o58_anousu!=null ){
         $sql2 .= " where orcdotacao.o58_anousu = $o58_anousu "; 
       } 
       if($o58_coddot!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " orcdotacao.o58_coddot = $o58_coddot "; 
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