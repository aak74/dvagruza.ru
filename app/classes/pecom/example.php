<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Минимальный пример использования SDK</title>
	</head>
<body>
<pre>
<?php	
	// Подключение файла с классом
	require_once('pecom_kabinet.php');

	// Создание экземпляра класса
	$sdk = new PecomKabinet('ak74', '16351BB897654D2A119E938565F0E4BAB1AD6665');
	// $sdk = new PecomKabinet('user', 'FA218354B83DB72D3261FA80BA309D5454ADC');

	// Вызов метода
	$result = $sdk->call('branches', 'all', null);
	
	// Вывод результата
	var_dump($result);
	
	// Освобождение ресурсов
	$sdk->close();
?>
</pre>
</body>
</html>