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

//MODULO: divida ativa
//CLASSE DA ENTIDADE termo
class cl_termo { 
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
   var $v07_parcel = 0; 
   var $v07_dtlanc_dia = null; 
   var $v07_dtlanc_mes = null; 
   var $v07_dtlanc_ano = null; 
   var $v07_dtlanc = null; 
   var $v07_valor = 0; 
   var $v07_numpre = 0; 
   var $v07_totpar = 0; 
   var $v07_vlrpar = 0; 
   var $v07_dtvenc_dia = null; 
   var $v07_dtvenc_mes = null; 
   var $v07_dtvenc_ano = null; 
   var $v07_dtvenc = null; 
   var $v07_vlrent = 0; 
   var $v07_datpri_dia = null; 
   var $v07_datpri_mes = null; 
   var $v07_datpri_ano = null; 
   var $v07_datpri = null; 
   var $v07_vlrmul = 0; 
   var $v07_vlrjur = 0; 
   var $v07_perjur = 0; 
   var $v07_permul = 0; 
   var $v07_login = null; 
   var $v07_mtermo = 0; 
   var $v07_numcgm = 0; 
   var $v07_hist = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 v07_parcel = int4 = codigo do parcelamento 
                 v07_dtlanc = date = data de lancamento do parcelamento 
                 v07_valor = float8 = valor do parcelamento 
                 v07_numpre = int4 = numpre do parcelamento 
                 v07_totpar = int4 = total de parcelas 
                 v07_vlrpar = float8 = valor das parcelas 
                 v07_dtvenc = date = data de vencimento 
                 v07_vlrent = float8 = valor da entrada 
                 v07_datpri = date = data da primeira parcela 
                 v07_vlrmul = float8 = valor da multa 
                 v07_vlrjur = float8 = valor dos juros 
                 v07_perjur = float8 = percentual dos juros 
                 v07_permul = float8 = percentual das multas 
                 v07_login = varchar(8) = login 
                 v07_mtermo = oid = termo 
                 v07_numcgm = int4 = cgm 
                 v07_hist = varchar(130) = historico 
                 ";
   //funcao construtor da classe 
   function cl_termo() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("termo"); 
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
       $this->v07_parcel = ($this->v07_parcel == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_parcel"]:$this->v07_parcel);
       if($this->v07_dtlanc == ""){
         $this->v07_dtlanc_dia = @$GLOBALS["HTTP_POST_VARS"]["v07_dtlanc_dia"];
         $this->v07_dtlanc_mes = @$GLOBALS["HTTP_POST_VARS"]["v07_dtlanc_mes"];
         $this->v07_dtlanc_ano = @$GLOBALS["HTTP_POST_VARS"]["v07_dtlanc_ano"];
         if($this->v07_dtlanc_dia != ""){
            $this->v07_dtlanc = $this->v07_dtlanc_ano."-".$this->v07_dtlanc_mes."-".$this->v07_dtlanc_dia;
         }
       }
       $this->v07_valor = ($this->v07_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_valor"]:$this->v07_valor);
       $this->v07_numpre = ($this->v07_numpre == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_numpre"]:$this->v07_numpre);
       $this->v07_totpar = ($this->v07_totpar == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_totpar"]:$this->v07_totpar);
       $this->v07_vlrpar = ($this->v07_vlrpar == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_vlrpar"]:$this->v07_vlrpar);
       if($this->v07_dtvenc == ""){
         $this->v07_dtvenc_dia = @$GLOBALS["HTTP_POST_VARS"]["v07_dtvenc_dia"];
         $this->v07_dtvenc_mes = @$GLOBALS["HTTP_POST_VARS"]["v07_dtvenc_mes"];
         $this->v07_dtvenc_ano = @$GLOBALS["HTTP_POST_VARS"]["v07_dtvenc_ano"];
         if($this->v07_dtvenc_dia != ""){
            $this->v07_dtvenc = $this->v07_dtvenc_ano."-".$this->v07_dtvenc_mes."-".$this->v07_dtvenc_dia;
         }
       }
       $this->v07_vlrent = ($this->v07_vlrent == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_vlrent"]:$this->v07_vlrent);
       if($this->v07_datpri == ""){
         $this->v07_datpri_dia = @$GLOBALS["HTTP_POST_VARS"]["v07_datpri_dia"];
         $this->v07_datpri_mes = @$GLOBALS["HTTP_POST_VARS"]["v07_datpri_mes"];
         $this->v07_datpri_ano = @$GLOBALS["HTTP_POST_VARS"]["v07_datpri_ano"];
         if($this->v07_datpri_dia != ""){
            $this->v07_datpri = $this->v07_datpri_ano."-".$this->v07_datpri_mes."-".$this->v07_datpri_dia;
         }
       }
       $this->v07_vlrmul = ($this->v07_vlrmul == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_vlrmul"]:$this->v07_vlrmul);
       $this->v07_vlrjur = ($this->v07_vlrjur == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_vlrjur"]:$this->v07_vlrjur);
       $this->v07_perjur = ($this->v07_perjur == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_perjur"]:$this->v07_perjur);
       $this->v07_permul = ($this->v07_permul == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_permul"]:$this->v07_permul);
       $this->v07_login = ($this->v07_login == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_login"]:$this->v07_login);
       $this->v07_mtermo = ($this->v07_mtermo == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_mtermo"]:$this->v07_mtermo);
       $this->v07_numcgm = ($this->v07_numcgm == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_numcgm"]:$this->v07_numcgm);
       $this->v07_hist = ($this->v07_hist == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_hist"]:$this->v07_hist);
     }else{
       $this->v07_parcel = ($this->v07_parcel == ""?@$GLOBALS["HTTP_POST_VARS"]["v07_parcel"]:$this->v07_parcel);
     }
   }
   // funcao para inclusao
   function incluir ($v07_parcel){ 
      $this->atualizacampos();
     if($this->v07_dtlanc == null ){ 
       $this->erro_sql = " Campo data de lancamento do parcelamento nao Informado.";
       $this->erro_campo = "v07_dtlanc_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_valor == null ){ 
       $this->erro_sql = " Campo valor do parcelamento nao Informado.";
       $this->erro_campo = "v07_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_numpre == null ){ 
       $this->erro_sql = " Campo numpre do parcelamento nao Informado.";
       $this->erro_campo = "v07_numpre";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_totpar == null ){ 
       $this->erro_sql = " Campo total de parcelas nao Informado.";
       $this->erro_campo = "v07_totpar";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_vlrpar == null ){ 
       $this->erro_sql = " Campo valor das parcelas nao Informado.";
       $this->erro_campo = "v07_vlrpar";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_dtvenc == null ){ 
       $this->erro_sql = " Campo data de vencimento nao Informado.";
       $this->erro_campo = "v07_dtvenc_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_vlrent == null ){ 
       $this->erro_sql = " Campo valor da entrada nao Informado.";
       $this->erro_campo = "v07_vlrent";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_datpri == null ){ 
       $this->erro_sql = " Campo data da primeira parcela nao Informado.";
       $this->erro_campo = "v07_datpri_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_vlrmul == null ){ 
       $this->erro_sql = " Campo valor da multa nao Informado.";
       $this->erro_campo = "v07_vlrmul";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_vlrjur == null ){ 
       $this->erro_sql = " Campo valor dos juros nao Informado.";
       $this->erro_campo = "v07_vlrjur";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_perjur == null ){ 
       $this->erro_sql = " Campo percentual dos juros nao Informado.";
       $this->erro_campo = "v07_perjur";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_permul == null ){ 
       $this->erro_sql = " Campo percentual das multas nao Informado.";
       $this->erro_campo = "v07_permul";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_login == null ){ 
       $this->erro_sql = " Campo login nao Informado.";
       $this->erro_campo = "v07_login";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_mtermo == null ){ 
       $this->erro_sql = " Campo termo nao Informado.";
       $this->erro_campo = "v07_mtermo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_numcgm == null ){ 
       $this->erro_sql = " Campo cgm nao Informado.";
       $this->erro_campo = "v07_numcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v07_hist == null ){ 
       $this->erro_sql = " Campo historico nao Informado.";
       $this->erro_campo = "v07_hist";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->v07_parcel = $v07_parcel; 
     if(($this->v07_parcel == null) || ($this->v07_parcel == "") ){ 
       $this->erro_sql = " Campo v07_parcel nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into termo(
                                       v07_parcel 
                                      ,v07_dtlanc 
                                      ,v07_valor 
                                      ,v07_numpre 
                                      ,v07_totpar 
                                      ,v07_vlrpar 
                                      ,v07_dtvenc 
                                      ,v07_vlrent 
                                      ,v07_datpri 
                                      ,v07_vlrmul 
                                      ,v07_vlrjur 
                                      ,v07_perjur 
                                      ,v07_permul 
                                      ,v07_login 
                                      ,v07_mtermo 
                                      ,v07_numcgm 
                                      ,v07_hist 
                       )
                values (
                                $this->v07_parcel 
                               ,".($this->v07_dtlanc == "null" || $this->v07_dtlanc == ""?"null":"'".$this->v07_dtlanc."'")." 
                               ,$this->v07_valor 
                               ,$this->v07_numpre 
                               ,$this->v07_totpar 
                               ,$this->v07_vlrpar 
                               ,".($this->v07_dtvenc == "null" || $this->v07_dtvenc == ""?"null":"'".$this->v07_dtvenc."'")." 
                               ,$this->v07_vlrent 
                               ,".($this->v07_datpri == "null" || $this->v07_datpri == ""?"null":"'".$this->v07_datpri."'")." 
                               ,$this->v07_vlrmul 
                               ,$this->v07_vlrjur 
                               ,$this->v07_perjur 
                               ,$this->v07_permul 
                               ,'$this->v07_login' 
                               ,$this->v07_mtermo 
                               ,$this->v07_numcgm 
                               ,'$this->v07_hist' 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " ($this->v07_parcel) nao Incluído. Inclusao Abortada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->v07_parcel;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($v07_parcel=null) { 
      $this->atualizacampos();
     $sql = " update termo set ";
     $virgula = "";
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_parcel"])){ 
       $sql  .= $virgula." v07_parcel = $this->v07_parcel ";
       $virgula = ",";
       if($this->v07_parcel == null ){ 
         $this->erro_sql = " Campo codigo do parcelamento nao Informado.";
         $this->erro_campo = "v07_parcel";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_dtlanc_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["v07_dtlanc_dia"] !="") ){ 
       $sql  .= $virgula." v07_dtlanc = '$this->v07_dtlanc' ";
       $virgula = ",";
       if($this->v07_dtlanc == null ){ 
         $this->erro_sql = " Campo data de lancamento do parcelamento nao Informado.";
         $this->erro_campo = "v07_dtlanc_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       $sql  .= $virgula." v07_dtlanc = null ";
       $virgula = ",";
       if($this->v07_dtlanc == null ){ 
         $this->erro_sql = " Campo data de lancamento do parcelamento nao Informado.";
         $this->erro_campo = "v07_dtlanc_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_valor"])){ 
       $sql  .= $virgula." v07_valor = $this->v07_valor ";
       $virgula = ",";
       if($this->v07_valor == null ){ 
         $this->erro_sql = " Campo valor do parcelamento nao Informado.";
         $this->erro_campo = "v07_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_numpre"])){ 
       $sql  .= $virgula." v07_numpre = $this->v07_numpre ";
       $virgula = ",";
       if($this->v07_numpre == null ){ 
         $this->erro_sql = " Campo numpre do parcelamento nao Informado.";
         $this->erro_campo = "v07_numpre";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_totpar"])){ 
       $sql  .= $virgula." v07_totpar = $this->v07_totpar ";
       $virgula = ",";
       if($this->v07_totpar == null ){ 
         $this->erro_sql = " Campo total de parcelas nao Informado.";
         $this->erro_campo = "v07_totpar";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_vlrpar"])){ 
       $sql  .= $virgula." v07_vlrpar = $this->v07_vlrpar ";
       $virgula = ",";
       if($this->v07_vlrpar == null ){ 
         $this->erro_sql = " Campo valor das parcelas nao Informado.";
         $this->erro_campo = "v07_vlrpar";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_dtvenc_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["v07_dtvenc_dia"] !="") ){ 
       $sql  .= $virgula." v07_dtvenc = '$this->v07_dtvenc' ";
       $virgula = ",";
       if($this->v07_dtvenc == null ){ 
         $this->erro_sql = " Campo data de vencimento nao Informado.";
         $this->erro_campo = "v07_dtvenc_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       $sql  .= $virgula." v07_dtvenc = null ";
       $virgula = ",";
       if($this->v07_dtvenc == null ){ 
         $this->erro_sql = " Campo data de vencimento nao Informado.";
         $this->erro_campo = "v07_dtvenc_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_vlrent"])){ 
       $sql  .= $virgula." v07_vlrent = $this->v07_vlrent ";
       $virgula = ",";
       if($this->v07_vlrent == null ){ 
         $this->erro_sql = " Campo valor da entrada nao Informado.";
         $this->erro_campo = "v07_vlrent";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_datpri_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["v07_datpri_dia"] !="") ){ 
       $sql  .= $virgula." v07_datpri = '$this->v07_datpri' ";
       $virgula = ",";
       if($this->v07_datpri == null ){ 
         $this->erro_sql = " Campo data da primeira parcela nao Informado.";
         $this->erro_campo = "v07_datpri_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       $sql  .= $virgula." v07_datpri = null ";
       $virgula = ",";
       if($this->v07_datpri == null ){ 
         $this->erro_sql = " Campo data da primeira parcela nao Informado.";
         $this->erro_campo = "v07_datpri_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_vlrmul"])){ 
       $sql  .= $virgula." v07_vlrmul = $this->v07_vlrmul ";
       $virgula = ",";
       if($this->v07_vlrmul == null ){ 
         $this->erro_sql = " Campo valor da multa nao Informado.";
         $this->erro_campo = "v07_vlrmul";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_vlrjur"])){ 
       $sql  .= $virgula." v07_vlrjur = $this->v07_vlrjur ";
       $virgula = ",";
       if($this->v07_vlrjur == null ){ 
         $this->erro_sql = " Campo valor dos juros nao Informado.";
         $this->erro_campo = "v07_vlrjur";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_perjur"])){ 
       $sql  .= $virgula." v07_perjur = $this->v07_perjur ";
       $virgula = ",";
       if($this->v07_perjur == null ){ 
         $this->erro_sql = " Campo percentual dos juros nao Informado.";
         $this->erro_campo = "v07_perjur";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_permul"])){ 
       $sql  .= $virgula." v07_permul = $this->v07_permul ";
       $virgula = ",";
       if($this->v07_permul == null ){ 
         $this->erro_sql = " Campo percentual das multas nao Informado.";
         $this->erro_campo = "v07_permul";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_login"])){ 
       $sql  .= $virgula." v07_login = '$this->v07_login' ";
       $virgula = ",";
       if($this->v07_login == null ){ 
         $this->erro_sql = " Campo login nao Informado.";
         $this->erro_campo = "v07_login";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_mtermo"])){ 
       $sql  .= $virgula." v07_mtermo = $this->v07_mtermo ";
       $virgula = ",";
       if($this->v07_mtermo == null ){ 
         $this->erro_sql = " Campo termo nao Informado.";
         $this->erro_campo = "v07_mtermo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_numcgm"])){ 
       $sql  .= $virgula." v07_numcgm = $this->v07_numcgm ";
       $virgula = ",";
       if($this->v07_numcgm == null ){ 
         $this->erro_sql = " Campo cgm nao Informado.";
         $this->erro_campo = "v07_numcgm";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["v07_hist"])){ 
       $sql  .= $virgula." v07_hist = '$this->v07_hist' ";
       $virgula = ",";
       if($this->v07_hist == null ){ 
         $this->erro_sql = " Campo historico nao Informado.";
         $this->erro_campo = "v07_hist";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  v07_parcel = $this->v07_parcel
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->v07_parcel;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->v07_parcel;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->v07_parcel;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($v07_parcel=null) { 
     $this->atualizacampos(true);
     $result = @pg_exec(" delete from termo
                    where  v07_parcel = $this->v07_parcel
                    ");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->v07_parcel;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->v07_parcel;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->v07_parcel;
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
   function sql_query ( $v07_parcel=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from termo ";
     $sql .= "      inner join cgm on  cgm.z01_numcgm = termo.v07_numcgm";
     $sql2 = "";
     if($dbwhere==""){
       if($v07_parcel!=null ){
         $sql2 .= " where termo.v07_parcel = $v07_parcel "; 
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