<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/company/(.*)/#",
		"RULE" => "xml_id=$1",
		"ID" => "",
		"PATH" => "/app/company/index.php",
	),
	array(
		"CONDITION" => "#^/terminal/(.*)/#",
		"RULE" => "id=$1",
		"ID" => "",
		"PATH" => "/app/terminal/index.php",
	),
	array(
		"CONDITION" => "#^/city/(.*)/#",
		"RULE" => "id=$1",
		"ID" => "",
		"PATH" => "/app/city/index.php",
	),
);

?>