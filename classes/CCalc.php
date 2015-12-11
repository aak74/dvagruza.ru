<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CCalcException extends Exception {
}

abstract class CCalc {
	// public function __construct() {
	// }
	
	abstract public function calc($params);
	
	/** Обновляем города по базе Деловых линий, как наиболее продвинутых в поане API */
	public function updateTerminals() {
		$tk = new CDellin();
		// получаем список городов
		$result = $tk->getCities();
		/** по hash определяем изменилось ли что-то в их структуре
		 * если изменилось, тогда будем читать список терминалов в json
		 */

		$result = $tk->getTerminals();
		$cities = $this->_call('v1/public/cities.json');

		
 /*
		{
			"hash": "b38dc7ec0cfbfa63d8734caa9d53ae8fbcf9a39b1b793c57e2ec19694dd14408",
			"url": "http://api.dellin.ru/catalog/cities.csv?sk=6d3oAGj2_o9SYtWdqft7lw&e=1445174049"
		}
*/
	}


	/** Выдает терминалы компании. Внутри каждого города есть массив terminals, в которых перечислены все терминалы
	 * Териминалов в городе может быть более одного
	 */
	// abstract public function getTerminals();

	abstract public function getCities();

	protected function _call($url, $params = array()) {
	// private function _call($url, $params = array()) {
		CAkop::pr_var($params, 'params');
		$options = array(
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_POST => TRUE,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_ENCODING =>   'gzip',
			CURLOPT_URL => $url,
			CURLOPT_POSTFIELDS => json_encode($params),
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json; charset=utf-8',
			)
		);

		CAkop::pr_var($options, 'options');
		CAkop::pr_var($params, 'params');
		$ch = curl_init();
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			throw new CCalcException(curl_error($ch));
		}
		curl_close($ch);
		return json_decode($result, true);
	}
}
?>