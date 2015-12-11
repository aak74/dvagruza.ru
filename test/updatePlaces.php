<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$city = new CCityAll();
if (($handle = fopen("places.csv", "r")) !== FALSE) {
	$i = 0;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    	if ($i++ > 150000) {
	        $item = array(
	    		"UF_KLADR" => $data[2],
	            "UF_NAME_SHORT" => $data[3],
	            "UF_NAME_FULL" => $data[1],
	            "UF_NAME_REGION" => $data[4],
	            "UF_KLADR_REGION" => $data[5],
	        );
			$filter["UF_KLADR"] = $item["UF_KLADR"];
			$cityId = $city->updateEx($filter, $item);
    	}
	}
    fclose($handle);
}

// CAkop::pr_var($list, 'list');

echo "Completed!";
/*
$result = $city->getList();
CAkop::pr_var($result, 'result');
*/
?>