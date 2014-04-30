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
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>BrainJar.com: Tabs Demo</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="/common/default.css" rel="stylesheet" type="text/css" />
<style type="text/css">

div.tabArea {
  font-size: 100%;
 // font-weight: bold;
}

a.tab {
  background-color: #FFFFFF;
  border: 1px solid #000000;
  border-bottom-width: 0px;
  padding: 2px 1em 2px 1em;
  text-decoration: none;
}

a.tab, a.tab:visited {
  color: #808080;
}

a.tab:hover {
  background-color:#CCCCCC;
  color: #606060;
}



</style>
</head>
<body>


<div class="tabArea">
  <a class="tab">Endereço</a>
  <a class="tab" href="testekk.php" target="tabIframe1">News</a>
  <a class="tab">Socios</a>
  <a class="tab">Valores</a>
  <a class="tab">Valores2</a>
  <a class="tab">Envia DAI</a>
</div>

  <div class="tabMain">
    <div class="tabIframeWrapper"><iframe  name="tabIframe1" src="news.html" marginheight="8" marginwidth="8" frameborder="0" style="height:18ex;"></iframe></div>
  </div>
  
</body>
</html>