<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arFields = array(
	1 => "NAME_FULL",
	2 => "KLADR",
	3 => "NAME_SHORT",
	4 => "NAME_REGION",
);

if (($handle = fopen("cities.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $list[$data[2]] = array(
            "UF_KLADR" => $data[2],
            "UF_ACTIVE" => $data[3],
        );
	}
    fclose($handle);
}
// CAkop::pr_var($list, 'list');

if (($handle = fopen("places.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    	if ( isset($list[$data[2]]) ) {
	        $list[$data[2]] = array_merge(
	        	$list[$data[2]],
	        	array(
		            "UF_NAME_SHORT" => $data[3],
		            "UF_NAME_FULL" => $data[1],
		            "UF_NAME_REGION" => $data[4],
	            )
	        );
	    }
	}
    fclose($handle);
}

// CAkop::pr_var($list, 'list');


$city = new CHLReference(6);

// CAkop::pr_var($terminals, 'terminals');
foreach ($list as $item) {
	$cityId = $city->updateEx($item, $item);
}

$result = $city->getList();
CAkop::pr_var($result, 'result');

?>