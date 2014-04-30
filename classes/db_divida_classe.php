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
//CLASSE DA ENTIDADE divida
class cl_divida { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $v01_coddiv = 0; 
   var $v01_numcgm = 0; 
   var $v01_dtinsc_dia = null; 
   var $v01_dtinsc_mes = null; 
   var $v01_dtinsc_ano = null; 
   var $v01_dtinsc = null; 
   var $v01_exerc = 0; 
   var $v01_numpre = 0; 
   var $v01_numpar = 0; 
   var $v01_numtot = 0; 
   var $v01_numdig = 0; 
   var $v01_vlrhis = 0; 
   var $v01_proced = 0; 
   var $v01_obs = null; 
   var $v01_livro = 0; 
   var $v01_folha = 0; 
   var $v01_dtvenc_dia = null; 
   var $v01_dtvenc_mes = null; 
   var $v01_dtvenc_ano = null; 
   var $v01_dtvenc = null; 
   var $v01_dtoper_dia = null; 
   var $v01_dtoper_mes = null; 
   var $v01_dtoper_ano = null; 
   var $v01_dtoper = null; 
   var $v01_valor = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 v01_coddiv = int4 = codigo da divida 
                 v01_numcgm = int4 = numero do cgm 
                 v01_dtinsc = date = data de inscricao 
                 v01_exerc = int4 = exercicio da divida 
                 v01_numpre = int4 = numpre 
                 v01_numpar = oid = numpar 
                 v01_numtot = int4 = numtot 
                 v01_numdig = int4 = numdig 
                 v01_vlrhis = float8 = valor historico 
                 v01_proced = int4 = procedencia 
                 v01_obs = varchar(117) = observacoes 
                 v01_livro = int4 = livro 
                 v01_folha = int4 = folha 
                 v01_dtvenc = date = data de vencimento 
                 v01_dtoper = date = data de operacao 
                 v01_valor = float8 = valor 
                 ";
   //funcao construtor da classe 
   function cl_divida() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("divida"); 
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
   // funcao para inclusao
   function atualizacampos() {
     $this->v01_coddiv = ($this->v01_coddiv == ""?$GLOBALS["HTTP_POST_VARS"]["v01_coddiv"]:$this->v01_coddiv);
     $this->v01_numcgm = ($this->v01_numcgm == ""?$GLOBALS["HTTP_POST_VARS"]["v01_numcgm"]:$this->v01_numcgm);
     $this->v01_dtinsc = ($this->v01_dtinsc == ""?$GLOBALS["HTTP_POST_VARS"]["v01_dtinsc_ano"]."-".$GLOBALS["HTTP_POST_VARS"]["v01_dtinsc_mes"]."-".$GLOBALS["HTTP_POST_VARS"]["v01_dtinsc_dia"]:$this->v01_dtinsc);
     $this->v01_exerc = ($this->v01_exerc == ""?$GLOBALS["HTTP_POST_VARS"]["v01_exerc"]:$this->v01_exerc);
     $this->v01_numpre = ($this->v01_numpre == ""?$GLOBALS["HTTP_POST_VARS"]["v01_numpre"]:$this->v01_numpre);
     $this->v01_numpar = ($this->v01_numpar == ""?$GLOBALS["HTTP_POST_VARS"]["v01_numpar"]:$this->v01_numpar);
     $this->v01_numtot = ($this->v01_numtot == ""?$GLOBALS["HTTP_POST_VARS"]["v01_numtot"]:$this->v01_numtot);
     $this->v01_numdig = ($this->v01_numdig == ""?$GLOBALS["HTTP_POST_VARS"]["v01_numdig"]:$this->v01_numdig);
     $this->v01_vlrhis = ($this->v01_vlrhis == ""?$GLOBALS["HTTP_POST_VARS"]["v01_vlrhis"]:$this->v01_vlrhis);
     $this->v01_proced = ($this->v01_proced == ""?$GLOBALS["HTTP_POST_VARS"]["v01_proced"]:$this->v01_proced);
     $this->v01_obs = ($this->v01_obs == ""?$GLOBALS["HTTP_POST_VARS"]["v01_obs"]:$this->v01_obs);
     $this->v01_livro = ($this->v01_livro == ""?$GLOBALS["HTTP_POST_VARS"]["v01_livro"]:$this->v01_livro);
     $this->v01_folha = ($this->v01_folha == ""?$GLOBALS["HTTP_POST_VARS"]["v01_folha"]:$this->v01_folha);
     $this->v01_dtvenc = ($this->v01_dtvenc == ""?$GLOBALS["HTTP_POST_VARS"]["v01_dtvenc_ano"]."-".$GLOBALS["HTTP_POST_VARS"]["v01_dtvenc_mes"]."-".$GLOBALS["HTTP_POST_VARS"]["v01_dtvenc_dia"]:$this->v01_dtvenc);
     $this->v01_dtoper = ($this->v01_dtoper == ""?$GLOBALS["HTTP_POST_VARS"]["v01_dtoper_ano"]."-".$GLOBALS["HTTP_POST_VARS"]["v01_dtoper_mes"]."-".$GLOBALS["HTTP_POST_VARS"]["v01_dtoper_dia"]:$this->v01_dtoper);
     $this->v01_valor = ($this->v01_valor == ""?$GLOBALS["HTTP_POST_VARS"]["v01_valor"]:$this->v01_valor);
   }
   // funcao para inclusao
   function incluir ($v01_coddiv){ 
      $this->atualizacampos();
     if($this->v01_numcgm == null ){ 
       $this->erro_sql = " Campo v01_numcgm nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_dtinsc == null ){ 
       $this->erro_sql = " Campo v01_dtinsc nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_exerc == null ){ 
       $this->erro_sql = " Campo v01_exerc nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_numpre == null ){ 
       $this->erro_sql = " Campo v01_numpre nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_numpar == null ){ 
       $this->erro_sql = " Campo v01_numpar nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_numtot == null ){ 
       $this->erro_sql = " Campo v01_numtot nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_numdig == null ){ 
       $this->erro_sql = " Campo v01_numdig nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_vlrhis == null ){ 
       $this->erro_sql = " Campo v01_vlrhis nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_proced == null ){ 
       $this->erro_sql = " Campo v01_proced nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_obs == null ){ 
       $this->erro_sql = " Campo v01_obs nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_livro == null ){ 
       $this->erro_sql = " Campo v01_livro nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_folha == null ){ 
       $this->erro_sql = " Campo v01_folha nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_dtvenc == null ){ 
       $this->erro_sql = " Campo v01_dtvenc nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_dtoper == null ){ 
       $this->erro_sql = " Campo v01_dtoper nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v01_valor == null ){ 
       $this->erro_sql = " Campo v01_valor nao declarado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->v01_coddiv = $v01_coddiv; 
     if(($this->v01_coddiv == null) || ($this->v01_coddiv == "") ){ 
       $this->erro_sql = " Campo v01_coddiv nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into divida(
                                       v01_coddiv 
                                      ,v01_numcgm 
                                      ,v01_dtinsc 
                                      ,v01_exerc 
                                      ,v01_numpre 
                                      ,v01_numpar 
                                      ,v01_numtot 
                                      ,v01_numdig 
                                      ,v01_vlrhis 
                                      ,v01_proced 
                                      ,v01_obs 
                                      ,v01_livro 
                                      ,v01_folha 
                                      ,v01_dtvenc 
                                      ,v01_dtoper 
                                      ,v01_valor 
                       )
                values (
                                $this->v01_coddiv 
                               ,$this->v01_numcgm 
                               ,'$this->v01_dtinsc' 
                               ,$this->v01_exerc 
                               ,$this->v01_numpre 
                               ,$this->v01_numpar 
                               ,$this->v01_numtot 
                               ,$this->v01_numdig 
                               ,$this->v01_vlrhis 
                               ,$this->v01_proced 
                               ,'$this->v01_obs' 
                               ,$this->v01_livro 
                               ,$this->v01_folha 
                               ,'$this->v01_dtvenc' 
                               ,'$this->v01_dtoper' 
                               ,$this->v01_valor 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " (.$this->v01_coddiv) nao Incluído. Inclusao Abortada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
     $this->erro_sql .= "Valores : ".$this->v01_coddiv;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($v01_coddiv=null) { 
      $this->atualizacampos();
     $sql = " update divida set ";
     $virgula = "";
     if($this->v01_coddiv != null ){ 
       $sql  .= $virgula." v01_coddiv = $this->v01_coddiv ";
       $virgula = ",";
     }
     if($this->v01_numcgm != null ){ 
       $sql  .= $virgula." v01_numcgm = $this->v01_numcgm ";
       $virgula = ",";
     }
     if($this->v01_dtinsc != null && $this->v01_dtinsc != "--"){ 
       $sql  .= $virgula." v01_dtinsc = '$this->v01_dtinsc' ";
       $virgula = ",";
     }     else{ 
       $sql  .= $virgula." v01_dtinsc = null ";
       $virgula = ",";
     }
     if($this->v01_exerc != null ){ 
       $sql  .= $virgula." v01_exerc = $this->v01_exerc ";
       $virgula = ",";
     }
     if($this->v01_numpre != null ){ 
       $sql  .= $virgula." v01_numpre = $this->v01_numpre ";
       $virgula = ",";
     }
     if($this->v01_numpar != null ){ 
       $sql  .= $virgula." v01_numpar = $this->v01_numpar ";
       $virgula = ",";
     }
     if($this->v01_numtot != null ){ 
       $sql  .= $virgula." v01_numtot = $this->v01_numtot ";
       $virgula = ",";
     }
     if($this->v01_numdig != null ){ 
       $sql  .= $virgula." v01_numdig = $this->v01_numdig ";
       $virgula = ",";
     }
     if($this->v01_vlrhis != null ){ 
       $sql  .= $virgula." v01_vlrhis = $this->v01_vlrhis ";
       $virgula = ",";
     }
     if($this->v01_proced != null ){ 
       $sql  .= $virgula." v01_proced = $this->v01_proced ";
       $virgula = ",";
     }
     if($this->v01_obs != null ){ 
       $sql  .= $virgula." v01_obs = '$this->v01_obs' ";
       $virgula = ",";
     }
     if($this->v01_livro != null ){ 
       $sql  .= $virgula." v01_livro = $this->v01_livro ";
       $virgula = ",";
     }
     if($this->v01_folha != null ){ 
       $sql  .= $virgula." v01_folha = $this->v01_folha ";
       $virgula = ",";
     }
     if($this->v01_dtvenc != null && $this->v01_dtvenc != "--"){ 
       $sql  .= $virgula." v01_dtvenc = '$this->v01_dtvenc' ";
       $virgula = ",";
     }     else{ 
       $sql  .= $virgula." v01_dtvenc = null ";
       $virgula = ",";
     }
     if($this->v01_dtoper != null && $this->v01_dtoper != "--"){ 
       $sql  .= $virgula." v01_dtoper = '$this->v01_dtoper' ";
       $virgula = ",";
     }     else{ 
       $sql  .= $virgula." v01_dtoper = null ";
       $virgula = ",";
     }
     if($this->v01_valor != null ){ 
       $sql  .= $virgula." v01_valor = $this->v01_valor ";
       $virgula = ",";
     }
     $sql .= " where  v01_coddiv = $this->v01_coddiv
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->v01_coddiv;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->v01_coddiv;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->v01_coddiv;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($v01_coddiv=null) { 
      $this->atualizacampos();
     $result = @pg_exec(" delete from divida
                    where  v01_coddiv = $v01_coddiv
                    ");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->v01_coddiv;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->v01_coddiv;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->v01_coddiv;
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
     return $result;
   }
   // funcao do sql 
   function sql_query ( $v01_coddiv=null,$campos="*",$ordem=null){ 
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
     $sql .= " from divida ";
     if($v01_coddiv!=null ){
       $sql .= " where v01_coddiv = $v01_coddiv"; 
     } 
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
   function sql_querynumcgm ( $v01_numcgm=null,$campos="*",$ordem=null){
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
     $sql .= " from divida inner join cgm on z01_numcgm = v01_numcgm ";
     if($v01_coddiv!=null ){
       $sql .= " where v01_numcgm = $v01_numcgm";
     }
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
   function sql_queryproced ( $v01_proced=null,$campos="*",$ordem=null){
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
     $sql .= " from divida inner join proced on v03_codigo = v01_proced ";
     if($v01_proced!=null ){
       $sql .= " where v01_proced = $v01_proced";
     }
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