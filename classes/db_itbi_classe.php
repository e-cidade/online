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

//MODULO: itbi
//CLASSE DA ENTIDADE itbi
class cl_itbi { 
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
   var $it01_guia = 0; 
   var $it01_data_dia = null;
   var $it01_data_mes = null; 
   var $it01_data_ano = null; 
   var $it01_data = null; 
   var $it01_hora = null; 
   var $it01_tipotransacao = 0; 
   var $it01_areaterreno = 0; 
   var $it01_areaedificada = 0; 
   var $it01_obs = null; 
   var $it01_valortransacao = 0; 
   var $it01_valortransacaofinanc = 0; 
   var $it01_areatrans = 0; 
   var $it01_mail = null; 
   var $it01_finalizado = 'f'; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 it01_guia = int8 = Número da guia de ITBI 
                 it01_data = date = Data da solicitação 
                 it01_hora = varchar(5) = Hora da solicitação 
                 it01_tipotransacao = int8 = Código do tipo de transação 
                 it01_areaterreno = float8 = Àrea do terreno 
                 it01_areaedificada = float8 = Área edificada 
                 it01_obs = text = Observações dadas pelo comprador 
                 it01_valortransacao = float8 = Valor da transação 
                 it01_valortransacaofinanc = float8 = Valor financiado da transação 
                 it01_areatrans = float8 = Área transmitida do terreno 
                 it01_mail = varchar(50) = Mail de contato 
                 it01_finalizado = bool = Finalizado 
                 ";
   //funcao construtor da classe 
   function cl_itbi() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("itbi"); 
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
       $this->it01_guia = ($this->it01_guia == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_guia"]:$this->it01_guia);
       if($this->it01_data == ""){
         $this->it01_data_dia = ($this->it01_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_data_dia"]:$this->it01_data_dia);
         $this->it01_data_mes = ($this->it01_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_data_mes"]:$this->it01_data_mes);
         $this->it01_data_ano = ($this->it01_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_data_ano"]:$this->it01_data_ano);
         if($this->it01_data_dia != ""){
            $this->it01_data = $this->it01_data_ano."-".$this->it01_data_mes."-".$this->it01_data_dia;
         }
       }
       $this->it01_hora = ($this->it01_hora == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_hora"]:$this->it01_hora);
       $this->it01_tipotransacao = ($this->it01_tipotransacao == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_tipotransacao"]:$this->it01_tipotransacao);
       $this->it01_areaterreno = ($this->it01_areaterreno == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_areaterreno"]:$this->it01_areaterreno);
       $this->it01_areaedificada = ($this->it01_areaedificada == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_areaedificada"]:$this->it01_areaedificada);
       $this->it01_obs = ($this->it01_obs == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_obs"]:$this->it01_obs);
       $this->it01_valortransacao = ($this->it01_valortransacao == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_valortransacao"]:$this->it01_valortransacao);
       $this->it01_valortransacaofinanc = ($this->it01_valortransacaofinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_valortransacaofinanc"]:$this->it01_valortransacaofinanc);
       $this->it01_areatrans = ($this->it01_areatrans == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_areatrans"]:$this->it01_areatrans);
       $this->it01_mail = ($this->it01_mail == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_mail"]:$this->it01_mail);
       $this->it01_finalizado = ($this->it01_finalizado == "f"?@$GLOBALS["HTTP_POST_VARS"]["it01_finalizado"]:$this->it01_finalizado);
     }else{
       $this->it01_guia = ($this->it01_guia == ""?@$GLOBALS["HTTP_POST_VARS"]["it01_guia"]:$this->it01_guia);
     }
   }
   // funcao para inclusao
   function incluir ($it01_guia){ 
      $this->atualizacampos();
     if($this->it01_data == null ){ 
       $this->erro_sql = " Campo Data da solicitação nao Informado.";
       $this->erro_campo = "it01_data_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it01_hora == null ){ 
       $this->erro_sql = " Campo Hora da solicitação nao Informado.";
       $this->erro_campo = "it01_hora";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it01_tipotransacao == null ){ 
       $this->erro_sql = " Campo Código do tipo de transação nao Informado.";
       $this->erro_campo = "it01_tipotransacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it01_areaterreno == null ){ 
       $this->erro_sql = " Campo Àrea do terreno nao Informado.";
       $this->erro_campo = "it01_areaterreno";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it01_areaedificada == null ){ 
       $this->erro_sql = " Campo Área edificada nao Informado.";
       $this->erro_campo = "it01_areaedificada";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it01_valortransacao == null ){ 
       $this->erro_sql = " Campo Valor da transação nao Informado.";
       $this->erro_campo = "it01_valortransacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it01_valortransacaofinanc == null ){ 
       $this->it01_valortransacaofinanc = "0";
     }
     if($this->it01_areatrans == null ){ 
       $this->erro_sql = " Campo Área transmitida do terreno nao Informado.";
       $this->erro_campo = "it01_areatrans";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it01_finalizado == null ){ 
       $this->it01_finalizado = "f";
     }
     if($it01_guia == "" || $it01_guia == null ){
       $result = @pg_query("select nextval('itbi_it01_guia_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: itbi_it01_guia_seq do campo: it01_guia"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->it01_guia = pg_result($result,0,0); 
     }else{
       $result = @pg_query("select last_value from itbi_it01_guia_seq");
       if(($result != false) && (pg_result($result,0,0) < $it01_guia)){
         $this->erro_sql = " Campo it01_guia maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->it01_guia = $it01_guia; 
       }
     }
     if(($this->it01_guia == null) || ($this->it01_guia == "") ){ 
       $this->erro_sql = " Campo it01_guia nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into itbi(
                                       it01_guia 
                                      ,it01_data 
                                      ,it01_hora 
                                      ,it01_tipotransacao 
                                      ,it01_areaterreno 
                                      ,it01_areaedificada 
                                      ,it01_obs 
                                      ,it01_valortransacao 
                                      ,it01_valortransacaofinanc 
                                      ,it01_areatrans 
                                      ,it01_mail 
                                      ,it01_finalizado 
                       )
                values (
                                $this->it01_guia 
                               ,".($this->it01_data == "null" || $this->it01_data == ""?"null":"'".$this->it01_data."'")." 
                               ,'$this->it01_hora' 
                               ,$this->it01_tipotransacao 
                               ,$this->it01_areaterreno 
                               ,$this->it01_areaedificada 
                               ,'$this->it01_obs' 
                               ,$this->it01_valortransacao 
                               ,$this->it01_valortransacaofinanc 
                               ,$this->it01_areatrans 
                               ,'$this->it01_mail' 
                               ,'$this->it01_finalizado' 
                      )";
   //  die($sql);
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ITBI ($this->it01_guia) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ITBI já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ITBI ($this->it01_guia) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->it01_guia;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->it01_guia));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,5395,'$this->it01_guia','I')");
       $resac = pg_query("insert into db_acount values($acount,792,5395,'','".AddSlashes(pg_result($resaco,0,'it01_guia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,792,5393,'','".AddSlashes(pg_result($resaco,0,'it01_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,792,5394,'','".AddSlashes(pg_result($resaco,0,'it01_hora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,792,5398,'','".AddSlashes(pg_result($resaco,0,'it01_tipotransacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,792,5389,'','".AddSlashes(pg_result($resaco,0,'it01_areaterreno'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,792,5390,'','".AddSlashes(pg_result($resaco,0,'it01_areaedificada'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,792,5392,'','".AddSlashes(pg_result($resaco,0,'it01_obs'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,792,5402,'','".AddSlashes(pg_result($resaco,0,'it01_valortransacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,792,9433,'','".AddSlashes(pg_result($resaco,0,'it01_valortransacaofinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,792,5411,'','".AddSlashes(pg_result($resaco,0,'it01_areatrans'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,792,5415,'','".AddSlashes(pg_result($resaco,0,'it01_mail'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,792,9630,'','".AddSlashes(pg_result($resaco,0,'it01_finalizado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($it01_guia=null) { 
      $this->atualizacampos();
     $sql = " update itbi set ";
     $virgula = "";
     if(trim($this->it01_guia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it01_guia"])){ 
       $sql  .= $virgula." it01_guia = $this->it01_guia ";
       $virgula = ",";
       if(trim($this->it01_guia) == null ){ 
         $this->erro_sql = " Campo Número da guia de ITBI nao Informado.";
         $this->erro_campo = "it01_guia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it01_data)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it01_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["it01_data_dia"] !="") ){ 
       $sql  .= $virgula." it01_data = '$this->it01_data' ";
       $virgula = ",";
       if(trim($this->it01_data) == null ){ 
         $this->erro_sql = " Campo Data da solicitação nao Informado.";
         $this->erro_campo = "it01_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["it01_data_dia"])){ 
         $sql  .= $virgula." it01_data = null ";
         $virgula = ",";
         if(trim($this->it01_data) == null ){ 
           $this->erro_sql = " Campo Data da solicitação nao Informado.";
           $this->erro_campo = "it01_data_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->it01_hora)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it01_hora"])){ 
       $sql  .= $virgula." it01_hora = '$this->it01_hora' ";
       $virgula = ",";
       if(trim($this->it01_hora) == null ){ 
         $this->erro_sql = " Campo Hora da solicitação nao Informado.";
         $this->erro_campo = "it01_hora";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it01_tipotransacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it01_tipotransacao"])){ 
       $sql  .= $virgula." it01_tipotransacao = $this->it01_tipotransacao ";
       $virgula = ",";
       if(trim($this->it01_tipotransacao) == null ){ 
         $this->erro_sql = " Campo Código do tipo de transação nao Informado.";
         $this->erro_campo = "it01_tipotransacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it01_areaterreno)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it01_areaterreno"])){ 
       $sql  .= $virgula." it01_areaterreno = $this->it01_areaterreno ";
       $virgula = ",";
       if(trim($this->it01_areaterreno) == null ){ 
         $this->erro_sql = " Campo Àrea do terreno nao Informado.";
         $this->erro_campo = "it01_areaterreno";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it01_areaedificada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it01_areaedificada"])){ 
       $sql  .= $virgula." it01_areaedificada = $this->it01_areaedificada ";
       $virgula = ",";
       if(trim($this->it01_areaedificada) == null ){ 
         $this->erro_sql = " Campo Área edificada nao Informado.";
         $this->erro_campo = "it01_areaedificada";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it01_obs)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it01_obs"])){ 
       $sql  .= $virgula." it01_obs = '$this->it01_obs' ";
       $virgula = ",";
     }
     if(trim($this->it01_valortransacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it01_valortransacao"])){ 
       $sql  .= $virgula." it01_valortransacao = $this->it01_valortransacao ";
       $virgula = ",";
       if(trim($this->it01_valortransacao) == null ){ 
         $this->erro_sql = " Campo Valor da transação nao Informado.";
         $this->erro_campo = "it01_valortransacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it01_valortransacaofinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it01_valortransacaofinanc"])){ 
        if(trim($this->it01_valortransacaofinanc)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it01_valortransacaofinanc"])){ 
           $this->it01_valortransacaofinanc = "0" ; 
        } 
       $sql  .= $virgula." it01_valortransacaofinanc = $this->it01_valortransacaofinanc ";
       $virgula = ",";
     }
     if(trim($this->it01_areatrans)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it01_areatrans"])){ 
       $sql  .= $virgula." it01_areatrans = $this->it01_areatrans ";
       $virgula = ",";
       if(trim($this->it01_areatrans) == null ){ 
         $this->erro_sql = " Campo Área transmitida do terreno nao Informado.";
         $this->erro_campo = "it01_areatrans";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it01_mail)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it01_mail"])){ 
       $sql  .= $virgula." it01_mail = '$this->it01_mail' ";
       $virgula = ",";
     }
     if(trim($this->it01_finalizado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it01_finalizado"])){ 
       $sql  .= $virgula." it01_finalizado = '$this->it01_finalizado' ";
       $virgula = ",";
     }
     $sql .= " where ";
     if($it01_guia!=null){
       $sql .= " it01_guia = $this->it01_guia";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->it01_guia));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5395,'$this->it01_guia','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it01_guia"]))
           $resac = pg_query("insert into db_acount values($acount,792,5395,'".AddSlashes(pg_result($resaco,$conresaco,'it01_guia'))."','$this->it01_guia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it01_data"]))
           $resac = pg_query("insert into db_acount values($acount,792,5393,'".AddSlashes(pg_result($resaco,$conresaco,'it01_data'))."','$this->it01_data',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it01_hora"]))
           $resac = pg_query("insert into db_acount values($acount,792,5394,'".AddSlashes(pg_result($resaco,$conresaco,'it01_hora'))."','$this->it01_hora',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it01_tipotransacao"]))
           $resac = pg_query("insert into db_acount values($acount,792,5398,'".AddSlashes(pg_result($resaco,$conresaco,'it01_tipotransacao'))."','$this->it01_tipotransacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it01_areaterreno"]))
           $resac = pg_query("insert into db_acount values($acount,792,5389,'".AddSlashes(pg_result($resaco,$conresaco,'it01_areaterreno'))."','$this->it01_areaterreno',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it01_areaedificada"]))
           $resac = pg_query("insert into db_acount values($acount,792,5390,'".AddSlashes(pg_result($resaco,$conresaco,'it01_areaedificada'))."','$this->it01_areaedificada',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it01_obs"]))
           $resac = pg_query("insert into db_acount values($acount,792,5392,'".AddSlashes(pg_result($resaco,$conresaco,'it01_obs'))."','$this->it01_obs',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it01_valortransacao"]))
           $resac = pg_query("insert into db_acount values($acount,792,5402,'".AddSlashes(pg_result($resaco,$conresaco,'it01_valortransacao'))."','$this->it01_valortransacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it01_valortransacaofinanc"]))
           $resac = pg_query("insert into db_acount values($acount,792,9433,'".AddSlashes(pg_result($resaco,$conresaco,'it01_valortransacaofinanc'))."','$this->it01_valortransacaofinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it01_areatrans"]))
           $resac = pg_query("insert into db_acount values($acount,792,5411,'".AddSlashes(pg_result($resaco,$conresaco,'it01_areatrans'))."','$this->it01_areatrans',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it01_mail"]))
           $resac = pg_query("insert into db_acount values($acount,792,5415,'".AddSlashes(pg_result($resaco,$conresaco,'it01_mail'))."','$this->it01_mail',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it01_finalizado"]))
           $resac = pg_query("insert into db_acount values($acount,792,9630,'".AddSlashes(pg_result($resaco,$conresaco,'it01_finalizado'))."','$this->it01_finalizado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     //die("xxxx ".$sql);
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ITBI nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->it01_guia;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ITBI nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->it01_guia;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->it01_guia;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($it01_guia=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($it01_guia));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5395,'$it01_guia','E')");
         $resac = pg_query("insert into db_acount values($acount,792,5395,'','".AddSlashes(pg_result($resaco,$iresaco,'it01_guia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,792,5393,'','".AddSlashes(pg_result($resaco,$iresaco,'it01_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,792,5394,'','".AddSlashes(pg_result($resaco,$iresaco,'it01_hora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,792,5398,'','".AddSlashes(pg_result($resaco,$iresaco,'it01_tipotransacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,792,5389,'','".AddSlashes(pg_result($resaco,$iresaco,'it01_areaterreno'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,792,5390,'','".AddSlashes(pg_result($resaco,$iresaco,'it01_areaedificada'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,792,5392,'','".AddSlashes(pg_result($resaco,$iresaco,'it01_obs'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,792,5402,'','".AddSlashes(pg_result($resaco,$iresaco,'it01_valortransacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,792,9433,'','".AddSlashes(pg_result($resaco,$iresaco,'it01_valortransacaofinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,792,5411,'','".AddSlashes(pg_result($resaco,$iresaco,'it01_areatrans'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,792,5415,'','".AddSlashes(pg_result($resaco,$iresaco,'it01_mail'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,792,9630,'','".AddSlashes(pg_result($resaco,$iresaco,'it01_finalizado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from itbi
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($it01_guia != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " it01_guia = $it01_guia ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ITBI nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$it01_guia;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ITBI nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$it01_guia;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$it01_guia;
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
        $this->erro_sql   = "Record Vazio na Tabela:itbi";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $it01_guia=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from itbi ";
     $sql .= "      inner join itbitransacao  on  itbitransacao.it04_codigo = itbi.it01_tipotransacao";
     $sql2 = "";
     if($dbwhere==""){
       if($it01_guia!=null ){
         $sql2 .= " where itbi.it01_guia = $it01_guia "; 
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
   function sql_query_file ( $it01_guia=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from itbi ";
     $sql2 = "";
     if($dbwhere==""){
       if($it01_guia!=null ){
         $sql2 .= " where itbi.it01_guia = $it01_guia "; 
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
   /*function sql_query_lib ( $it01_guia=null,$campos="*",$ordem=null,$dbwhere=""){
$sql = "select ";
if($campos != "*" ){
$campos_sql = split("#",$campos);
$virgula = "";
for($i=0;$i
$sql .= $virgula.$campos_sql[$i];
$virgula = ",";
}
}else{
$sql .= $campos;
}
$sql .= " from itbi ";
$sql .= " inner join itbitransacao on itbitransacao.it04_codigo = itbi.it01_tipotransacao";
$sql .= " inner join itbiavalia on itbiavalia.it14_guia = itbi.it01_guia";
$sql2 = "";
if($dbwhere==""){
if($it01_guia!=null ){
$sql2 .= " where itbi.it01_guia = $it01_guia ";
}
}else if($dbwhere != ""){
$sql2 = " where $dbwhere";
}
$sql .= $sql2;
if($ordem != null ){
$sql .= " order by ";
$campos_sql = split("#",$ordem);
$virgula = "";
for($i=0;$i
$sql .= $virgula.$campos_sql[$i];
$virgula = ",";
}
}
return $sql;
}*/
}
?>