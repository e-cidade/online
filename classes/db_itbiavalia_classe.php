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
//CLASSE DA ENTIDADE itbiavalia
class cl_itbiavalia { 
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
   var $it14_guia = 0; 
   var $it14_dtvenc_dia = null; 
   var $it14_dtvenc_mes = null; 
   var $it14_dtvenc_ano = null; 
   var $it14_dtvenc = null; 
   var $it14_dtliber_dia = null; 
   var $it14_dtliber_mes = null; 
   var $it14_dtliber_ano = null; 
   var $it14_dtliber = null; 
   var $it14_obs = null; 
   var $it14_valoraval = 0; 
   var $it14_valoravalfinanc = 0; 
   var $it14_valorpaga = 0; 
   var $it14_valoravalter = 0; 
   var $it14_valoravalterfinanc = 0; 
   var $it14_valoravalconstr = 0; 
   var $it14_valoravalconstrfinanc = 0; 
   var $it14_id_usuario = 0; 
   var $it14_hora = null; 
   var $it14_desc = 0; 
   var $it14_aliquota = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 it14_guia = int8 = Número da guia de ITBI 
                 it14_dtvenc = date = Data de vencimento 
                 it14_dtliber = date = Data da liberação 
                 it14_obs = text = Observações 
                 it14_valoraval = float8 = Valor da avaliação 
                 it14_valoravalfinanc = float8 = Valor financiado 
                 it14_valorpaga = float8 = Valor do pagamento 
                 it14_valoravalter = float8 = Valor da avaliação do terreno 
                 it14_valoravalterfinanc = float8 = Valor avaliado financiado 
                 it14_valoravalconstr = float8 = Valor da avaliação da Construção 
                 it14_valoravalconstrfinanc = float8 = Valor da contrução avaliado financiado 
                 it14_id_usuario = int4 = Cod. Usuário 
                 it14_hora = varchar(5) = Hora da liberação 
                 it14_desc = float8 = Desconto 
                 it14_aliquota = float4 = Alíquota 
                 ";
   //funcao construtor da classe 
   function cl_itbiavalia() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("itbiavalia"); 
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
       $this->it14_guia = ($this->it14_guia == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_guia"]:$this->it14_guia);
       if($this->it14_dtvenc == ""){
         $this->it14_dtvenc_dia = ($this->it14_dtvenc_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_dtvenc_dia"]:$this->it14_dtvenc_dia);
         $this->it14_dtvenc_mes = ($this->it14_dtvenc_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_dtvenc_mes"]:$this->it14_dtvenc_mes);
         $this->it14_dtvenc_ano = ($this->it14_dtvenc_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_dtvenc_ano"]:$this->it14_dtvenc_ano);
         if($this->it14_dtvenc_dia != ""){
            $this->it14_dtvenc = $this->it14_dtvenc_ano."-".$this->it14_dtvenc_mes."-".$this->it14_dtvenc_dia;
         }
       }
       if($this->it14_dtliber == ""){
         $this->it14_dtliber_dia = ($this->it14_dtliber_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_dtliber_dia"]:$this->it14_dtliber_dia);
         $this->it14_dtliber_mes = ($this->it14_dtliber_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_dtliber_mes"]:$this->it14_dtliber_mes);
         $this->it14_dtliber_ano = ($this->it14_dtliber_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_dtliber_ano"]:$this->it14_dtliber_ano);
         if($this->it14_dtliber_dia != ""){
            $this->it14_dtliber = $this->it14_dtliber_ano."-".$this->it14_dtliber_mes."-".$this->it14_dtliber_dia;
         }
       }
       $this->it14_obs = ($this->it14_obs == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_obs"]:$this->it14_obs);
       $this->it14_valoraval = ($this->it14_valoraval == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_valoraval"]:$this->it14_valoraval);
       $this->it14_valoravalfinanc = ($this->it14_valoravalfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_valoravalfinanc"]:$this->it14_valoravalfinanc);
       $this->it14_valorpaga = ($this->it14_valorpaga == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_valorpaga"]:$this->it14_valorpaga);
       $this->it14_valoravalter = ($this->it14_valoravalter == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_valoravalter"]:$this->it14_valoravalter);
       $this->it14_valoravalterfinanc = ($this->it14_valoravalterfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_valoravalterfinanc"]:$this->it14_valoravalterfinanc);
       $this->it14_valoravalconstr = ($this->it14_valoravalconstr == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_valoravalconstr"]:$this->it14_valoravalconstr);
       $this->it14_valoravalconstrfinanc = ($this->it14_valoravalconstrfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_valoravalconstrfinanc"]:$this->it14_valoravalconstrfinanc);
       $this->it14_id_usuario = ($this->it14_id_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_id_usuario"]:$this->it14_id_usuario);
       $this->it14_hora = ($this->it14_hora == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_hora"]:$this->it14_hora);
       $this->it14_desc = ($this->it14_desc == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_desc"]:$this->it14_desc);
       $this->it14_aliquota = ($this->it14_aliquota == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_aliquota"]:$this->it14_aliquota);
     }else{
       $this->it14_guia = ($this->it14_guia == ""?@$GLOBALS["HTTP_POST_VARS"]["it14_guia"]:$this->it14_guia);
     }
   }
   // funcao para inclusao
   function incluir ($it14_guia){ 
      $this->atualizacampos();
     if($this->it14_dtvenc == null ){ 
       $this->erro_sql = " Campo Data de vencimento nao Informado.";
       $this->erro_campo = "it14_dtvenc_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it14_dtliber == null ){ 
       $this->erro_sql = " Campo Data da liberação nao Informado.";
       $this->erro_campo = "it14_dtliber_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it14_valoraval == null ){ 
       $this->erro_sql = " Campo Valor da avaliação nao Informado.";
       $this->erro_campo = "it14_valoraval";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it14_valoravalfinanc == null ){ 
       $this->it14_valoravalfinanc = "0";
     }
     if($this->it14_valorpaga == null ){ 
       $this->erro_sql = " Campo Valor do pagamento nao Informado.";
       $this->erro_campo = "it14_valorpaga";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it14_valoravalter == null ){ 
       $this->erro_sql = " Campo Valor da avaliação do terreno nao Informado.";
       $this->erro_campo = "it14_valoravalter";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it14_valoravalterfinanc == null ){ 
       $this->it14_valoravalterfinanc = "0";
     }
     if($this->it14_valoravalconstr == null ){ 
       $this->erro_sql = " Campo Valor da avaliação da Construção nao Informado.";
       $this->erro_campo = "it14_valoravalconstr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it14_valoravalconstrfinanc == null ){ 
       $this->it14_valoravalconstrfinanc = "0";
     }
     if($this->it14_id_usuario == null ){ 
       $this->erro_sql = " Campo Cod. Usuário nao Informado.";
       $this->erro_campo = "it14_id_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it14_hora == null ){ 
       $this->erro_sql = " Campo Hora da liberação nao Informado.";
       $this->erro_campo = "it14_hora";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it14_desc == null ){ 
       $this->erro_sql = " Campo Desconto nao Informado.";
       $this->erro_campo = "it14_desc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->it14_aliquota == null ){ 
       $this->erro_sql = " Campo Alíquota nao Informado.";
       $this->erro_campo = "it14_aliquota";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->it14_guia = $it14_guia; 
     if(($this->it14_guia == null) || ($this->it14_guia == "") ){ 
       $this->erro_sql = " Campo it14_guia nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into itbiavalia(
                                       it14_guia 
                                      ,it14_dtvenc 
                                      ,it14_dtliber 
                                      ,it14_obs 
                                      ,it14_valoraval 
                                      ,it14_valoravalfinanc 
                                      ,it14_valorpaga 
                                      ,it14_valoravalter 
                                      ,it14_valoravalterfinanc 
                                      ,it14_valoravalconstr 
                                      ,it14_valoravalconstrfinanc 
                                      ,it14_id_usuario 
                                      ,it14_hora 
                                      ,it14_desc 
                                      ,it14_aliquota 
                       )
                values (
                                $this->it14_guia 
                               ,".($this->it14_dtvenc == "null" || $this->it14_dtvenc == ""?"null":"'".$this->it14_dtvenc."'")." 
                               ,".($this->it14_dtliber == "null" || $this->it14_dtliber == ""?"null":"'".$this->it14_dtliber."'")." 
                               ,'$this->it14_obs' 
                               ,$this->it14_valoraval 
                               ,$this->it14_valoravalfinanc 
                               ,$this->it14_valorpaga 
                               ,$this->it14_valoravalter 
                               ,$this->it14_valoravalterfinanc 
                               ,$this->it14_valoravalconstr 
                               ,$this->it14_valoravalconstrfinanc 
                               ,$this->it14_id_usuario 
                               ,'$this->it14_hora' 
                               ,$this->it14_desc 
                               ,$this->it14_aliquota 
                      )";
//     die($sql); 
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "tabela de avaliação do ITBI ($this->it14_guia) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "tabela de avaliação do ITBI já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "tabela de avaliação do ITBI ($this->it14_guia) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->it14_guia;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->it14_guia));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,5529,'$this->it14_guia','I')");
       $resac = pg_query("insert into db_acount values($acount,868,5529,'','".AddSlashes(pg_result($resaco,0,'it14_guia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,5530,'','".AddSlashes(pg_result($resaco,0,'it14_dtvenc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,5531,'','".AddSlashes(pg_result($resaco,0,'it14_dtliber'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,5534,'','".AddSlashes(pg_result($resaco,0,'it14_obs'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,5532,'','".AddSlashes(pg_result($resaco,0,'it14_valoraval'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,9436,'','".AddSlashes(pg_result($resaco,0,'it14_valoravalfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,5533,'','".AddSlashes(pg_result($resaco,0,'it14_valorpaga'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,5535,'','".AddSlashes(pg_result($resaco,0,'it14_valoravalter'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,9434,'','".AddSlashes(pg_result($resaco,0,'it14_valoravalterfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,5536,'','".AddSlashes(pg_result($resaco,0,'it14_valoravalconstr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,9435,'','".AddSlashes(pg_result($resaco,0,'it14_valoravalconstrfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,5537,'','".AddSlashes(pg_result($resaco,0,'it14_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,5538,'','".AddSlashes(pg_result($resaco,0,'it14_hora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,5539,'','".AddSlashes(pg_result($resaco,0,'it14_desc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,868,5540,'','".AddSlashes(pg_result($resaco,0,'it14_aliquota'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($it14_guia=null) { 
      $this->atualizacampos();
     $sql = " update itbiavalia set ";
     $virgula = "";
     if(trim($this->it14_guia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_guia"])){ 
       $sql  .= $virgula." it14_guia = $this->it14_guia ";
       $virgula = ",";
       if(trim($this->it14_guia) == null ){ 
         $this->erro_sql = " Campo Número da guia de ITBI nao Informado.";
         $this->erro_campo = "it14_guia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it14_dtvenc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_dtvenc_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["it14_dtvenc_dia"] !="") ){ 
       $sql  .= $virgula." it14_dtvenc = '$this->it14_dtvenc' ";
       $virgula = ",";
       if(trim($this->it14_dtvenc) == null ){ 
         $this->erro_sql = " Campo Data de vencimento nao Informado.";
         $this->erro_campo = "it14_dtvenc_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["it14_dtvenc_dia"])){ 
         $sql  .= $virgula." it14_dtvenc = null ";
         $virgula = ",";
         if(trim($this->it14_dtvenc) == null ){ 
           $this->erro_sql = " Campo Data de vencimento nao Informado.";
           $this->erro_campo = "it14_dtvenc_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->it14_dtliber)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_dtliber_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["it14_dtliber_dia"] !="") ){ 
       $sql  .= $virgula." it14_dtliber = '$this->it14_dtliber' ";
       $virgula = ",";
       if(trim($this->it14_dtliber) == null ){ 
         $this->erro_sql = " Campo Data da liberação nao Informado.";
         $this->erro_campo = "it14_dtliber_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["it14_dtliber_dia"])){ 
         $sql  .= $virgula." it14_dtliber = null ";
         $virgula = ",";
         if(trim($this->it14_dtliber) == null ){ 
           $this->erro_sql = " Campo Data da liberação nao Informado.";
           $this->erro_campo = "it14_dtliber_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->it14_obs)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_obs"])){ 
       $sql  .= $virgula." it14_obs = '$this->it14_obs' ";
       $virgula = ",";
     }
     if(trim($this->it14_valoraval)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_valoraval"])){ 
       $sql  .= $virgula." it14_valoraval = $this->it14_valoraval ";
       $virgula = ",";
       if(trim($this->it14_valoraval) == null ){ 
         $this->erro_sql = " Campo Valor da avaliação nao Informado.";
         $this->erro_campo = "it14_valoraval";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it14_valoravalfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalfinanc"])){ 
        if(trim($this->it14_valoravalfinanc)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalfinanc"])){ 
           $this->it14_valoravalfinanc = "0" ; 
        } 
       $sql  .= $virgula." it14_valoravalfinanc = $this->it14_valoravalfinanc ";
       $virgula = ",";
     }
     if(trim($this->it14_valorpaga)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_valorpaga"])){ 
       $sql  .= $virgula." it14_valorpaga = $this->it14_valorpaga ";
       $virgula = ",";
       if(trim($this->it14_valorpaga) == null ){ 
         $this->erro_sql = " Campo Valor do pagamento nao Informado.";
         $this->erro_campo = "it14_valorpaga";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it14_valoravalter)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalter"])){ 
       $sql  .= $virgula." it14_valoravalter = $this->it14_valoravalter ";
       $virgula = ",";
       if(trim($this->it14_valoravalter) == null ){ 
         $this->erro_sql = " Campo Valor da avaliação do terreno nao Informado.";
         $this->erro_campo = "it14_valoravalter";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it14_valoravalterfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalterfinanc"])){ 
        if(trim($this->it14_valoravalterfinanc)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalterfinanc"])){ 
           $this->it14_valoravalterfinanc = "0" ; 
        } 
       $sql  .= $virgula." it14_valoravalterfinanc = $this->it14_valoravalterfinanc ";
       $virgula = ",";
     }
     if(trim($this->it14_valoravalconstr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalconstr"])){ 
       $sql  .= $virgula." it14_valoravalconstr = $this->it14_valoravalconstr ";
       $virgula = ",";
       if(trim($this->it14_valoravalconstr) == null ){ 
         $this->erro_sql = " Campo Valor da avaliação da Construção nao Informado.";
         $this->erro_campo = "it14_valoravalconstr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it14_valoravalconstrfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalconstrfinanc"])){ 
        if(trim($this->it14_valoravalconstrfinanc)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalconstrfinanc"])){ 
           $this->it14_valoravalconstrfinanc = "0" ; 
        } 
       $sql  .= $virgula." it14_valoravalconstrfinanc = $this->it14_valoravalconstrfinanc ";
       $virgula = ",";
     }
     if(trim($this->it14_id_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_id_usuario"])){ 
       $sql  .= $virgula." it14_id_usuario = $this->it14_id_usuario ";
       $virgula = ",";
       if(trim($this->it14_id_usuario) == null ){ 
         $this->erro_sql = " Campo Cod. Usuário nao Informado.";
         $this->erro_campo = "it14_id_usuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it14_hora)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_hora"])){ 
       $sql  .= $virgula." it14_hora = '$this->it14_hora' ";
       $virgula = ",";
       if(trim($this->it14_hora) == null ){ 
         $this->erro_sql = " Campo Hora da liberação nao Informado.";
         $this->erro_campo = "it14_hora";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it14_desc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_desc"])){ 
       $sql  .= $virgula." it14_desc = $this->it14_desc ";
       $virgula = ",";
       if(trim($this->it14_desc) == null ){ 
         $this->erro_sql = " Campo Desconto nao Informado.";
         $this->erro_campo = "it14_desc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->it14_aliquota)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it14_aliquota"])){ 
       $sql  .= $virgula." it14_aliquota = $this->it14_aliquota ";
       $virgula = ",";
       if(trim($this->it14_aliquota) == null ){ 
         $this->erro_sql = " Campo Alíquota nao Informado.";
         $this->erro_campo = "it14_aliquota";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($it14_guia!=null){
       $sql .= " it14_guia = $this->it14_guia";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->it14_guia));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5529,'$this->it14_guia','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_guia"]))
           $resac = pg_query("insert into db_acount values($acount,868,5529,'".AddSlashes(pg_result($resaco,$conresaco,'it14_guia'))."','$this->it14_guia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_dtvenc"]))
           $resac = pg_query("insert into db_acount values($acount,868,5530,'".AddSlashes(pg_result($resaco,$conresaco,'it14_dtvenc'))."','$this->it14_dtvenc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_dtliber"]))
           $resac = pg_query("insert into db_acount values($acount,868,5531,'".AddSlashes(pg_result($resaco,$conresaco,'it14_dtliber'))."','$this->it14_dtliber',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_obs"]))
           $resac = pg_query("insert into db_acount values($acount,868,5534,'".AddSlashes(pg_result($resaco,$conresaco,'it14_obs'))."','$this->it14_obs',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_valoraval"]))
           $resac = pg_query("insert into db_acount values($acount,868,5532,'".AddSlashes(pg_result($resaco,$conresaco,'it14_valoraval'))."','$this->it14_valoraval',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalfinanc"]))
           $resac = pg_query("insert into db_acount values($acount,868,9436,'".AddSlashes(pg_result($resaco,$conresaco,'it14_valoravalfinanc'))."','$this->it14_valoravalfinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_valorpaga"]))
           $resac = pg_query("insert into db_acount values($acount,868,5533,'".AddSlashes(pg_result($resaco,$conresaco,'it14_valorpaga'))."','$this->it14_valorpaga',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalter"]))
           $resac = pg_query("insert into db_acount values($acount,868,5535,'".AddSlashes(pg_result($resaco,$conresaco,'it14_valoravalter'))."','$this->it14_valoravalter',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalterfinanc"]))
           $resac = pg_query("insert into db_acount values($acount,868,9434,'".AddSlashes(pg_result($resaco,$conresaco,'it14_valoravalterfinanc'))."','$this->it14_valoravalterfinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalconstr"]))
           $resac = pg_query("insert into db_acount values($acount,868,5536,'".AddSlashes(pg_result($resaco,$conresaco,'it14_valoravalconstr'))."','$this->it14_valoravalconstr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_valoravalconstrfinanc"]))
           $resac = pg_query("insert into db_acount values($acount,868,9435,'".AddSlashes(pg_result($resaco,$conresaco,'it14_valoravalconstrfinanc'))."','$this->it14_valoravalconstrfinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_id_usuario"]))
           $resac = pg_query("insert into db_acount values($acount,868,5537,'".AddSlashes(pg_result($resaco,$conresaco,'it14_id_usuario'))."','$this->it14_id_usuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_hora"]))
           $resac = pg_query("insert into db_acount values($acount,868,5538,'".AddSlashes(pg_result($resaco,$conresaco,'it14_hora'))."','$this->it14_hora',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_desc"]))
           $resac = pg_query("insert into db_acount values($acount,868,5539,'".AddSlashes(pg_result($resaco,$conresaco,'it14_desc'))."','$this->it14_desc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["it14_aliquota"]))
           $resac = pg_query("insert into db_acount values($acount,868,5540,'".AddSlashes(pg_result($resaco,$conresaco,'it14_aliquota'))."','$this->it14_aliquota',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "tabela de avaliação do ITBI nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->it14_guia;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "tabela de avaliação do ITBI nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->it14_guia;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->it14_guia;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($it14_guia=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($it14_guia));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5529,'$it14_guia','E')");
         $resac = pg_query("insert into db_acount values($acount,868,5529,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_guia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,5530,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_dtvenc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,5531,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_dtliber'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,5534,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_obs'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,5532,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_valoraval'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,9436,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_valoravalfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,5533,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_valorpaga'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,5535,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_valoravalter'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,9434,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_valoravalterfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,5536,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_valoravalconstr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,9435,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_valoravalconstrfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,5537,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,5538,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_hora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,5539,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_desc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,868,5540,'','".AddSlashes(pg_result($resaco,$iresaco,'it14_aliquota'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from itbiavalia
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($it14_guia != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " it14_guia = $it14_guia ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "tabela de avaliação do ITBI nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$it14_guia;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "tabela de avaliação do ITBI nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$it14_guia;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$it14_guia;
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
        $this->erro_sql   = "Record Vazio na Tabela:itbiavalia";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $it14_guia=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from itbiavalia ";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = itbiavalia.it14_id_usuario";
     $sql .= "      inner join itbi  on  itbi.it01_guia = itbiavalia.it14_guia";
     $sql .= "      inner join itbitransacao  on  itbitransacao.it04_codigo = itbi.it01_tipotransacao";
     $sql2 = "";
     if($dbwhere==""){
       if($it14_guia!=null ){
         $sql2 .= " where itbiavalia.it14_guia = $it14_guia "; 
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
   function sql_query_file ( $it14_guia=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from itbiavalia ";
     $sql2 = "";
     if($dbwhere==""){
       if($it14_guia!=null ){
         $sql2 .= " where itbiavalia.it14_guia = $it14_guia "; 
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