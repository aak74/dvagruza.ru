<?
defined("DEVEL") or define("DEVEL", true);

/**
 * Класс для доступа к различным функциям
 *
 * @author Андрей Копылов aakopylov@mail.ru
 */
class CAkop {

	function pr_var($avar, $atitle='') {
		if (DEVEL) {
			echo 'count=' . count($avar) . '<div class="devel">';
			echo '<b>'.$atitle.'</b><pre>';
			print_r($avar);
			echo '</pre></div>';
		}

	}  

	function getRequest($aName, $special = false){
		$result = isset($_REQUEST[$aName])
						?$_REQUEST[$aName]
						:"";
		return $special ? htmlspecialchars($result, ENT_QUOTES) : $result;
	}

	function getUUID() {
		/**
		* Возвращает uuid.v4 RFC 4122 (http://www.ietf.org/rfc/rfc4122.txt)
		* cut from http://www.php.net/manual/en/function.uniqid.php#94959 
		*/
	    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff),

			// 16 bits for "time_mid"
			mt_rand(0, 0xffff),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand(0, 0x0fff) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand(0, 0x3fff) | 0x8000,

			// 48 bits for "node"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
	    );
	}
}

?>
