     
<?php 

function  check_numtva($nr) {
  try {
  
   
    $opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);

    $wsdlUrl = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';
    $soapClientOptions = array(
        'stream_context' => $context,
        'cache_wsdl' => WSDL_CACHE_NONE
    );

    $client = new SoapClient($wsdlUrl, $soapClientOptions);

	
	       $c=substr($nr, 0, 2);
           $n=substr($nr, 2);
  
          $checkVatParameters = array(
            'countryCode' => $c,
            'vatNumber' => $n
    );

    $result = $client->checkVat($checkVatParameters);
    
	//format json
	$jsonconvt=  json_encode($result);
	//format tableau 
	$dataArray = json_decode($jsonconvt);
	

   //pour le l'affichage sous format HTML 
   echo  "<table >" ;
   
   
   foreach($dataArray as $indx => $val ) {
	   
       echo  "<div style='border:2px black solid'>". $indx . "   :  " .$val . "</div>";	   
   }
   echo  "</table>";   
  
	echo "</br>";
	
	//l'étape suivante c'est juste pour pas avoir la valeur NULL pour le retour de fonction 
	//c'est  l'affichage de base 
	return  $dataArray;
}
catch(Exception $e) {
    echo $e->getMessage();
}

}

$r =  check_numtva('NL003028112B01');

var_export($r);




?>