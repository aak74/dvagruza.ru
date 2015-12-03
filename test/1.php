<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
// Создание экземпляра класса

	$sdk = new PecomKabinet('ak74', '16351BB897654D2A119E938565F0E4BAB1AD6665');
	// $sdk = new PecomKabinet('user', 'FA218354B83DB72D3261FA80BA309D5454ADC');
	// Вызов метода
	$result = $sdk->call('branches', 'all', null);
	// $result = json_decode($sdk->call('branches', 'all', null), true);
	$sdk->close();
	
	// Вывод результата
	// CAkop::pr_var($result, 'result');
	
	$cities = new CHLReference(1);
	$branches = new CHLReference(3);
	foreach ($result->branches as $city) {
		$cityFilter = $cityParams = array("UF_CITY_NAME" => $city->title);
		$cityId = $cities->updateEx($cityFilter, $cityParams);
		
		$branchesFilter = array("UF_CITY_ID" => $cityId);
		$branchesParams = array(
			"UF_CITY_ID" => $cityId,
			"UF_COMP_ID" => 1,
			"UF_BRANCH_ADDRESS" => $city->address,
			// "UF_BRANCH_PHONES" => $city->title,
			"UF_BRANCH_XML_ID" => $city->bitrixId,
			"UF_BRANCH_POST" => $city->postalCode,
		);
		
		$branchId = $branches->updateEx($branchesFilter, $branchesParams);
	}

	// $cities = new CHLReference(1);
	$result = $cities->getList(array("UF_CITY_NAME" => "asc"), array(">ID" => 100));
	CAkop::pr_var($result, 'result');
	
	// Освобождение ресурсов
?>