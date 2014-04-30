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
if($tipo_pesq[0] != "numpre" ) { // inicio do tipo de certidao 

			  $sql_c = "select k00_dtvenc ";

			  if($tipo_pesq[0] == "numcgm"){
			    $sql_c = $sql_c . " from arrenumcgm";
			  }else if($tipo_pesq[0] == "matric"){
			    $sql_c = $sql_c . " from arrematric ";
			    $sql_c = $sql_c . " inner join arrenumcgm on arrematric.k00_numpre = arrenumcgm.k00_numpre ";
			  }else if($tipo_pesq[0] == "inscr"){
			    $sql_c = $sql_c . " from arreinscr ";
			    $sql_c = $sql_c . " inner join arrenumcgm on arreinscr.k00_numpre = arrenumcgm.k00_numpre ";
			  }else{
			     $sql_c = $sql_c . " from arrenumcgm ";
			  }
			  
			  $sql_c .= " inner join arrecad 	on arrecad.k00_numpre = arrenumcgm.k00_numpre";
			  $sql_c .= " inner join arretipo 	on arretipo.k00_tipo = arrecad.k00_tipo";
			  $sql_c .= " inner join cadtipo  	on arretipo.k03_tipo = cadtipo.k03_tipo";
			  $sql_c .= " left  join arrejustreg    on arrejustreg.k28_numpre = arrecad.k00_numpre and ";
			  $sql_c .= " 				   arrejustreg.k28_numpar = arrecad.k00_numpar";
			  $sql_c .= " left join arrejust 	on arrejust.k27_sequencia = arrejustreg.k28_arrejust";
//			  $sql_c .= " and k03_parcelamento = 'f'";

			  if($tipo_pesq[0] == "numcgm"){
			    $sql_c = $sql_c . " where arrenumcgm.k00_numcgm = ".$tipo_pesq[1];
			  }else if($tipo_pesq[0] == "matric"){
			    $sql_c = $sql_c . " where k00_matric = ".$tipo_pesq[1];
			  }else if($tipo_pesq[0] == "inscr"){
			    $sql_c = $sql_c . " where k00_inscr = ".$tipo_pesq[1];
			  }else{
			     $sql_c = $sql_c . " where arrecad.k00_numpre = ".$tipo_pesq[1];
			  }
			  $sql = $sql_c . " and k00_dtvenc < '".date("Y-m-d",db_getsession("DB_datausu"))."'";
			  $sql = $sql . ($k03_certissvar=='t'?" and k00_valor <> 0 ":"");
			  $sql = $sql . " and case when k28_numpre is not null then case when k27_data + k27_dias >= '" . date("Y-m-d",db_getsession("DB_datausu")) . "' then false else true end else true end";
			  $sql = $sql . " limit 1 ";
//			echo($sql . "<br>");
			$dados = pg_exec($sql) or die($sql);
		        if(pg_numrows($dados)>0){
		          $certidao="positiva";
		        }else{

			  $sql_c = "select k00_dtvenc ";
			  if($tipo_pesq[0] == "numcgm"){
			    $sql_c = $sql_c . " from arrenumcgm ";
			  }else if($tipo_pesq[0] == "matric"){
			    $sql_c = $sql_c . " from arrematric ";
			    $sql_c = $sql_c . " inner join arrenumcgm on arrematric.k00_numpre = arrenumcgm.k00_numpre";
			  }else if($tipo_pesq[0] == "inscr"){
			    $sql_c = $sql_c . " from arreinscr ";
			    $sql_c = $sql_c . " inner join arrenumcgm on arreinscr.k00_numpre = arrenumcgm.k00_numpre ";
			  }else{
			     $sql_c = $sql_c . " from arrenumcgm ";
			  }
			  
			  $sql_c .= "	inner join arrecad 	on arrecad.k00_numpre = arrenumcgm.k00_numpre";
			  $sql_c .= "	inner join arretipo 	on arretipo.k00_tipo = arrecad.k00_tipo";
			  $sql_c .= "	inner join cadtipo  	on arretipo.k03_tipo = cadtipo.k03_tipo";
			  $sql_c .= "	and k03_parcelamento = 't'";
			  $sql_c .= "   left  join arrejustreg  on arrejustreg.k28_numpre = arrecad.k00_numpre and ";
			  $sql_c .= " 				   arrejustreg.k28_numpar = arrecad.k00_numpar";
			  $sql_c .= "   left join arrejust 	on arrejust.k27_sequencia = arrejustreg.k28_arrejust";

			  if($tipo_pesq[0] == "numcgm"){
			    $sql_c = $sql_c . " where arrenumcgm.k00_numcgm = ".$tipo_pesq[1];
			  }else if($tipo_pesq[0] == "matric"){
			    $sql_c = $sql_c . " where k00_matric = ".$tipo_pesq[1];
			  }else if($tipo_pesq[0] == "inscr"){
			    $sql_c = $sql_c . " where k00_inscr = ".$tipo_pesq[1];
			  }else{
			     $sql_c = $sql_c . " where arrecad.k00_numpre = ".$tipo_pesq[1];
			  }
	               
//			  $sql_c = $sql_c . " and k00_dtvenc < '".date("Y-m-d",db_getsession("DB_datausu"))."'";
			  $sql_c = $sql_c . ($k03_certissvar=='t'?" and k00_valor <> 0 ":"");
			  $sql_c = $sql_c . " and case when k28_numpre is not null then case when k27_data + k27_dias > '" . date("Y-m-d",db_getsession("DB_datausu")) . "' then false else true end else true end";
			  $sql_c = $sql_c . " limit 1 ";
//			  echo $sql_c . "<br>";
	    	          $dados = pg_exec($sql_c);
		          if(pg_numrows($dados)>0){
		            $certidao="regular";
			  }else{
			    $certidao="negativa";
			  }

		         }


                        } // fim do tipo de certidao