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
//CLASSE DA ENTIDADE issbase
class cl_issbase { 
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
   var $q02_inscr = 0; 
   var $q02_numcgm = 0; 
   var $q02_memo = null; 
   var $q02_tiplic = null; 
   var $q02_fanta = null; 
   var $q02_regjuc = null; 
   var $q02_inscmu = null; 
   var $q02_obs = null; 
   var $q02_dtcada_dia = null; 
   var $q02_dtcada_mes = null; 
   var $q02_dtcada_ano = null; 
   var $q02_dtcada = null; 
   var $q02_dtinic_dia = null; 
   var $q02_dtinic_mes = null; 
   var $q02_dtinic_ano = null; 
   var $q02_dtinic = null; 
   var $q02_dtbaix_dia = null; 
   var $q02_dtbaix_mes = null; 
   var $q02_dtbaix_ano = null; 
   var $q02_dtbaix = null; 
   var $q02_capit = 0; 
   var $q02_cep = null; 

   var $propagar = array();
   
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 q02_inscr = int4 = Inscricao 
                 q02_numcgm = int4 = Numero do CGM 
                 q02_memo = text = Observações 
                 q02_tiplic = varchar(2) = Tipo de Licenca 
                 q02_fanta = varchar(50) = Nome Fantasia 
                 q02_regjuc = varchar(14) = Registro na Junta Comercial 
                 q02_inscmu = varchar(14) = Inscricao Municipal 
                 q02_obs = varchar(70) = Observacoes 
                 q02_dtcada = date = Data de Cadastramento 
                 q02_dtinic = date = Dt. Inicio 
                 q02_dtbaix = date = Data da Baixa 
                 q02_capit = float8 = Capital Social 
                 q02_cep = char(8) = CEP 
                 ";
   //funcao construtor da classe 
   function cl_issbase() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("issbase"); 
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
       $this->q02_inscr = ($this->q02_inscr == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_inscr"]:$this->q02_inscr);
       $this->q02_numcgm = ($this->q02_numcgm == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_numcgm"]:$this->q02_numcgm);
       $this->q02_memo = ($this->q02_memo == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_memo"]:$this->q02_memo);
       $this->q02_tiplic = ($this->q02_tiplic == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_tiplic"]:$this->q02_tiplic);
       $this->q02_fanta = ($this->q02_fanta == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_fanta"]:$this->q02_fanta);
       $this->q02_regjuc = ($this->q02_regjuc == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_regjuc"]:$this->q02_regjuc);
       $this->q02_inscmu = ($this->q02_inscmu == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_inscmu"]:$this->q02_inscmu);
       $this->q02_obs = ($this->q02_obs == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_obs"]:$this->q02_obs);
       if($this->q02_dtcada == ""){
         $this->q02_dtcada_dia = ($this->q02_dtcada_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_dtcada_dia"]:$this->q02_dtcada_dia);
         $this->q02_dtcada_mes = ($this->q02_dtcada_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_dtcada_mes"]:$this->q02_dtcada_mes);
         $this->q02_dtcada_ano = ($this->q02_dtcada_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_dtcada_ano"]:$this->q02_dtcada_ano);
         if($this->q02_dtcada_dia != ""){
            $this->q02_dtcada = $this->q02_dtcada_ano."-".$this->q02_dtcada_mes."-".$this->q02_dtcada_dia;
         }
       }
       if($this->q02_dtinic == ""){
         $this->q02_dtinic_dia = ($this->q02_dtinic_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_dtinic_dia"]:$this->q02_dtinic_dia);
         $this->q02_dtinic_mes = ($this->q02_dtinic_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_dtinic_mes"]:$this->q02_dtinic_mes);
         $this->q02_dtinic_ano = ($this->q02_dtinic_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_dtinic_ano"]:$this->q02_dtinic_ano);
         if($this->q02_dtinic_dia != ""){
            $this->q02_dtinic = $this->q02_dtinic_ano."-".$this->q02_dtinic_mes."-".$this->q02_dtinic_dia;
         }
       }
       if($this->q02_dtbaix == ""){
         $this->q02_dtbaix_dia = ($this->q02_dtbaix_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_dtbaix_dia"]:$this->q02_dtbaix_dia);
         $this->q02_dtbaix_mes = ($this->q02_dtbaix_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_dtbaix_mes"]:$this->q02_dtbaix_mes);
         $this->q02_dtbaix_ano = ($this->q02_dtbaix_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_dtbaix_ano"]:$this->q02_dtbaix_ano);
         if($this->q02_dtbaix_dia != ""){
            $this->q02_dtbaix = $this->q02_dtbaix_ano."-".$this->q02_dtbaix_mes."-".$this->q02_dtbaix_dia;
         }
       }
       $this->q02_capit = ($this->q02_capit == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_capit"]:$this->q02_capit);
       $this->q02_cep = ($this->q02_cep == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_cep"]:$this->q02_cep);
     }else{
       $this->q02_inscr = ($this->q02_inscr == ""?@$GLOBALS["HTTP_POST_VARS"]["q02_inscr"]:$this->q02_inscr);
     }
   }
   // funcao para inclusao
   function incluir ($q02_inscr){ 
      $this->atualizacampos();
     if($this->q02_numcgm == null ){ 
       $this->erro_sql = " Campo Numero do CGM nao Informado.";
       $this->erro_campo = "q02_numcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q02_tiplic == null ){ 
       $this->erro_sql = " Campo Tipo de Licenca nao Informado.";
       $this->erro_campo = "q02_tiplic";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q02_fanta == null ){ 
       $this->erro_sql = " Campo Nome Fantasia nao Informado.";
       $this->erro_campo = "q02_fanta";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q02_inscmu == null ){ 
       $this->erro_sql = " Campo Inscricao Municipal nao Informado.";
       $this->erro_campo = "q02_inscmu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q02_obs == null ){ 
       $this->erro_sql = " Campo Observacoes nao Informado.";
       $this->erro_campo = "q02_obs";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q02_dtcada == null ){ 
       $this->erro_sql = " Campo Data de Cadastramento nao Informado.";
       $this->erro_campo = "q02_dtcada_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q02_dtinic == null ){ 
       $this->erro_sql = " Campo Dt. Inicio nao Informado.";
       $this->erro_campo = "q02_dtinic_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q02_dtbaix == null ){ 
       $this->q02_dtbaix = "null";
     }
     if($this->q02_capit == null ){ 
       $this->erro_sql = " Campo Capital Social nao Informado.";
       $this->erro_campo = "q02_capit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($q02_inscr == "" || $q02_inscr == null ){
       $result = @pg_query("select nextval('issbase_q02_inscr_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: issbase_q02_inscr_seq do campo: q02_inscr"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->q02_inscr = pg_result($result,0,0); 
     }else{
       $result = @pg_query("select last_value from issbase_q02_inscr_seq");
       if(($result != false) && (pg_result($result,0,0) < $q02_inscr)){
         $this->erro_sql = " Campo q02_inscr maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->q02_inscr = $q02_inscr; 
       }
     }
     if(($this->q02_inscr == null) || ($this->q02_inscr == "") ){ 
       $this->erro_sql = " Campo q02_inscr nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into issbase(
                                       q02_inscr 
                                      ,q02_numcgm 
                                      ,q02_memo 
                                      ,q02_tiplic 
                                      ,q02_fanta 
                                      ,q02_regjuc 
                                      ,q02_inscmu 
                                      ,q02_obs 
                                      ,q02_dtcada 
                                      ,q02_dtinic 
                                      ,q02_dtbaix 
                                      ,q02_capit 
                                      ,q02_cep 
                       )
                values (
                                $this->q02_inscr 
                               ,$this->q02_numcgm 
                               ,'$this->q02_memo' 
                               ,'$this->q02_tiplic' 
                               ,'$this->q02_fanta' 
                               ,'$this->q02_regjuc' 
                               ,'$this->q02_inscmu' 
                               ,'$this->q02_obs' 
                               ,".($this->q02_dtcada == "null" || $this->q02_dtcada == ""?"null":"'".$this->q02_dtcada."'")." 
                               ,".($this->q02_dtinic == "null" || $this->q02_dtinic == ""?"null":"'".$this->q02_dtinic."'")." 
                               ,".($this->q02_dtbaix == "null" || $this->q02_dtbaix == ""?"null":"'".$this->q02_dtbaix."'")." 
                               ,$this->q02_capit 
                               ,'$this->q02_cep' 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Cadastro de Alvarás ($this->q02_inscr) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Cadastro de Alvarás já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Cadastro de Alvarás ($this->q02_inscr) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->q02_inscr;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $resaco = $this->sql_record($this->sql_query_file($this->q02_inscr));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,203,'$this->q02_inscr','I')");
       $resac = pg_query("insert into db_acount values($acount,41,203,'','".pg_result($resaco,0,'q02_inscr')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,41,204,'','".pg_result($resaco,0,'q02_numcgm')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,41,212,'','".pg_result($resaco,0,'q02_memo')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,41,209,'','".pg_result($resaco,0,'q02_tiplic')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,41,205,'','".pg_result($resaco,0,'q02_fanta')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,41,210,'','".pg_result($resaco,0,'q02_regjuc')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,41,208,'','".pg_result($resaco,0,'q02_inscmu')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,41,207,'','".pg_result($resaco,0,'q02_obs')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,41,211,'','".pg_result($resaco,0,'q02_dtcada')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,41,213,'','".pg_result($resaco,0,'q02_dtinic')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,41,214,'','".pg_result($resaco,0,'q02_dtbaix')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,41,206,'','".pg_result($resaco,0,'q02_capit')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,41,2485,'','".pg_result($resaco,0,'q02_cep')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($q02_inscr=null) { 
      $this->atualizacampos();
     $sql = " update issbase set ";
     $virgula = "";
     if(trim($this->q02_inscr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_inscr"])){ 
       $sql  .= $virgula." q02_inscr = $this->q02_inscr ";
       $virgula = ",";
       if(trim($this->q02_inscr) == null ){ 
         $this->erro_sql = " Campo Inscricao nao Informado.";
         $this->erro_campo = "q02_inscr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q02_numcgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_numcgm"])){ 
       $sql  .= $virgula." q02_numcgm = $this->q02_numcgm ";
       $virgula = ",";
       if(trim($this->q02_numcgm) == null ){ 
         $this->erro_sql = " Campo Numero do CGM nao Informado.";
         $this->erro_campo = "q02_numcgm";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q02_memo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_memo"])){ 
       $sql  .= $virgula." q02_memo = '$this->q02_memo' ";
       $virgula = ",";
     }
     if(trim($this->q02_tiplic)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_tiplic"])){ 
       $sql  .= $virgula." q02_tiplic = '$this->q02_tiplic' ";
       $virgula = ",";
       if(trim($this->q02_tiplic) == null ){ 
         $this->erro_sql = " Campo Tipo de Licenca nao Informado.";
         $this->erro_campo = "q02_tiplic";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q02_fanta)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_fanta"])){ 
       $sql  .= $virgula." q02_fanta = '$this->q02_fanta' ";
       $virgula = ",";
       if(trim($this->q02_fanta) == null ){ 
         $this->erro_sql = " Campo Nome Fantasia nao Informado.";
         $this->erro_campo = "q02_fanta";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q02_regjuc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_regjuc"])){ 
       $sql  .= $virgula." q02_regjuc = '$this->q02_regjuc' ";
       $virgula = ",";
     }
     if(trim($this->q02_inscmu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_inscmu"])){ 
       $sql  .= $virgula." q02_inscmu = '$this->q02_inscmu' ";
       $virgula = ",";
       if(trim($this->q02_inscmu) == null ){ 
         $this->erro_sql = " Campo Inscricao Municipal nao Informado.";
         $this->erro_campo = "q02_inscmu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q02_obs)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_obs"])){ 
       $sql  .= $virgula." q02_obs = '$this->q02_obs' ";
       $virgula = ",";
       if(trim($this->q02_obs) == null ){ 
         $this->erro_sql = " Campo Observacoes nao Informado.";
         $this->erro_campo = "q02_obs";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q02_dtcada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_dtcada_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["q02_dtcada_dia"] !="") ){ 
       $sql  .= $virgula." q02_dtcada = '$this->q02_dtcada' ";
       $virgula = ",";
       if(trim($this->q02_dtcada) == null ){ 
         $this->erro_sql = " Campo Data de Cadastramento nao Informado.";
         $this->erro_campo = "q02_dtcada_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_dtcada_dia"])){ 
         $sql  .= $virgula." q02_dtcada = null ";
         $virgula = ",";
         if(trim($this->q02_dtcada) == null ){ 
           $this->erro_sql = " Campo Data de Cadastramento nao Informado.";
           $this->erro_campo = "q02_dtcada_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->q02_dtinic)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_dtinic_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["q02_dtinic_dia"] !="") ){ 
       $sql  .= $virgula." q02_dtinic = '$this->q02_dtinic' ";
       $virgula = ",";
       if(trim($this->q02_dtinic) == null ){ 
         $this->erro_sql = " Campo Dt. Inicio nao Informado.";
         $this->erro_campo = "q02_dtinic_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_dtinic_dia"])){ 
         $sql  .= $virgula." q02_dtinic = null ";
         $virgula = ",";
         if(trim($this->q02_dtinic) == null ){ 
           $this->erro_sql = " Campo Dt. Inicio nao Informado.";
           $this->erro_campo = "q02_dtinic_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->q02_dtbaix)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_dtbaix_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["q02_dtbaix_dia"] !="") ){ 
       $sql  .= $virgula." q02_dtbaix = '$this->q02_dtbaix' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_dtbaix_dia"])){ 
         $sql  .= $virgula." q02_dtbaix = null ";
         $virgula = ",";
       }
     }
     if(trim($this->q02_capit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_capit"])){ 
       $sql  .= $virgula." q02_capit = $this->q02_capit ";
       $virgula = ",";
       if(trim($this->q02_capit) == null ){ 
         $this->erro_sql = " Campo Capital Social nao Informado.";
         $this->erro_campo = "q02_capit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q02_cep)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q02_cep"])){ 
       $sql  .= $virgula." q02_cep = '$this->q02_cep' ";
       $virgula = ",";
     }
     $sql .= " where  q02_inscr = $this->q02_inscr
";
     $resaco = $this->sql_record($this->sql_query_file($this->q02_inscr));
     if($this->numrows>0){       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,203,'$this->q02_inscr','A')");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_inscr"]))
         $resac = pg_query("insert into db_acount values($acount,41,203,'".pg_result($resaco,0,'q02_inscr')."','$this->q02_inscr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_numcgm"]))
         $resac = pg_query("insert into db_acount values($acount,41,204,'".pg_result($resaco,0,'q02_numcgm')."','$this->q02_numcgm',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_memo"]))
         $resac = pg_query("insert into db_acount values($acount,41,212,'".pg_result($resaco,0,'q02_memo')."','$this->q02_memo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_tiplic"]))
         $resac = pg_query("insert into db_acount values($acount,41,209,'".pg_result($resaco,0,'q02_tiplic')."','$this->q02_tiplic',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_fanta"]))         
         $resac = pg_query("insert into db_acount values($acount,41,205,'".addslashes(pg_result($resaco,0,'q02_fanta'))."','".addslashes($this->q02_fanta)."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_regjuc"]))
         $resac = pg_query("insert into db_acount values($acount,41,210,'".pg_result($resaco,0,'q02_regjuc')."','$this->q02_regjuc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_inscmu"]))
         $resac = pg_query("insert into db_acount values($acount,41,208,'".pg_result($resaco,0,'q02_inscmu')."','$this->q02_inscmu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_obs"]))
         $resac = pg_query("insert into db_acount values($acount,41,207,'".pg_result($resaco,0,'q02_obs')."','$this->q02_obs',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_dtcada"]))
         $resac = pg_query("insert into db_acount values($acount,41,211,'".pg_result($resaco,0,'q02_dtcada')."','$this->q02_dtcada',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_dtinic"]))
         $resac = pg_query("insert into db_acount values($acount,41,213,'".pg_result($resaco,0,'q02_dtinic')."','$this->q02_dtinic',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_dtbaix"]))
         $resac = pg_query("insert into db_acount values($acount,41,214,'".pg_result($resaco,0,'q02_dtbaix')."','$this->q02_dtbaix',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_capit"]))
         $resac = pg_query("insert into db_acount values($acount,41,206,'".pg_result($resaco,0,'q02_capit')."','$this->q02_capit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["q02_cep"]))
         $resac = pg_query("insert into db_acount values($acount,41,2485,'".pg_result($resaco,0,'q02_cep')."','$this->q02_cep',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }     
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro de Alvarás nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->q02_inscr;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro de Alvarás nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->q02_inscr;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->q02_inscr;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($q02_inscr=null) { 
     $resaco = $this->sql_record($this->sql_query_file($q02_inscr));
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,203,'".pg_result($resaco,$iresaco,'q02_inscr')."','E')");
         $resac = pg_query("insert into db_acount values($acount,41,203,'','".pg_result($resaco,$iresaco,'q02_inscr')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,41,204,'','".pg_result($resaco,$iresaco,'q02_numcgm')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,41,212,'','".pg_result($resaco,$iresaco,'q02_memo')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,41,209,'','".pg_result($resaco,$iresaco,'q02_tiplic')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,41,205,'','".pg_result($resaco,$iresaco,'q02_fanta')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,41,210,'','".pg_result($resaco,$iresaco,'q02_regjuc')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,41,208,'','".pg_result($resaco,$iresaco,'q02_inscmu')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,41,207,'','".pg_result($resaco,$iresaco,'q02_obs')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,41,211,'','".pg_result($resaco,$iresaco,'q02_dtcada')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,41,213,'','".pg_result($resaco,$iresaco,'q02_dtinic')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,41,214,'','".pg_result($resaco,$iresaco,'q02_dtbaix')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,41,206,'','".pg_result($resaco,$iresaco,'q02_capit')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,41,2485,'','".pg_result($resaco,$iresaco,'q02_cep')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from issbase
                    where ";
     $sql2 = "";
      if($q02_inscr != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " q02_inscr = $q02_inscr ";
}
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro de Alvarás nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$q02_inscr;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro de Alvarás nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$q02_inscr;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$q02_inscr;
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
   function sql_query ( $q02_inscr=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from issbase ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = issbase.q02_numcgm";
     $sql .= "      left outer join issruas on issbase.q02_inscr = issruas.q02_inscr";
     $sql .= "      left outer join issbairro on issbase.q02_inscr = issbairro.q13_inscr";
     $sql2 = "";
     if($dbwhere==""){
       if($q02_inscr!=null ){
         $sql2 .= " where issbase.q02_inscr = $q02_inscr "; 
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
   function sql_query_file ( $q02_inscr=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from issbase ";
     $sql2 = "";
     if($dbwhere==""){
       if($q02_inscr!=null ){
         $sql2 .= " where issbase.q02_inscr = $q02_inscr "; 
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
   function empresa_record($sql) { 
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
        $this->erro_sql   = "Alvaras nao Encontrados";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function empresa_query ( $q02_inscr=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from empresa";
     $sql2 = "";
     if($dbwhere==""){
       if($q02_inscr!=null ){
         $sql2 .= " where empresa.q02_inscr = $q02_inscr "; 
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
   function empresa_query_file ( $q02_inscr=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from empresa ";
     $sql2 = "";
     if($dbwhere==""){
       if($q02_inscr!=null ){
         $sql2 .= " where q02_inscr = $q02_inscr "; 
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
   function sqlinscricoes_nome($pesquisaPorNome=0,$campos = '*'){
$sql = "
select $campos from (  select issbase.*, case when db_cgmcgc.z01_numcgm is not null then 'EMPRESA'
                                                                          else 'AUTONOMO'
                                                                          end::varchar(12) as proprietario, 
                                                                          cgm.z01_nome
                                     from issbase
                                     inner join cgm on q02_numcgm = z01_numcgm
                                     left outer join db_cgmcgc on q02_numcgm = db_cgmcgc.z01_numcgm
                                     where q02_numcgm = $pesquisaPorNome
   union
                                      select issbase.*, 'SOCIO'::varchar(12) as proprietario, 
                                                                      cgm.z01_nome
                                      from socios
                                      inner join issbase on q02_numcgm = q95_cgmpri
                                      inner join cgm on q95_numcgm = z01_numcgm
                                      where q95_numcgm = $pesquisaPorNome
                             	) as dados
    ";
    return $sql;
   }
   function sqlinscricoes_socios($inscricao=0, $cgm=0,$campos="cgmsocio.*", $innerleft=" inner "){
      $sql = " select  ";
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
     $sql .= " from issbase  ";
      if($innerleft  !=  " inner " ){
         $sql .= " left outer ";
      }else{
         $sql .= " inner ";
      }
      $sql .= " join socios on q95_cgmpri = q02_numcgm
                      inner join cgm cgmsocio   on cgmsocio.z01_numcgm   = q95_numcgm
                      inner join cgm cgmempresa   on cgmempresa.z01_numcgm   = q02_numcgm " ;
     if ( $inscricao != 0 ){
          $sql .= " where q02_inscr = $inscricao " ;
     }else if ( $cgm != 0 ){
         $sql .= " where q02_numcgm = $cgm ";
     }
 
     return $sql;
}
   function sql_query_aliquota ( $q02_inscr=null,$campos="*",$ordem=null,$dbwhere=""){


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
     $sql .= " from tabativ ";
     $sql .= " inner join ativtipo on ativtipo.q80_ativ = tabativ.q07_ativ ";
     $sql .= " inner join tipcalc on tipcalc.q81_codigo = ativtipo.q80_tipcal";
     $sql .= " inner join cadcalc on cadcalc.q85_codigo = tipcalc.q81_cadcalc";
     $sql2 = "";
     $sql2=" where cadcalc.q85_var is true
               and tabativ.q07_datafi is null
               and tabativ.q07_databx is null
               and q07_inscr = $q02_inscr";
     if($dbwhere != ""){
       $sql2 = " and  $dbwhere";
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