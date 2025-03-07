﻿<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: ../index.php");
}else{ }


?>

<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
$datainicial= date('d/m/Y', strtotime($_POST['datainicial']));
$datafinal= date('d/m/Y', strtotime($_POST['datafinal']));
$exercicio= $_POST['exercicio'];
$empresa= $_POST['empresa'];


$html = '';


$html .= '<table width="100%" border="0">
  <tr>
    <td>PLNDATDIA</td>
    <td>PLACONTA</td>
    <td>PLANOME</td>
    <td>PLNPLANIL</td>
    <td>LACNUMLAN</td>
    <td>LACNUMDOC</td>
    <td>HISTORICO</td>
    <td>DEB</td>
    <td>CRED</td>
    <td>MOVIMENT</td>
    <td>CONTRAPARTIDA</td>
  </tr>';
  
  
 
$dataatual = date('d-m-Y');


$arquivo = "RAZAO ANALITICO - $dataatual.xls";

 $connect = odbc_connect("CMPRODUCAO", "system", "oracle11g")or die('Conexão CM Falhou');
 

  $SQLpegsel = "SELECT                                                      
   U.PLNDATDIA,                                               
   U.PLACONTA,
   U.PLANOME,
   U.PLNPLANIL,
   U.LACNUMLAN,
   U.LACNUMDOC,
   U.HISTORICO, 
   U.DEB,                                                           
   U.CRED, 
   U.MOVIMENT,
   U.CONTRAPARTIDA
   
FROM                                                            
 ( SELECT                                                       
    L.PLACONTA, 
 DECODE(PD.PLANOME,NULL,C.PLANOME,PD.PLANOME) AS PLANOME, 
 SC.NOMESUBCONTA, CC.NOME AS NOMECC, C.PLAGRAU, 
   U.UNECODIGO, U.UNIDNEGOC, U.NOME,    
(0.00) AS SALDOCABECALHO, (' ') AS DEBCRECABECALHO,  
   L.PLACONTA AS PLACONTAREF, 
   NVL(PD.PLANOME,C.PLANOME) AS PLANOMEREF, 
   L.LACHIST1,L.LACHIST2,L.LACHIST3,L.LACHIST4,L.LACHIST5,L.LACTIPCONVOFICIAL,  
   (NVL(RTRIM(L.LACHIST1),' ')||' '||NVL(RTRIM(L.LACHIST2),' ')||' '||                  
    NVL(RTRIM(L.LACHIST3),' ')||' '||NVL(RTRIM(L.LACHIST4),' ')||' '||NVL(RTRIM(L.LACHIST5),' ')) AS HISTORICO, 
   C.PLACONCORRESP,  
   L.IDMODULO,                                         
   P.PLNEFETIVADO, TO_CHAR(P.PLNDATDIA,'YYYYMM') AS PERIODO,   
   DECODE(P.PLNEFETIVADO,'S','*',' ') AS EFET,             
   SA.SALDOANT, SS.SALDO, P.PLNCODIGO, P.PLNPLANIL, P.PLNDATDIA, 
   L.LACVALOR,  
   TO_NUMBER(DECODE(L.LACDEBCRE, 'D', L.LACVALOR, (L.LACVALOR * (-1)))) AS MOVIMENT,
   (TO_CHAR(P.PLNPLANIL,'99999999')||'/'||TO_CHAR(L.LACNUMLAN,'9999')) AS LANCAMENTO, 
   (TO_NUMBER(DECODE(L.LACDEBCRE, 'D', L.LACVALOR, 0.00))) AS DEB,                
   (TO_NUMBER(DECODE(L.LACDEBCRE, 'C', L.LACVALOR, 0.00))) AS CRED,                   
   PE.NOME AS NOMEPATRO, PP.NOME AS NOMEPLANOPREV,                    
   L.IDPATRO, L.IDPLANOPREV,                                          
   (0.00) AS SALDOCORRENTE,                                           
   (' ')  AS DEBCRE,                                                
   DECODE(CP.CONTRAPARTIDA,NULL,CP1.CONTRAPARTIDA,CP.CONTRAPARTIDA) AS CONTRAPARTIDA, 
   L.CODCENTROCUSTO, L.CODSUBCONTA, L.LACNUMLAN AS LACNUMLAN,         
   L.LACDEBCRE, L.LACNUMDOC, L.IDEMPRESA, P.IDPESSOA, L.IDPESSOA AS EMPRESALANC    
FROM                                                                  
   LANCAMENTO L, PLANILHA P, PLANOCONTA C, SUBCONTA SC, UNIDNEGOCIO U, CENTCUST CC,PESSOA PE, PLANPREVCONTABIL PP, 
(SELECT P.PLATIPO, P.PLAINATIVA,P.PLANOME, P.PLACONTA, P.PLANO 
  FROM  PLANOCONTAPER P,                                       
        (SELECT PLACONTA, PLANO,                               
               MIN(LPAD(  LPAD(TO_CHAR(NVL(PERNUMERO,0)),2,'0')  ,6,TO_CHAR(PEREXERCICIO) )) AS PERNUMERO 
         FROM PLANOCONTAPER                                   
         WHERE (PEREXERCICIO = TO_NUMBER(SUBSTR('".$exercicio."'||SUBSTR(".$datainicial.",3,2),1,4))) 
           AND (PERNUMERO  = TO_NUMBER(SUBSTR('".$exercicio."'||SUBSTR(".$datainicial.",3,2),5,2)))   
           AND (IDPESSOA = ".$empresa.") 
             GROUP BY  PLACONTA, PLANO) PX 
  WHERE (P.PLACONTA = PX.PLACONTA) 
    AND (P.PLANO = PX.PLANO)       
    AND (P.IDPESSOA = ".$empresa.") 
    AND (P.PEREXERCICIO = TO_NUMBER(SUBSTR(PX.PERNUMERO,1,4))) 
    AND (P.PERNUMERO  = TO_NUMBER(SUBSTR(PX.PERNUMERO,5,2))))  
 PD, 
     (SELECT L1.PLNCODIGO, L1.LACNUMLAN, L1.LACDEBCRE,                
             L1.PLACONTA AS CONTRAPARTIDA                       
      FROM PLANILHA P1, LANCAMENTO L1, PLANOCONTA C                
      WHERE                                                        
            (P1.PLNDATDIA >=TO_DATE('".$datainicial."','DD/MM/YYYY'))            
        AND (P1.PLNDATDIA <=TO_DATE('".$datafinal."','DD/MM/YYYY'))            
        AND (P1.PEREXERCICIO >= '".$exercicio."')      
        AND (C.PLANO in (1,2,4,8))                                  
        AND (P1.IDPESSOA = ".$empresa.")                           
        AND (EXISTS (SELECT X.PLNCODIGO                            
                     FROM PLANILHA X, LANCAMENTO Y                 
                     WHERE                                         
                           (X.PLNDATDIA >=TO_DATE('".$datainicial."','DD/MM/YYYY'))                
                       AND (X.PLNDATDIA <=TO_DATE('".$datafinal."','DD/MM/YYYY'))                
                       AND (X.PEREXERCICIO >= '".$exercicio."')          
                     AND (X.IDPESSOA = ".$empresa.")  
                     and SUBSTR(RTRIM(y.PLACONTA) ,0,1) >= 3 
                     AND (X.PLNCODIGO = Y.PLNCODIGO)              
                       AND (P1.PLNCODIGO = X.PLNCODIGO)))           
        AND (L1.PLNCODIGO=P1.PLNCODIGO)                             
        AND (C.PLANO in (1,2,4,8))                                   
        AND (L1.LACTIPO = '2')                                    
        AND (C.PLANO = L1.PLANO)                                    
        AND (C.PLACONTA = L1.PLACONTA))  CP,                        
     ( SELECT L2.PLNCODIGO, L2.LACNUMLAN, L2.LACDEBCRE,             
             L2.PLACONTA AS CONTRAPARTIDA                           
      FROM PLANILHA P2, LANCAMENTO L2, PLANOCONTA C,                   
          (SELECT L3.PLNCODIGO, COUNT(*) AS CONTA                      
           FROM PLANILHA P3, LANCAMENTO L3                             
           WHERE                                                       
                 (P3.PLNDATDIA >=TO_DATE('".$datainicial."','DD/MM/YYYY'))                             
             AND (P3.PLNDATDIA <=TO_DATE('".$datafinal."','DD/MM/YYYY'))                             
             AND (P3.PEREXERCICIO >= '".$exercicio."')                       
           AND (P3.IDPESSOA = ".$empresa.")                             
             AND (P3.PLNCODIGO = L3.PLNCODIGO)                         
           GROUP BY L3.PLNCODIGO                                      
           HAVING COUNT(*) = 2) N                                    
      WHERE                                                          
            (P2.PLNDATDIA >=TO_DATE('".$datainicial."','DD/MM/YYYY') )              
        AND (P2.PLNDATDIA <=TO_DATE('".$datafinal."','DD/MM/YYYY') )              
        AND (P2.PEREXERCICIO >= '".$exercicio."')                           
           AND (P2.IDPESSOA = ".$empresa.")                              
        AND (EXISTS (SELECT X.PLNCODIGO                                
                     FROM PLANILHA X, LANCAMENTO Y                     
                     WHERE                                             
                           (X.PLNDATDIA >= TO_DATE('".$datainicial."','DD/MM/YYYY')) 
                       AND (X.PLNDATDIA <= TO_DATE('".$datafinal."','DD/MM/YYYY')) 
                       AND (X.PEREXERCICIO >= '".$exercicio."')              
                     AND (X.IDPESSOA = ".$empresa.")              
                       AND (X.PLNCODIGO = Y.PLNCODIGO) 
                       and  SUBSTR(RTRIM(y.PLACONTA) ,0,1) >= 3 
                              
         AND (P2.PLNCODIGO = X.PLNCODIGO)))               
         AND (L2.PLNCODIGO = P2.PLNCODIGO)                               
         AND (L2.LACTIPO <> '2' )                                     
         AND (C.PLANO = L2.PLANO)                                       
         AND (C.PLACONTA = L2.PLACONTA)                                 
        AND (C.PLANO in (1,2,4,8))                                   
         AND (N.PLNCODIGO = L2.PLNCODIGO)) CP1,                         
   (SELECT                                                              
       S.PLACONTA,                                                      
       SUM(TO_NUMBER(DECODE(S.PLSDEBITOCORRENTE, NULL, 0.00, S.PLSDEBITOCORRENTE)) - TO_NUMBER(DECODE(S.PLSCREDITOCOR, NULL, 0.00, S.PLSCREDITOCOR))) AS SALDOANT 
    FROM PLANOSALDO S  ,SUBCONTA SC                                      
    WHERE                                                                
	      (S.PEREXERCICIO ='".$exercicio."') AND                                  
       (S.PERNUMERO IS NULL) AND                                         
         (S.PLANO in(1,2,4,8)) AND                               
       SUBSTR(RTRIM(S.PLACONTA) ,0,1) >= 3 and                                 
       (S.IDPESSOA = ".$empresa.")  AND                                 
      (S.CODSUBCONTA = SC.CODSUBCONTA(+)) AND                           
      (S.IDPESSOA    = SC.IDPESSOA(+))                                  
    GROUP BY S.PLACONTA                                                 
    ) SA,                                                             
   (SELECT                                                               
       L.PLACONTA,                                                       
       SUM(DECODE(L.LACDEBCRE, 'D', L.LACVALOR, (L.LACVALOR * (-1)))) AS SALDO
    FROM PLANILHA P, LANCAMENTO L, SUBCONTA SC                                     
    WHERE                                                               
	         (P.PEREXERCICIO ='".$exercicio."') AND                              
          (P.PLNDATDIA < TO_DATE('".$datainicial."','DD/MM/YYYY')) AND 
       (P.PLNEFETIVADO = 'S') AND                                  
          (P.IDPESSOA = ".$empresa.") AND  
          SUBSTR(RTRIM(L.PLACONTA) ,0,1) >= 3 and 
                             
       (L.CODSUBCONTA = SC.CODSUBCONTA(+)) AND                        
       (L.IDPESSOA = SC.IDPESSOA(+))  AND                            
       (L.PLNCODIGO = P.PLNCODIGO)                                   
    GROUP BY L.PLACONTA                                               
    ) SS                                                              
WHERE                                                                 
    (P.PLNDATDIA >=TO_DATE('".$datainicial."','DD/MM/YYYY')) AND                   
    (P.PLNDATDIA <=TO_DATE('".$datafinal."','DD/MM/YYYY')) AND                   
    (P.PEREXERCICIO >= '".$exercicio."') AND 
 (P.PLNEFETIVADO = 'S') AND                                      
   (P.IDPESSOA = ".$empresa.") AND                                  
    (L.PLNCODIGO = P.PLNCODIGO) AND  
    SUBSTR(RTRIM(L.PLACONTA) ,0,1) >= 3 and 
                        
    (C.PLANO      = PD.PLANO(+)) AND                                 
    (C.PLACONTA   = PD.PLACONTA(+)) AND                              
         (C.PLANO in (1,2,4,8)) AND                                  
    ((L.UNIDNEGOC = U.UNIDNEGOC(+)) AND                              
    (L.IDPESSOA   = U.IDPESSOA(+))) AND                              
   (L.PLNCODIGO = CP.PLNCODIGO(+)) AND                            
   (L.LACNUMLAN = CP.LACNUMLAN(+)) AND                            
   ((L.LACDEBCRE <> CP.LACDEBCRE) OR (CP.LACDEBCRE IS NULL)) AND  
   (L.PLNCODIGO = CP1.PLNCODIGO(+)) AND                           
   (L.LACDEBCRE <> CP1.LACDEBCRE(+)) AND                          
    (L.IDPLANOPREV = PP.IDPLANOPREV(+)) AND                          
    (L.IDPATRO      = PE.IDPESSOA(+)) AND                                 
    (L.CODCENTROCUSTO = CC.CODCENTROCUSTO(+)) AND                    
    (L.IDEMPRESA = CC.IDEMPRESA(+)) AND                              
    (L.PLACONTA = SA.PLACONTA(+)) AND                                
    (L.PLACONTA = SS.PLACONTA(+)) AND                                
    (L.CODSUBCONTA = SC.CODSUBCONTA(+)) AND                          
    (L.IDPESSOA    = SC.IDPESSOA(+)) AND                             
    (L.PLANO       = C.PLANO) AND                                    
    (L.PLACONTA    = C.PLACONTA)                                     
) U, EMPRESAPROP EMP  WHERE (1 = 1) AND EMP.IDPESSOA = U.EMPRESALANC
ORDER BY 
    U.PLACONTAREF, U.PLNDATDIA, U.PLNPLANIL, U.LACNUMLAN
    
    
   
    "; 


 
$resultsel = odbc_exec($connect,$SQLpegsel);



//echo $SQLpegsel;




//$arquivo = fopen('sqlexecutado.txt','w'); 
//if ($arquivo == false) die('Não foi possível criar o arquivo.'); 

//fwrite($arquivo, $SQLpegsel);

while($rowssel=odbc_fetch_object($resultsel)) {
	
$html .= ' <tr>
    <td>'.odbc_result($resultsel, "PLNDATDIA").'</td>
    <td>'.odbc_result($resultsel, "PLACONTA").'</td>
    <td>'.odbc_result($resultsel, "PLANOME").'</td>
    <td>'.odbc_result($resultsel, "PLNPLANIL").'</td>
    <td>'.odbc_result($resultsel, "LACNUMLAN").'</td>
    <td>'.odbc_result($resultsel, "LACNUMDOC").'</td>
    <td>'.odbc_result($resultsel, "HISTORICO").'</td>
    <td>'.odbc_result($resultsel, "DEB").'</td>
    <td>'.odbc_result($resultsel, "CRED").'</td>
    <td>'.odbc_result($resultsel, "MOVIMENT").'</td>
    <td>'.odbc_result($resultsel, "CONTRAPARTIDA").'</td>
  </tr>';





}

$html .= '</table>';

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );
// Envia o conteúdo do arquivo
echo $html;
exit;

?>
