<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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

//MODULO: configuracoes
//CLASSE DA ENTIDADE db_config
class cl_db_config { 
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
   var $codigo = 0; 
   var $nomeinst = null; 
   var $ender = null; 
   var $munic = null; 
   var $uf = null; 
   var $telef = null; 
   var $email = null; 
   var $ident = 0; 
   var $tx_banc = 0; 
   var $numbanco = null; 
   var $url = null; 
   var $logo = null; 
   var $figura = null; 
   var $dtcont_dia = null; 
   var $dtcont_mes = null; 
   var $dtcont_ano = null; 
   var $dtcont = null; 
   var $diario = 0; 
   var $pref = null; 
   var $vicepref = null; 
   var $fax = null; 
   var $cgc = null; 
   var $cep = null; 
   var $tpropri = 'f'; 
   var $tsocios = 'f'; 
   var $prefeitura = 'f'; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 codigo = int4 = codigo da instituicao 
                 nomeinst = varchar(80) = nome da instituicao 
                 ender = varchar(80) = endereco da instituicao 
                 munic = varchar(40) = municipio da instituicao 
                 uf = char(2) = unidade federativa da instituicao 
                 telef = char(11) = Telefone 
                 email = varchar(200) = email da instituicao 
                 ident = int4 = identidade 
                 tx_banc = float8 = taxa bancaria 
                 numbanco = varchar(10) = numero do banco 
                 url = varchar(200) = url 
                 logo = varchar(100) = logo 
                 figura = varchar(100) = figura 
                 dtcont = date = data da contabilidade 
                 diario = int4 = diario 
                 pref = varchar(40) = prefeito 
                 vicepref = varchar(40) = vice prefeito 
                 fax = char(11) = fax 
                 cgc = char(14) = cgc 
                 cep = char(8) = cep 
                 tpropri = bool = Débitos proprietário 
                 tsocios = bool = Débitos Sócios 
                 prefeitura = bool = Prefeitura 
                 ";
   //funcao construtor da classe 
   function cl_db_config() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("db_config"); 
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
       $this->codigo = ($this->codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["codigo"]:$this->codigo);
       $this->nomeinst = ($this->nomeinst == ""?@$GLOBALS["HTTP_POST_VARS"]["nomeinst"]:$this->nomeinst);
       $this->ender = ($this->ender == ""?@$GLOBALS["HTTP_POST_VARS"]["ender"]:$this->ender);
       $this->munic = ($this->munic == ""?@$GLOBALS["HTTP_POST_VARS"]["munic"]:$this->munic);
       $this->uf = ($this->uf == ""?@$GLOBALS["HTTP_POST_VARS"]["uf"]:$this->uf);
       $this->telef = ($this->telef == ""?@$GLOBALS["HTTP_POST_VARS"]["telef"]:$this->telef);
       $this->email = ($this->email == ""?@$GLOBALS["HTTP_POST_VARS"]["email"]:$this->email);
       $this->ident = ($this->ident == ""?@$GLOBALS["HTTP_POST_VARS"]["ident"]:$this->ident);
       $this->tx_banc = ($this->tx_banc == ""?@$GLOBALS["HTTP_POST_VARS"]["tx_banc"]:$this->tx_banc);
       $this->numbanco = ($this->numbanco == ""?@$GLOBALS["HTTP_POST_VARS"]["numbanco"]:$this->numbanco);
       $this->url = ($this->url == ""?@$GLOBALS["HTTP_POST_VARS"]["url"]:$this->url);
       $this->logo = ($this->logo == ""?@$GLOBALS["HTTP_POST_VARS"]["logo"]:$this->logo);
       $this->figura = ($this->figura == ""?@$GLOBALS["HTTP_POST_VARS"]["figura"]:$this->figura);
       if($this->dtcont == ""){
         $this->dtcont_dia = @$GLOBALS["HTTP_POST_VARS"]["dtcont_dia"];
         $this->dtcont_mes = @$GLOBALS["HTTP_POST_VARS"]["dtcont_mes"];
         $this->dtcont_ano = @$GLOBALS["HTTP_POST_VARS"]["dtcont_ano"];
         if($this->dtcont_dia != ""){
            $this->dtcont = $this->dtcont_ano."-".$this->dtcont_mes."-".$this->dtcont_dia;
         }
       }
       $this->diario = ($this->diario == ""?@$GLOBALS["HTTP_POST_VARS"]["diario"]:$this->diario);
       $this->pref = ($this->pref == ""?@$GLOBALS["HTTP_POST_VARS"]["pref"]:$this->pref);
       $this->vicepref = ($this->vicepref == ""?@$GLOBALS["HTTP_POST_VARS"]["vicepref"]:$this->vicepref);
       $this->fax = ($this->fax == ""?@$GLOBALS["HTTP_POST_VARS"]["fax"]:$this->fax);
       $this->cgc = ($this->cgc == ""?@$GLOBALS["HTTP_POST_VARS"]["cgc"]:$this->cgc);
       $this->cep = ($this->cep == ""?@$GLOBALS["HTTP_POST_VARS"]["cep"]:$this->cep);
       $this->tpropri = ($this->tpropri == "f"?@$GLOBALS["HTTP_POST_VARS"]["tpropri"]:$this->tpropri);
       $this->tsocios = ($this->tsocios == "f"?@$GLOBALS["HTTP_POST_VARS"]["tsocios"]:$this->tsocios);
       $this->prefeitura = ($this->prefeitura == "f"?@$GLOBALS["HTTP_POST_VARS"]["prefeitura"]:$this->prefeitura);
     }else{
       $this->codigo = ($this->codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["codigo"]:$this->codigo);
     }
   }
   // funcao para inclusao
   function incluir ($codigo){ 
      $this->atualizacampos();
     if($this->nomeinst == null ){ 
       $this->erro_sql = " Campo nome da instituicao nao Informado.";
       $this->erro_campo = "nomeinst";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ender == null ){ 
       $this->erro_sql = " Campo endereco da instituicao nao Informado.";
       $this->erro_campo = "ender";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->munic == null ){ 
       $this->erro_sql = " Campo municipio da instituicao nao Informado.";
       $this->erro_campo = "munic";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->uf == null ){ 
       $this->erro_sql = " Campo unidade federativa da instituicao nao Informado.";
       $this->erro_campo = "uf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->telef == null ){ 
       $this->erro_sql = " Campo Telefone nao Informado.";
       $this->erro_campo = "telef";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->email == null ){ 
       $this->erro_sql = " Campo email da instituicao nao Informado.";
       $this->erro_campo = "email";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ident == null ){ 
       $this->erro_sql = " Campo identidade nao Informado.";
       $this->erro_campo = "ident";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->tx_banc == null ){ 
       $this->erro_sql = " Campo taxa bancaria nao Informado.";
       $this->erro_campo = "tx_banc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->numbanco == null ){ 
       $this->erro_sql = " Campo numero do banco nao Informado.";
       $this->erro_campo = "numbanco";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->url == null ){ 
       $this->erro_sql = " Campo url nao Informado.";
       $this->erro_campo = "url";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->logo == null ){ 
       $this->erro_sql = " Campo logo nao Informado.";
       $this->erro_campo = "logo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->figura == null ){ 
       $this->erro_sql = " Campo figura nao Informado.";
       $this->erro_campo = "figura";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->dtcont == null ){ 
       $this->erro_sql = " Campo data da contabilidade nao Informado.";
       $this->erro_campo = "dtcont_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->diario == null ){ 
       $this->erro_sql = " Campo diario nao Informado.";
       $this->erro_campo = "diario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->pref == null ){ 
       $this->erro_sql = " Campo prefeito nao Informado.";
       $this->erro_campo = "pref";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->vicepref == null ){ 
       $this->erro_sql = " Campo vice prefeito nao Informado.";
       $this->erro_campo = "vicepref";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->fax == null ){ 
       $this->erro_sql = " Campo fax nao Informado.";
       $this->erro_campo = "fax";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->cgc == null ){ 
       $this->erro_sql = " Campo cgc nao Informado.";
       $this->erro_campo = "cgc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->cep == null ){ 
       $this->erro_sql = " Campo cep nao Informado.";
       $this->erro_campo = "cep";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->tpropri == null ){ 
       $this->erro_sql = " Campo Débitos proprietário nao Informado.";
       $this->erro_campo = "tpropri";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->tsocios == null ){ 
       $this->erro_sql = " Campo Débitos Sócios nao Informado.";
       $this->erro_campo = "tsocios";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->prefeitura == null ){ 
       $this->erro_sql = " Campo Prefeitura nao Informado.";
       $this->erro_campo = "prefeitura";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->codigo = $codigo; 
     if(($this->codigo == null) || ($this->codigo == "") ){ 
       $this->erro_sql = " Campo codigo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @db_query("insert into db_config(
                                       codigo 
                                      ,nomeinst 
                                      ,ender 
                                      ,munic 
                                      ,uf 
                                      ,telef 
                                      ,email 
                                      ,ident 
                                      ,tx_banc 
                                      ,numbanco 
                                      ,url 
                                      ,logo 
                                      ,figura 
                                      ,dtcont 
                                      ,diario 
                                      ,pref 
                                      ,vicepref 
                                      ,fax 
                                      ,cgc 
                                      ,cep 
                                      ,tpropri 
                                      ,tsocios 
                                      ,prefeitura 
                       )
                values (
                                $this->codigo 
                               ,'$this->nomeinst' 
                               ,'$this->ender' 
                               ,'$this->munic' 
                               ,'$this->uf' 
                               ,'$this->telef' 
                               ,'$this->email' 
                               ,$this->ident 
                               ,$this->tx_banc 
                               ,'$this->numbanco' 
                               ,'$this->url' 
                               ,'$this->logo' 
                               ,'$this->figura' 
                               ,".($this->dtcont == "null" || $this->dtcont == ""?"null":"'".$this->dtcont."'")." 
                               ,$this->diario 
                               ,'$this->pref' 
                               ,'$this->vicepref' 
                               ,'$this->fax' 
                               ,'$this->cgc' 
                               ,'$this->cep' 
                               ,'$this->tpropri' 
                               ,'$this->tsocios' 
                               ,'$this->prefeitura' 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = " ($this->codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = " já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = " ($this->codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->codigo;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $resaco = $this->sql_record($this->sql_query_file($this->codigo));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountkey values($acount,449,'$this->codigo','I')");
       $resac = db_query("insert into db_acount values($acount,83,449,'','".pg_result($resaco,0,'codigo')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,450,'','".pg_result($resaco,0,'nomeinst')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,451,'','".pg_result($resaco,0,'ender')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,452,'','".pg_result($resaco,0,'munic')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,453,'','".pg_result($resaco,0,'uf')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,457,'','".pg_result($resaco,0,'telef')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,458,'','".pg_result($resaco,0,'email')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,459,'','".pg_result($resaco,0,'ident')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,460,'','".pg_result($resaco,0,'tx_banc')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,461,'','".pg_result($resaco,0,'numbanco')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,462,'','".pg_result($resaco,0,'url')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,463,'','".pg_result($resaco,0,'logo')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,464,'','".pg_result($resaco,0,'figura')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,465,'','".pg_result($resaco,0,'dtcont')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,466,'','".pg_result($resaco,0,'diario')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,467,'','".pg_result($resaco,0,'pref')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,468,'','".pg_result($resaco,0,'vicepref')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,469,'','".pg_result($resaco,0,'fax')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,470,'','".pg_result($resaco,0,'cgc')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,471,'','".pg_result($resaco,0,'cep')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,3411,'','".pg_result($resaco,0,'tpropri')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,3412,'','".pg_result($resaco,0,'tsocios')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,3413,'','".pg_result($resaco,0,'prefeitura')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($codigo=null) { 
      $this->atualizacampos();
     $sql = " update db_config set ";
     $virgula = "";
     if(trim($this->codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["codigo"])){ 
        if(trim($this->codigo)=="" && isset($GLOBALS["HTTP_POST_VARS"]["codigo"])){ 
           $this->codigo = "0" ; 
        } 
       $sql  .= $virgula." codigo = $this->codigo ";
       $virgula = ",";
       if(trim($this->codigo) == null ){ 
         $this->erro_sql = " Campo codigo da instituicao nao Informado.";
         $this->erro_campo = "codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->nomeinst)!="" || isset($GLOBALS["HTTP_POST_VARS"]["nomeinst"])){ 
       $sql  .= $virgula." nomeinst = '$this->nomeinst' ";
       $virgula = ",";
       if(trim($this->nomeinst) == null ){ 
         $this->erro_sql = " Campo nome da instituicao nao Informado.";
         $this->erro_campo = "nomeinst";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ender)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ender"])){ 
       $sql  .= $virgula." ender = '$this->ender' ";
       $virgula = ",";
       if(trim($this->ender) == null ){ 
         $this->erro_sql = " Campo endereco da instituicao nao Informado.";
         $this->erro_campo = "ender";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->munic)!="" || isset($GLOBALS["HTTP_POST_VARS"]["munic"])){ 
       $sql  .= $virgula." munic = '$this->munic' ";
       $virgula = ",";
       if(trim($this->munic) == null ){ 
         $this->erro_sql = " Campo municipio da instituicao nao Informado.";
         $this->erro_campo = "munic";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->uf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["uf"])){ 
       $sql  .= $virgula." uf = '$this->uf' ";
       $virgula = ",";
       if(trim($this->uf) == null ){ 
         $this->erro_sql = " Campo unidade federativa da instituicao nao Informado.";
         $this->erro_campo = "uf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->telef)!="" || isset($GLOBALS["HTTP_POST_VARS"]["telef"])){ 
       $sql  .= $virgula." telef = '$this->telef' ";
       $virgula = ",";
       if(trim($this->telef) == null ){ 
         $this->erro_sql = " Campo Telefone nao Informado.";
         $this->erro_campo = "telef";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->email)!="" || isset($GLOBALS["HTTP_POST_VARS"]["email"])){ 
       $sql  .= $virgula." email = '$this->email' ";
       $virgula = ",";
       if(trim($this->email) == null ){ 
         $this->erro_sql = " Campo email da instituicao nao Informado.";
         $this->erro_campo = "email";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ident)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ident"])){ 
        if(trim($this->ident)=="" && isset($GLOBALS["HTTP_POST_VARS"]["ident"])){ 
           $this->ident = "0" ; 
        } 
       $sql  .= $virgula." ident = $this->ident ";
       $virgula = ",";
       if(trim($this->ident) == null ){ 
         $this->erro_sql = " Campo identidade nao Informado.";
         $this->erro_campo = "ident";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->tx_banc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["tx_banc"])){ 
        if(trim($this->tx_banc)=="" && isset($GLOBALS["HTTP_POST_VARS"]["tx_banc"])){ 
           $this->tx_banc = "0" ; 
        } 
       $sql  .= $virgula." tx_banc = $this->tx_banc ";
       $virgula = ",";
       if(trim($this->tx_banc) == null ){ 
         $this->erro_sql = " Campo taxa bancaria nao Informado.";
         $this->erro_campo = "tx_banc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->numbanco)!="" || isset($GLOBALS["HTTP_POST_VARS"]["numbanco"])){ 
       $sql  .= $virgula." numbanco = '$this->numbanco' ";
       $virgula = ",";
       if(trim($this->numbanco) == null ){ 
         $this->erro_sql = " Campo numero do banco nao Informado.";
         $this->erro_campo = "numbanco";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->url)!="" || isset($GLOBALS["HTTP_POST_VARS"]["url"])){ 
       $sql  .= $virgula." url = '$this->url' ";
       $virgula = ",";
       if(trim($this->url) == null ){ 
         $this->erro_sql = " Campo url nao Informado.";
         $this->erro_campo = "url";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->logo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["logo"])){ 
       $sql  .= $virgula." logo = '$this->logo' ";
       $virgula = ",";
       if(trim($this->logo) == null ){ 
         $this->erro_sql = " Campo logo nao Informado.";
         $this->erro_campo = "logo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->figura)!="" || isset($GLOBALS["HTTP_POST_VARS"]["figura"])){ 
       $sql  .= $virgula." figura = '$this->figura' ";
       $virgula = ",";
       if(trim($this->figura) == null ){ 
         $this->erro_sql = " Campo figura nao Informado.";
         $this->erro_campo = "figura";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->dtcont)!="" || isset($GLOBALS["HTTP_POST_VARS"]["dtcont_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["dtcont_dia"] !="") ){ 
       $sql  .= $virgula." dtcont = '$this->dtcont' ";
       $virgula = ",";
       if(trim($this->dtcont) == null ){ 
         $this->erro_sql = " Campo data da contabilidade nao Informado.";
         $this->erro_campo = "dtcont_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["dtcont_dia"])){ 
         $sql  .= $virgula." dtcont = null ";
         $virgula = ",";
         if(trim($this->dtcont) == null ){ 
           $this->erro_sql = " Campo data da contabilidade nao Informado.";
           $this->erro_campo = "dtcont_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->diario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["diario"])){ 
        if(trim($this->diario)=="" && isset($GLOBALS["HTTP_POST_VARS"]["diario"])){ 
           $this->diario = "0" ; 
        } 
       $sql  .= $virgula." diario = $this->diario ";
       $virgula = ",";
       if(trim($this->diario) == null ){ 
         $this->erro_sql = " Campo diario nao Informado.";
         $this->erro_campo = "diario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->pref)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pref"])){ 
       $sql  .= $virgula." pref = '$this->pref' ";
       $virgula = ",";
       if(trim($this->pref) == null ){ 
         $this->erro_sql = " Campo prefeito nao Informado.";
         $this->erro_campo = "pref";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->vicepref)!="" || isset($GLOBALS["HTTP_POST_VARS"]["vicepref"])){ 
       $sql  .= $virgula." vicepref = '$this->vicepref' ";
       $virgula = ",";
       if(trim($this->vicepref) == null ){ 
         $this->erro_sql = " Campo vice prefeito nao Informado.";
         $this->erro_campo = "vicepref";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->fax)!="" || isset($GLOBALS["HTTP_POST_VARS"]["fax"])){ 
       $sql  .= $virgula." fax = '$this->fax' ";
       $virgula = ",";
       if(trim($this->fax) == null ){ 
         $this->erro_sql = " Campo fax nao Informado.";
         $this->erro_campo = "fax";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->cgc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["cgc"])){ 
       $sql  .= $virgula." cgc = '$this->cgc' ";
       $virgula = ",";
       if(trim($this->cgc) == null ){ 
         $this->erro_sql = " Campo cgc nao Informado.";
         $this->erro_campo = "cgc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->cep)!="" || isset($GLOBALS["HTTP_POST_VARS"]["cep"])){ 
       $sql  .= $virgula." cep = '$this->cep' ";
       $virgula = ",";
       if(trim($this->cep) == null ){ 
         $this->erro_sql = " Campo cep nao Informado.";
         $this->erro_campo = "cep";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->tpropri)!="" || isset($GLOBALS["HTTP_POST_VARS"]["tpropri"])){ 
       $sql  .= $virgula." tpropri = '$this->tpropri' ";
       $virgula = ",";
       if(trim($this->tpropri) == null ){ 
         $this->erro_sql = " Campo Débitos proprietário nao Informado.";
         $this->erro_campo = "tpropri";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->tsocios)!="" || isset($GLOBALS["HTTP_POST_VARS"]["tsocios"])){ 
       $sql  .= $virgula." tsocios = '$this->tsocios' ";
       $virgula = ",";
       if(trim($this->tsocios) == null ){ 
         $this->erro_sql = " Campo Débitos Sócios nao Informado.";
         $this->erro_campo = "tsocios";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->prefeitura)!="" || isset($GLOBALS["HTTP_POST_VARS"]["prefeitura"])){ 
       $sql  .= $virgula." prefeitura = '$this->prefeitura' ";
       $virgula = ",";
       if(trim($this->prefeitura) == null ){ 
         $this->erro_sql = " Campo Prefeitura nao Informado.";
         $this->erro_campo = "prefeitura";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  codigo = $this->codigo
";
     $resaco = $this->sql_record($this->sql_query_file($this->codigo));
     if($this->numrows>0){       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountkey values($acount,449,'$this->codigo','A')");
       if(isset($GLOBALS["HTTP_POST_VARS"]["codigo"]))
         $resac = db_query("insert into db_acount values($acount,83,449,'".pg_result($resaco,0,'codigo')."','$this->codigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["nomeinst"]))
         $resac = db_query("insert into db_acount values($acount,83,450,'".pg_result($resaco,0,'nomeinst')."','$this->nomeinst',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["ender"]))
         $resac = db_query("insert into db_acount values($acount,83,451,'".pg_result($resaco,0,'ender')."','$this->ender',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["munic"]))
         $resac = db_query("insert into db_acount values($acount,83,452,'".pg_result($resaco,0,'munic')."','$this->munic',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["uf"]))
         $resac = db_query("insert into db_acount values($acount,83,453,'".pg_result($resaco,0,'uf')."','$this->uf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["telef"]))
         $resac = db_query("insert into db_acount values($acount,83,457,'".pg_result($resaco,0,'telef')."','$this->telef',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["email"]))
         $resac = db_query("insert into db_acount values($acount,83,458,'".pg_result($resaco,0,'email')."','$this->email',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["ident"]))
         $resac = db_query("insert into db_acount values($acount,83,459,'".pg_result($resaco,0,'ident')."','$this->ident',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["tx_banc"]))
         $resac = db_query("insert into db_acount values($acount,83,460,'".pg_result($resaco,0,'tx_banc')."','$this->tx_banc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["numbanco"]))
         $resac = db_query("insert into db_acount values($acount,83,461,'".pg_result($resaco,0,'numbanco')."','$this->numbanco',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["url"]))
         $resac = db_query("insert into db_acount values($acount,83,462,'".pg_result($resaco,0,'url')."','$this->url',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["logo"]))
         $resac = db_query("insert into db_acount values($acount,83,463,'".pg_result($resaco,0,'logo')."','$this->logo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["figura"]))
         $resac = db_query("insert into db_acount values($acount,83,464,'".pg_result($resaco,0,'figura')."','$this->figura',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["dtcont"]))
         $resac = db_query("insert into db_acount values($acount,83,465,'".pg_result($resaco,0,'dtcont')."','$this->dtcont',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["diario"]))
         $resac = db_query("insert into db_acount values($acount,83,466,'".pg_result($resaco,0,'diario')."','$this->diario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["pref"]))
         $resac = db_query("insert into db_acount values($acount,83,467,'".pg_result($resaco,0,'pref')."','$this->pref',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["vicepref"]))
         $resac = db_query("insert into db_acount values($acount,83,468,'".pg_result($resaco,0,'vicepref')."','$this->vicepref',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["fax"]))
         $resac = db_query("insert into db_acount values($acount,83,469,'".pg_result($resaco,0,'fax')."','$this->fax',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["cgc"]))
         $resac = db_query("insert into db_acount values($acount,83,470,'".pg_result($resaco,0,'cgc')."','$this->cgc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["cep"]))
         $resac = db_query("insert into db_acount values($acount,83,471,'".pg_result($resaco,0,'cep')."','$this->cep',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["tpropri"]))
         $resac = db_query("insert into db_acount values($acount,83,3411,'".pg_result($resaco,0,'tpropri')."','$this->tpropri',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["tsocios"]))
         $resac = db_query("insert into db_acount values($acount,83,3412,'".pg_result($resaco,0,'tsocios')."','$this->tsocios',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["prefeitura"]))
         $resac = db_query("insert into db_acount values($acount,83,3413,'".pg_result($resaco,0,'prefeitura')."','$this->prefeitura',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     $result = @db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($codigo=null) { 
     $this->atualizacampos(true);
     $resaco = $this->sql_record($this->sql_query_file($this->codigo));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountkey values($acount,449,'$this->codigo','E')");
       $resac = db_query("insert into db_acount values($acount,83,449,'','".pg_result($resaco,0,'codigo')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,450,'','".pg_result($resaco,0,'nomeinst')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,451,'','".pg_result($resaco,0,'ender')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,452,'','".pg_result($resaco,0,'munic')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,453,'','".pg_result($resaco,0,'uf')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,457,'','".pg_result($resaco,0,'telef')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,458,'','".pg_result($resaco,0,'email')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,459,'','".pg_result($resaco,0,'ident')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,460,'','".pg_result($resaco,0,'tx_banc')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,461,'','".pg_result($resaco,0,'numbanco')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,462,'','".pg_result($resaco,0,'url')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,463,'','".pg_result($resaco,0,'logo')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,464,'','".pg_result($resaco,0,'figura')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,465,'','".pg_result($resaco,0,'dtcont')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,466,'','".pg_result($resaco,0,'diario')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,467,'','".pg_result($resaco,0,'pref')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,468,'','".pg_result($resaco,0,'vicepref')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,469,'','".pg_result($resaco,0,'fax')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,470,'','".pg_result($resaco,0,'cgc')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,471,'','".pg_result($resaco,0,'cep')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,3411,'','".pg_result($resaco,0,'tpropri')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,3412,'','".pg_result($resaco,0,'tsocios')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,83,3413,'','".pg_result($resaco,0,'prefeitura')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     $sql = " delete from db_config
                    where ";
     $sql2 = "";
      if($this->codigo != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " codigo = $this->codigo ";
}
     $result = @db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   function sql_record($sql) { 
     $result = @db_query($sql);
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
   function sql_query ( $codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from db_config ";
     $sql2 = "";
     if($dbwhere==""){
       if($codigo!=null ){
         $sql2 .= " where db_config.codigo = $codigo "; 
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
   function sql_query_file ( $codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from db_config ";
     $sql2 = "";
     if($dbwhere==""){
       if($codigo!=null ){
         $sql2 .= " where db_config.codigo = $codigo "; 
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
  

  /**
   * Retorna um objeto com os dados da instituição
   * @param integer $iInstit - Instituição qual os dados devem ser retornados
   * @return mixed boolean, object db_fields
   */
  function getParametrosInstituicao($iInstit=null) {
  
  	if (empty($iInstit)){
  		$iInstit = db_getsession("DB_instit");
  	}
  
  	$sSql = "select * from db_config where codigo = " . $iInstit;
  
  	$rsSql = db_query($sSql);
  
  	if  ( $rsSql && pg_num_rows($rsSql) ) {
  		return db_utils::fieldsMemory($rsSql, 0);
  	}
  	return false;
  }
  
}
?>