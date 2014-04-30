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

//MODULO: empenho
//CLASSE DA ENTIDADE empparametro
class cl_empparametro { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $numrows_incluir = 0; 
   var $numrows_alterar = 0; 
   var $numrows_excluir = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $erro_campo = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $e39_anousu = 0; 
   var $e30_codemp = 0; 
   var $e30_nroviaaut = 0; 
   var $e30_nroviaemp = 0; 
   var $e30_nroviaord = 0; 
   var $e30_numdec = 0; 
   var $e30_opimportaresumo = 'f'; 
   var $e30_permconsempger = 'f'; 
   var $e30_autimportahist = 'f'; 
   var $e30_trazobsultop = 0; 
   var $e30_empdataemp = 'f'; 
   var $e30_empdataserv = 'f'; 
   var $e30_formvisuitemaut = 0; 
   var $e30_verificarmatordem = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 e39_anousu = int4 = Exercício 
                 e30_codemp = int8 = Código Empenho 
                 e30_nroviaaut = int4 = Vias na Autorização 
                 e30_nroviaemp = int4 = Vias no Empenho 
                 e30_nroviaord = int4 = Vias da Ordem 
                 e30_numdec = int4 = Casas decimais a imprimir 
                 e30_opimportaresumo = bool = Importar resumo do empenho 
                 e30_permconsempger = bool = Permite consulta empenho geral 
                 e30_autimportahist = bool = Importa Historico da ultima Autorização 
                 e30_trazobsultop = int4 = Traz observacoes da ultima ordem de pagamento 
                 e30_empdataemp = bool = Empenho c/ data anterior ao ultimo empenho 
                 e30_empdataserv = bool = Empenho c/ data superior ao servidor 
                 e30_formvisuitemaut = int4 = Visualização dos itens na autorização 
                 e30_verificarmatordem = int4 = Permite anular empenho com ordem de compra 
                 ";
   //funcao construtor da classe 
   function cl_empparametro() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("empparametro"); 
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
       $this->e39_anousu = ($this->e39_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["e39_anousu"]:$this->e39_anousu);
       $this->e30_codemp = ($this->e30_codemp == ""?@$GLOBALS["HTTP_POST_VARS"]["e30_codemp"]:$this->e30_codemp);
       $this->e30_nroviaaut = ($this->e30_nroviaaut == ""?@$GLOBALS["HTTP_POST_VARS"]["e30_nroviaaut"]:$this->e30_nroviaaut);
       $this->e30_nroviaemp = ($this->e30_nroviaemp == ""?@$GLOBALS["HTTP_POST_VARS"]["e30_nroviaemp"]:$this->e30_nroviaemp);
       $this->e30_nroviaord = ($this->e30_nroviaord == ""?@$GLOBALS["HTTP_POST_VARS"]["e30_nroviaord"]:$this->e30_nroviaord);
       $this->e30_numdec = ($this->e30_numdec == ""?@$GLOBALS["HTTP_POST_VARS"]["e30_numdec"]:$this->e30_numdec);
       $this->e30_opimportaresumo = ($this->e30_opimportaresumo == "f"?@$GLOBALS["HTTP_POST_VARS"]["e30_opimportaresumo"]:$this->e30_opimportaresumo);
       $this->e30_permconsempger = ($this->e30_permconsempger == "f"?@$GLOBALS["HTTP_POST_VARS"]["e30_permconsempger"]:$this->e30_permconsempger);
       $this->e30_autimportahist = ($this->e30_autimportahist == "f"?@$GLOBALS["HTTP_POST_VARS"]["e30_autimportahist"]:$this->e30_autimportahist);
       $this->e30_trazobsultop = ($this->e30_trazobsultop == ""?@$GLOBALS["HTTP_POST_VARS"]["e30_trazobsultop"]:$this->e30_trazobsultop);
       $this->e30_empdataemp = ($this->e30_empdataemp == "f"?@$GLOBALS["HTTP_POST_VARS"]["e30_empdataemp"]:$this->e30_empdataemp);
       $this->e30_empdataserv = ($this->e30_empdataserv == "f"?@$GLOBALS["HTTP_POST_VARS"]["e30_empdataserv"]:$this->e30_empdataserv);
       $this->e30_formvisuitemaut = ($this->e30_formvisuitemaut == ""?@$GLOBALS["HTTP_POST_VARS"]["e30_formvisuitemaut"]:$this->e30_formvisuitemaut);
       $this->e30_verificarmatordem = ($this->e30_verificarmatordem == ""?@$GLOBALS["HTTP_POST_VARS"]["e30_verificarmatordem"]:$this->e30_verificarmatordem);
     }else{
       $this->e39_anousu = ($this->e39_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["e39_anousu"]:$this->e39_anousu);
     }
   }
   // funcao para inclusao
   function incluir ($e39_anousu){ 
      $this->atualizacampos();
     if($this->e30_codemp == null ){ 
       $this->erro_sql = " Campo Código Empenho nao Informado.";
       $this->erro_campo = "e30_codemp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e30_nroviaaut == null ){ 
       $this->erro_sql = " Campo Vias na Autorização nao Informado.";
       $this->erro_campo = "e30_nroviaaut";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e30_nroviaemp == null ){ 
       $this->erro_sql = " Campo Vias no Empenho nao Informado.";
       $this->erro_campo = "e30_nroviaemp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e30_nroviaord == null ){ 
       $this->erro_sql = " Campo Vias da Ordem nao Informado.";
       $this->erro_campo = "e30_nroviaord";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e30_numdec == null ){ 
       $this->erro_sql = " Campo Casas decimais a imprimir nao Informado.";
       $this->erro_campo = "e30_numdec";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e30_opimportaresumo == null ){ 
       $this->erro_sql = " Campo Importar resumo do empenho nao Informado.";
       $this->erro_campo = "e30_opimportaresumo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e30_permconsempger == null ){ 
       $this->erro_sql = " Campo Permite consulta empenho geral nao Informado.";
       $this->erro_campo = "e30_permconsempger";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e30_autimportahist == null ){ 
       $this->erro_sql = " Campo Importa Historico da ultima Autorização nao Informado.";
       $this->erro_campo = "e30_autimportahist";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e30_trazobsultop == null ){ 
       $this->erro_sql = " Campo Traz observacoes da ultima ordem de pagamento nao Informado.";
       $this->erro_campo = "e30_trazobsultop";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e30_empdataemp == null ){ 
       $this->erro_sql = " Campo Empenho c/ data anterior ao ultimo empenho nao Informado.";
       $this->erro_campo = "e30_empdataemp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e30_empdataserv == null ){ 
       $this->erro_sql = " Campo Empenho c/ data superior ao servidor nao Informado.";
       $this->erro_campo = "e30_empdataserv";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e30_formvisuitemaut == null ){ 
       $this->erro_sql = " Campo Visualização dos itens na autorização nao Informado.";
       $this->erro_campo = "e30_formvisuitemaut";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e30_verificarmatordem == null ){ 
       $this->erro_sql = " Campo Permite anular empenho com ordem de compra nao Informado.";
       $this->erro_campo = "e30_verificarmatordem";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->e39_anousu = $e39_anousu; 
     if(($this->e39_anousu == null) || ($this->e39_anousu == "") ){ 
       $this->erro_sql = " Campo e39_anousu nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into empparametro(
                                       e39_anousu 
                                      ,e30_codemp 
                                      ,e30_nroviaaut 
                                      ,e30_nroviaemp 
                                      ,e30_nroviaord 
                                      ,e30_numdec 
                                      ,e30_opimportaresumo 
                                      ,e30_permconsempger 
                                      ,e30_autimportahist 
                                      ,e30_trazobsultop 
                                      ,e30_empdataemp 
                                      ,e30_empdataserv 
                                      ,e30_formvisuitemaut 
                                      ,e30_verificarmatordem 
                       )
                values (
                                $this->e39_anousu 
                               ,$this->e30_codemp 
                               ,$this->e30_nroviaaut 
                               ,$this->e30_nroviaemp 
                               ,$this->e30_nroviaord 
                               ,$this->e30_numdec 
                               ,'$this->e30_opimportaresumo' 
                               ,'$this->e30_permconsempger' 
                               ,'$this->e30_autimportahist' 
                               ,$this->e30_trazobsultop 
                               ,'$this->e30_empdataemp' 
                               ,'$this->e30_empdataserv' 
                               ,$this->e30_formvisuitemaut 
                               ,$this->e30_verificarmatordem 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Parametros do empenho ($this->e39_anousu) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Parametros do empenho já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Parametros do empenho ($this->e39_anousu) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_sql .= "Valores : ".$this->e39_anousu;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->e39_anousu));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,5675,'$this->e39_anousu','I')");
       $resac = pg_query("insert into db_acount values($acount,893,5675,'','".AddSlashes(pg_result($resaco,0,'e39_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,893,5674,'','".AddSlashes(pg_result($resaco,0,'e30_codemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,893,5676,'','".AddSlashes(pg_result($resaco,0,'e30_nroviaaut'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,893,5677,'','".AddSlashes(pg_result($resaco,0,'e30_nroviaemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,893,6371,'','".AddSlashes(pg_result($resaco,0,'e30_nroviaord'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,893,7641,'','".AddSlashes(pg_result($resaco,0,'e30_numdec'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,893,7816,'','".AddSlashes(pg_result($resaco,0,'e30_opimportaresumo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,893,7933,'','".AddSlashes(pg_result($resaco,0,'e30_permconsempger'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,893,8974,'','".AddSlashes(pg_result($resaco,0,'e30_autimportahist'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,893,9140,'','".AddSlashes(pg_result($resaco,0,'e30_trazobsultop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,893,9146,'','".AddSlashes(pg_result($resaco,0,'e30_empdataemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,893,9145,'','".AddSlashes(pg_result($resaco,0,'e30_empdataserv'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,893,9155,'','".AddSlashes(pg_result($resaco,0,'e30_formvisuitemaut'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ( $e39_anousu=null ) { 
      $this->atualizacampos();
     $sql = " update empparametro set ";
     $virgula = "";
     if(trim($this->e39_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e39_anousu"])){ 
       $sql  .= $virgula." e39_anousu = $this->e39_anousu ";
       $virgula = ",";
       if(trim($this->e39_anousu) == null ){ 
         $this->erro_sql = " Campo Exercício nao Informado.";
         $this->erro_campo = "e39_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_codemp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_codemp"])){ 
       $sql  .= $virgula." e30_codemp = $this->e30_codemp ";
       $virgula = ",";
       if(trim($this->e30_codemp) == null ){ 
         $this->erro_sql = " Campo Código Empenho nao Informado.";
         $this->erro_campo = "e30_codemp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_nroviaaut)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_nroviaaut"])){ 
       $sql  .= $virgula." e30_nroviaaut = $this->e30_nroviaaut ";
       $virgula = ",";
       if(trim($this->e30_nroviaaut) == null ){ 
         $this->erro_sql = " Campo Vias na Autorização nao Informado.";
         $this->erro_campo = "e30_nroviaaut";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_nroviaemp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_nroviaemp"])){ 
       $sql  .= $virgula." e30_nroviaemp = $this->e30_nroviaemp ";
       $virgula = ",";
       if(trim($this->e30_nroviaemp) == null ){ 
         $this->erro_sql = " Campo Vias no Empenho nao Informado.";
         $this->erro_campo = "e30_nroviaemp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_nroviaord)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_nroviaord"])){ 
       $sql  .= $virgula." e30_nroviaord = $this->e30_nroviaord ";
       $virgula = ",";
       if(trim($this->e30_nroviaord) == null ){ 
         $this->erro_sql = " Campo Vias da Ordem nao Informado.";
         $this->erro_campo = "e30_nroviaord";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_numdec)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_numdec"])){ 
       $sql  .= $virgula." e30_numdec = $this->e30_numdec ";
       $virgula = ",";
       if(trim($this->e30_numdec) == null ){ 
         $this->erro_sql = " Campo Casas decimais a imprimir nao Informado.";
         $this->erro_campo = "e30_numdec";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_opimportaresumo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_opimportaresumo"])){ 
       $sql  .= $virgula." e30_opimportaresumo = '$this->e30_opimportaresumo' ";
       $virgula = ",";
       if(trim($this->e30_opimportaresumo) == null ){ 
         $this->erro_sql = " Campo Importar resumo do empenho nao Informado.";
         $this->erro_campo = "e30_opimportaresumo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_permconsempger)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_permconsempger"])){ 
       $sql  .= $virgula." e30_permconsempger = '$this->e30_permconsempger' ";
       $virgula = ",";
       if(trim($this->e30_permconsempger) == null ){ 
         $this->erro_sql = " Campo Permite consulta empenho geral nao Informado.";
         $this->erro_campo = "e30_permconsempger";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_autimportahist)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_autimportahist"])){ 
       $sql  .= $virgula." e30_autimportahist = '$this->e30_autimportahist' ";
       $virgula = ",";
       if(trim($this->e30_autimportahist) == null ){ 
         $this->erro_sql = " Campo Importa Historico da ultima Autorização nao Informado.";
         $this->erro_campo = "e30_autimportahist";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_trazobsultop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_trazobsultop"])){ 
       $sql  .= $virgula." e30_trazobsultop = $this->e30_trazobsultop ";
       $virgula = ",";
       if(trim($this->e30_trazobsultop) == null ){ 
         $this->erro_sql = " Campo Traz observacoes da ultima ordem de pagamento nao Informado.";
         $this->erro_campo = "e30_trazobsultop";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_empdataemp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_empdataemp"])){ 
       $sql  .= $virgula." e30_empdataemp = '$this->e30_empdataemp' ";
       $virgula = ",";
       if(trim($this->e30_empdataemp) == null ){ 
         $this->erro_sql = " Campo Empenho c/ data anterior ao ultimo empenho nao Informado.";
         $this->erro_campo = "e30_empdataemp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_empdataserv)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_empdataserv"])){ 
       $sql  .= $virgula." e30_empdataserv = '$this->e30_empdataserv' ";
       $virgula = ",";
       if(trim($this->e30_empdataserv) == null ){ 
         $this->erro_sql = " Campo Empenho c/ data superior ao servidor nao Informado.";
         $this->erro_campo = "e30_empdataserv";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_formvisuitemaut)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_formvisuitemaut"])){ 
       $sql  .= $virgula." e30_formvisuitemaut = $this->e30_formvisuitemaut ";
       $virgula = ",";
       if(trim($this->e30_formvisuitemaut) == null ){ 
         $this->erro_sql = " Campo Visualização dos itens na autorização nao Informado.";
         $this->erro_campo = "e30_formvisuitemaut";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e30_verificarmatordem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e30_verificarmatordem"])){ 
       $sql  .= $virgula." e30_verificarmatordem = $this->e30_verificarmatordem ";
       $virgula = ",";
       if(trim($this->e30_verificarmatordem) == null ){ 
         $this->erro_sql = " Campo Permite anular empenho com ordem de compra nao Informado.";
         $this->erro_campo = "e30_verificarmatordem";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($e39_anousu!=null){
       $sql .= " e39_anousu = $this->e39_anousu";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->e39_anousu));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5675,'$this->e39_anousu','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e39_anousu"]))
           $resac = pg_query("insert into db_acount values($acount,893,5675,'".AddSlashes(pg_result($resaco,$conresaco,'e39_anousu'))."','$this->e39_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e30_codemp"]))
           $resac = pg_query("insert into db_acount values($acount,893,5674,'".AddSlashes(pg_result($resaco,$conresaco,'e30_codemp'))."','$this->e30_codemp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e30_nroviaaut"]))
           $resac = pg_query("insert into db_acount values($acount,893,5676,'".AddSlashes(pg_result($resaco,$conresaco,'e30_nroviaaut'))."','$this->e30_nroviaaut',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e30_nroviaemp"]))
           $resac = pg_query("insert into db_acount values($acount,893,5677,'".AddSlashes(pg_result($resaco,$conresaco,'e30_nroviaemp'))."','$this->e30_nroviaemp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e30_nroviaord"]))
           $resac = pg_query("insert into db_acount values($acount,893,6371,'".AddSlashes(pg_result($resaco,$conresaco,'e30_nroviaord'))."','$this->e30_nroviaord',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e30_numdec"]))
           $resac = pg_query("insert into db_acount values($acount,893,7641,'".AddSlashes(pg_result($resaco,$conresaco,'e30_numdec'))."','$this->e30_numdec',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e30_opimportaresumo"]))
           $resac = pg_query("insert into db_acount values($acount,893,7816,'".AddSlashes(pg_result($resaco,$conresaco,'e30_opimportaresumo'))."','$this->e30_opimportaresumo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e30_permconsempger"]))
           $resac = pg_query("insert into db_acount values($acount,893,7933,'".AddSlashes(pg_result($resaco,$conresaco,'e30_permconsempger'))."','$this->e30_permconsempger',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e30_autimportahist"]))
           $resac = pg_query("insert into db_acount values($acount,893,8974,'".AddSlashes(pg_result($resaco,$conresaco,'e30_autimportahist'))."','$this->e30_autimportahist',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e30_trazobsultop"]))
           $resac = pg_query("insert into db_acount values($acount,893,9140,'".AddSlashes(pg_result($resaco,$conresaco,'e30_trazobsultop'))."','$this->e30_trazobsultop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e30_empdataemp"]))
           $resac = pg_query("insert into db_acount values($acount,893,9146,'".AddSlashes(pg_result($resaco,$conresaco,'e30_empdataemp'))."','$this->e30_empdataemp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e30_empdataserv"]))
           $resac = pg_query("insert into db_acount values($acount,893,9145,'".AddSlashes(pg_result($resaco,$conresaco,'e30_empdataserv'))."','$this->e30_empdataserv',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e30_formvisuitemaut"]))
           $resac = pg_query("insert into db_acount values($acount,893,9155,'".AddSlashes(pg_result($resaco,$conresaco,'e30_formvisuitemaut'))."','$this->e30_formvisuitemaut',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Parametros do empenho nao Alterado. Alteracao Abortada.\\n";
       $this->erro_sql  .= "Valores : ".$this->e39_anousu;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Parametros do empenho nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->e39_anousu;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->e39_anousu;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ( $e39_anousu=null ,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($e39_anousu));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5675,'$e39_anousu','E')");
         $resac = pg_query("insert into db_acount values($acount,893,5675,'','".AddSlashes(pg_result($resaco,$iresaco,'e39_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,893,5674,'','".AddSlashes(pg_result($resaco,$iresaco,'e30_codemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,893,5676,'','".AddSlashes(pg_result($resaco,$iresaco,'e30_nroviaaut'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,893,5677,'','".AddSlashes(pg_result($resaco,$iresaco,'e30_nroviaemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,893,6371,'','".AddSlashes(pg_result($resaco,$iresaco,'e30_nroviaord'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,893,7641,'','".AddSlashes(pg_result($resaco,$iresaco,'e30_numdec'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,893,7816,'','".AddSlashes(pg_result($resaco,$iresaco,'e30_opimportaresumo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,893,7933,'','".AddSlashes(pg_result($resaco,$iresaco,'e30_permconsempger'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,893,8974,'','".AddSlashes(pg_result($resaco,$iresaco,'e30_autimportahist'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,893,9140,'','".AddSlashes(pg_result($resaco,$iresaco,'e30_trazobsultop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,893,9146,'','".AddSlashes(pg_result($resaco,$iresaco,'e30_empdataemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,893,9145,'','".AddSlashes(pg_result($resaco,$iresaco,'e30_empdataserv'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,893,9155,'','".AddSlashes(pg_result($resaco,$iresaco,'e30_formvisuitemaut'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from empparametro
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($e39_anousu != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " e39_anousu = $e39_anousu ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Parametros do empenho nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql  .= "Valores : ".$e39_anousu;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Parametros do empenho nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$e39_anousu;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$e39_anousu;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
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
        $this->erro_sql   = "Record Vazio na Tabela:empparametro";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $e39_anousu=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from empparametro ";
     $sql2 = "";
     if($dbwhere==""){
       if($e39_anousu!=null ){
         $sql2 .= " where empparametro.e39_anousu = $e39_anousu "; 
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
   function sql_query_file ($e39_anousu=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from empparametro ";
     $sql2 = "";
     if($dbwhere==""){
       if($e39_anousu!=null ){
         $sql2 .= " where empparametro.e39_anousu = $e39_anousu "; 
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