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
//CLASSE DA ENTIDADE issvar
class cl_issvar { 
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
   var $q05_codigo = 0; 
   var $q05_numpre = 0; 
   var $q05_numpar = 0; 
   var $q05_valor = 0; 
   var $q05_ano = 0; 
   var $q05_mes = 0; 
   var $q05_histor = null; 
   var $q05_aliq = 0; 
   var $q05_bruto = 0; 
   var $q05_vlrinf = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 q05_codigo = int8 = Código 
                 q05_numpre = int4 = numpre 
                 q05_numpar = int4 = Parcela 
                 q05_valor = float8 = valor 
                 q05_ano = int4 = ano 
                 q05_mes = int4 = mes 
                 q05_histor = text = historico 
                 q05_aliq = float8 = aliquota 
                 q05_bruto = float8 = valor bruto 
                 q05_vlrinf = float8 = valor contribuinte 
                 ";
   //funcao construtor da classe 
   function cl_issvar() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("issvar"); 
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
       $this->q05_codigo = ($this->q05_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["q05_codigo"]:$this->q05_codigo);
       $this->q05_numpre = ($this->q05_numpre == ""?@$GLOBALS["HTTP_POST_VARS"]["q05_numpre"]:$this->q05_numpre);
       $this->q05_numpar = ($this->q05_numpar == ""?@$GLOBALS["HTTP_POST_VARS"]["q05_numpar"]:$this->q05_numpar);
       $this->q05_valor = ($this->q05_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["q05_valor"]:$this->q05_valor);
       $this->q05_ano = ($this->q05_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["q05_ano"]:$this->q05_ano);
       $this->q05_mes = ($this->q05_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["q05_mes"]:$this->q05_mes);
       $this->q05_histor = ($this->q05_histor == ""?@$GLOBALS["HTTP_POST_VARS"]["q05_histor"]:$this->q05_histor);
       $this->q05_aliq = ($this->q05_aliq == ""?@$GLOBALS["HTTP_POST_VARS"]["q05_aliq"]:$this->q05_aliq);
       $this->q05_bruto = ($this->q05_bruto == ""?@$GLOBALS["HTTP_POST_VARS"]["q05_bruto"]:$this->q05_bruto);
       $this->q05_vlrinf = ($this->q05_vlrinf == ""?@$GLOBALS["HTTP_POST_VARS"]["q05_vlrinf"]:$this->q05_vlrinf);
     }else{
       $this->q05_codigo = ($this->q05_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["q05_codigo"]:$this->q05_codigo);
     }
   }
   // funcao para inclusao
   function incluir ($q05_codigo){ 
      $this->atualizacampos();
     if($this->q05_numpre == null ){ 
       $this->erro_sql = " Campo numpre nao Informado.";
       $this->erro_campo = "q05_numpre";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q05_numpar == null ){ 
       $this->erro_sql = " Campo Parcela nao Informado.";
       $this->erro_campo = "q05_numpar";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q05_valor == null ){ 
       $this->erro_sql = " Campo valor nao Informado.";
       $this->erro_campo = "q05_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q05_ano == null ){ 
       $this->erro_sql = " Campo ano nao Informado.";
       $this->erro_campo = "q05_ano";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q05_mes == null ){ 
       $this->erro_sql = " Campo mes nao Informado.";
       $this->erro_campo = "q05_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q05_aliq == null ){ 
       $this->erro_sql = " Campo aliquota nao Informado.";
       $this->erro_campo = "q05_aliq";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q05_bruto == null ){ 
       $this->erro_sql = " Campo valor bruto nao Informado.";
       $this->erro_campo = "q05_bruto";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q05_vlrinf == null ){ 
       $this->erro_sql = " Campo valor contribuinte nao Informado.";
       $this->erro_campo = "q05_vlrinf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($q05_codigo == "" || $q05_codigo == null ){
       $result = @pg_query("select nextval('issvar_q05_codigo_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: issvar_q05_codigo_seq do campo: q05_codigo"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->q05_codigo = pg_result($result,0,0); 
     }else{
       $result = @pg_query("select last_value from issvar_q05_codigo_seq");
       if(($result != false) && (pg_result($result,0,0) < $q05_codigo)){
         $this->erro_sql = " Campo q05_codigo maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->q05_codigo = $q05_codigo; 
       }
     }
     if(($this->q05_codigo == null) || ($this->q05_codigo == "") ){ 
       $this->erro_sql = " Campo q05_codigo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into issvar(
                                       q05_codigo 
                                      ,q05_numpre 
                                      ,q05_numpar 
                                      ,q05_valor 
                                      ,q05_ano 
                                      ,q05_mes 
                                      ,q05_histor 
                                      ,q05_aliq 
                                      ,q05_bruto 
                                      ,q05_vlrinf 
                       )
                values (
                                $this->q05_codigo 
                               ,$this->q05_numpre 
                               ,$this->q05_numpar 
                               ,$this->q05_valor 
                               ,$this->q05_ano 
                               ,$this->q05_mes 
                               ,'$this->q05_histor' 
                               ,$this->q05_aliq 
                               ,$this->q05_bruto 
                               ,$this->q05_vlrinf 
                      )";

     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = " ($this->q05_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = " já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = " ($this->q05_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->q05_codigo;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $resaco = $this->sql_record($this->sql_query_file($this->q05_codigo));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,4851,'$this->q05_codigo','I')");
       $resac = pg_query("insert into db_acount values($acount,63,4851,'','".AddSlashes(pg_result($resaco,0,'q05_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,63,326,'','".AddSlashes(pg_result($resaco,0,'q05_numpre'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,63,327,'','".AddSlashes(pg_result($resaco,0,'q05_numpar'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,63,328,'','".AddSlashes(pg_result($resaco,0,'q05_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,63,329,'','".AddSlashes(pg_result($resaco,0,'q05_ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,63,330,'','".AddSlashes(pg_result($resaco,0,'q05_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,63,331,'','".AddSlashes(pg_result($resaco,0,'q05_histor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,63,332,'','".AddSlashes(pg_result($resaco,0,'q05_aliq'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,63,333,'','".AddSlashes(pg_result($resaco,0,'q05_bruto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,63,334,'','".AddSlashes(pg_result($resaco,0,'q05_vlrinf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($q05_codigo=null) { 
      $this->atualizacampos();
     $sql = " update issvar set ";
     $virgula = "";
     if(trim($this->q05_codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q05_codigo"])){ 
       $sql  .= $virgula." q05_codigo = $this->q05_codigo ";
       $virgula = ",";
       if(trim($this->q05_codigo) == null ){ 
         $this->erro_sql = " Campo Código nao Informado.";
         $this->erro_campo = "q05_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q05_numpre)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q05_numpre"])){ 
       $sql  .= $virgula." q05_numpre = $this->q05_numpre ";
       $virgula = ",";
       if(trim($this->q05_numpre) == null ){ 
         $this->erro_sql = " Campo numpre nao Informado.";
         $this->erro_campo = "q05_numpre";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q05_numpar)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q05_numpar"])){ 
       $sql  .= $virgula." q05_numpar = $this->q05_numpar ";
       $virgula = ",";
       if(trim($this->q05_numpar) == null ){ 
         $this->erro_sql = " Campo Parcela nao Informado.";
         $this->erro_campo = "q05_numpar";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q05_valor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q05_valor"])){ 
       $sql  .= $virgula." q05_valor = $this->q05_valor ";
       $virgula = ",";
       if(trim($this->q05_valor) == null ){ 
         $this->erro_sql = " Campo valor nao Informado.";
         $this->erro_campo = "q05_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q05_ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q05_ano"])){ 
       $sql  .= $virgula." q05_ano = $this->q05_ano ";
       $virgula = ",";
       if(trim($this->q05_ano) == null ){ 
         $this->erro_sql = " Campo ano nao Informado.";
         $this->erro_campo = "q05_ano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q05_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q05_mes"])){ 
       $sql  .= $virgula." q05_mes = $this->q05_mes ";
       $virgula = ",";
       if(trim($this->q05_mes) == null ){ 
         $this->erro_sql = " Campo mes nao Informado.";
         $this->erro_campo = "q05_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q05_histor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q05_histor"])){ 
       $sql  .= $virgula." q05_histor = '$this->q05_histor' ";
       $virgula = ",";
     }
     if(trim($this->q05_aliq)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q05_aliq"])){ 
       $sql  .= $virgula." q05_aliq = $this->q05_aliq ";
       $virgula = ",";
       if(trim($this->q05_aliq) == null ){ 
         $this->erro_sql = " Campo aliquota nao Informado.";
         $this->erro_campo = "q05_aliq";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q05_bruto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q05_bruto"])){ 
       $sql  .= $virgula." q05_bruto = $this->q05_bruto ";
       $virgula = ",";
       if(trim($this->q05_bruto) == null ){ 
         $this->erro_sql = " Campo valor bruto nao Informado.";
         $this->erro_campo = "q05_bruto";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q05_vlrinf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q05_vlrinf"])){ 
       $sql  .= $virgula." q05_vlrinf = $this->q05_vlrinf ";
       $virgula = ",";
       if(trim($this->q05_vlrinf) == null ){ 
         $this->erro_sql = " Campo valor contribuinte nao Informado.";
         $this->erro_campo = "q05_vlrinf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  q05_codigo = $this->q05_codigo
";
     $resaco = $this->sql_record($this->sql_query_file($this->q05_codigo));
     if($this->numrows>0){       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,4851,'$this->q05_codigo','A')");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q05_codigo"]))
         $resac = pg_query("insert into db_acount values($acount,63,4851,'".AddSlashes(pg_result($resaco,0,'q05_codigo'))."','$this->q05_codigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q05_numpre"]))
         $resac = pg_query("insert into db_acount values($acount,63,326,'".AddSlashes(pg_result($resaco,0,'q05_numpre'))."','$this->q05_numpre',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q05_numpar"]))
         $resac = pg_query("insert into db_acount values($acount,63,327,'".AddSlashes(pg_result($resaco,0,'q05_numpar'))."','$this->q05_numpar',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q05_valor"]))
         $resac = pg_query("insert into db_acount values($acount,63,328,'".AddSlashes(pg_result($resaco,0,'q05_valor'))."','$this->q05_valor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q05_ano"]))
         $resac = pg_query("insert into db_acount values($acount,63,329,'".AddSlashes(pg_result($resaco,0,'q05_ano'))."','$this->q05_ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q05_mes"]))
         $resac = pg_query("insert into db_acount values($acount,63,330,'".AddSlashes(pg_result($resaco,0,'q05_mes'))."','$this->q05_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q05_histor"]))
         $resac = pg_query("insert into db_acount values($acount,63,331,'".AddSlashes(pg_result($resaco,0,'q05_histor'))."','$this->q05_histor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q05_aliq"]))
         $resac = pg_query("insert into db_acount values($acount,63,332,'".AddSlashes(pg_result($resaco,0,'q05_aliq'))."','$this->q05_aliq',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q05_bruto"]))
         $resac = pg_query("insert into db_acount values($acount,63,333,'".AddSlashes(pg_result($resaco,0,'q05_bruto'))."','$this->q05_bruto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q05_vlrinf"]))
         $resac = pg_query("insert into db_acount values($acount,63,334,'".AddSlashes(pg_result($resaco,0,'q05_vlrinf'))."','$this->q05_vlrinf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }

     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->q05_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->q05_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->q05_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($q05_codigo=null) { 
     $resaco = $this->sql_record($this->sql_query_file($q05_codigo));
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,4851,'".pg_result($resaco,$iresaco,'q05_codigo')."','E')");
         $resac = pg_query("insert into db_acount values($acount,63,4851,'','".AddSlashes(pg_result($resaco,$iresaco,'q05_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,63,326,'','".AddSlashes(pg_result($resaco,$iresaco,'q05_numpre'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,63,327,'','".AddSlashes(pg_result($resaco,$iresaco,'q05_numpar'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,63,328,'','".AddSlashes(pg_result($resaco,$iresaco,'q05_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,63,329,'','".AddSlashes(pg_result($resaco,$iresaco,'q05_ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,63,330,'','".AddSlashes(pg_result($resaco,$iresaco,'q05_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,63,331,'','".AddSlashes(pg_result($resaco,$iresaco,'q05_histor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,63,332,'','".AddSlashes(pg_result($resaco,$iresaco,'q05_aliq'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,63,333,'','".AddSlashes(pg_result($resaco,$iresaco,'q05_bruto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,63,334,'','".AddSlashes(pg_result($resaco,$iresaco,'q05_vlrinf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from issvar
                    where ";
     $sql2 = "";
      if($q05_codigo != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " q05_codigo = $q05_codigo ";
}
     $result = pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$q05_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$q05_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$q05_codigo;
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
        $this->erro_sql   = "Record Vazio na Tabela:issvar";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $q05_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from issvar ";
     $sql2 = "";
     if($dbwhere==""){
       if($q05_codigo!=null ){
         $sql2 .= " where issvar.q05_codigo = $q05_codigo "; 
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
   function sql_query_file ( $q05_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from issvar ";
     $sql2 = "";
     if($dbwhere==""){
       if($q05_codigo!=null ){
         $sql2 .= " where issvar.q05_codigo = $q05_codigo "; 
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
   function sql_query_arreinscr ( $q05_codigo=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from issvar ";
     $sql .= "      inner join arreinscr  on  issvar.q05_numpre = arreinscr.k00_numpre ";
     $sql.= "       left outer join arrecad   on  arreinscr.k00_numpre = arrecad.k00_numpre and issvar.q05_numpar=arrecad.k00_numpar ";
     $sql.= "       left outer join arrepaga  on  arreinscr.k00_numpre = arrepaga.k00_numpre and issvar.q05_numpar=arrepaga.k00_numpar ";

     $sql2 = "";
     if($dbwhere==""){
       if($q05_codigo!=null ){
         $sql2 .= " where issvar.q05_codigo = $q05_codigo ";
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
   function sql_query_arrenumcgm ( $q05_codigo=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from arrenumcgm ";
     $sql .= "      inner  join issvar  on  issvar.q05_numpre = arrenumcgm.k00_numpre ";
      $sql.= "       left outer join arrepaga  on  arrenumcgm.k00_numpre = arrepaga.k00_numpre and issvar.q05_numpar=arrepaga.k00_numpar ";

     $sql2 = "";
     if($dbwhere==""){
       if($q05_codigo!=null ){
         $sql2 .= " where issvar.q05_codigo = $q05_codigo ";
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
   function sql_query_arrecad ( $q05_codigo=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from issvar ";
     $sql .= "      inner join arreinscr  on  issvar.q05_numpre = arreinscr.k00_numpre ";
     $sql.= "       inner join arrecad   on  arreinscr.k00_numpre = arrecad.k00_numpre and issvar.q05_numpar=arrecad.k00_numpar ";

     $sql2 = "";
     if($dbwhere==""){
       if($q05_codigo!=null ){
         $sql2 .= " where issvar.q05_codigo = $q05_codigo ";
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
  function excluir_issvar($codigo,$codlev=0){
    $sql    = $this->sql_query_file($codigo); 
    $result = $this->sql_record($sql);
    $numrows = $this->numrows;
    if($numrows>0){

      $q05_codigo = pg_result($result,0,"q05_codigo");
      $q05_numpre = pg_result($result,0,"q05_numpre");
      $q05_numpar = pg_result($result,0,"q05_numpar");
      $q05_valor  = pg_result($result,0,"q05_valor");
      $q05_ano    = pg_result($result,0,"q05_ano");
      $q05_mes    = pg_result($result,0,"q05_mes");
      $q05_histor = pg_result($result,0,"q05_histor");
      $q05_aliq   = pg_result($result,0,"q05_aliq");
      $q05_bruto  = pg_result($result,0,"q05_bruto");
      $q05_vlrinf = pg_result($result,0,"q05_vlrinf");
 
      $sql_in = "insert into issvarold(
				  q22_codlev,
				  q22_codigo,
				  q22_numpre,
				  q22_numpar,
				  q22_valor ,
				  q22_ano   ,
				  q22_mes   ,
				  q22_histor,
				  q22_aliq  ,
				  q22_bruto ,
				  q22_vlrinf
		       )
                values (
				  '$codlev',
				  '$q05_codigo',
				  '$q05_numpre',
				  '$q05_numpar',
				  '$q05_valor' ,
				  '$q05_ano'   ,
				  '$q05_mes'   ,
				  '$q05_histor',
				  '$q05_aliq'  ,
				  '$q05_bruto' ,
				  '$q05_vlrinf'

		      )
		";
      $result = @pg_query($sql_in);
      if($result==false){	
            $this->erro_status="0";
            $this->erro_msg="Erro ao incluir em Issvarold";
      }else{
	//---exclui do issvar
	  $this->q05_codigo = $codigo;
	  $this->excluir($codigo);
	  $this->erro_msg;	
	//  $this->erro_status="0";
      }	
    }else{
        $this->erro_status="0";
        $this->erro_msg="Nenhum issvar encontrado com o código $codigo.";
    }
  }
  function sql_query_lev ( $q05_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from issvar ";
     $sql2 = "";
     if($dbwhere==""){
       if($q05_codigo!=null ){
         $sql2 .= " where issvar.q05_codigo = $q05_codigo "; 
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