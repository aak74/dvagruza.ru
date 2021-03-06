<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?>
<div class="contacts container clearfix">

	<p>ВНИМАНИЕ! Мы не занимаемся грузоперевозками. Мы предоставляем информацию о выгодных ценах на перевозку грузов.</p>

	<h3>С нами можно связаться:</h3>
	<ul>
		<li>по электронной почте: dvagruza@gmail.com</li>
		<li>либо отправив сообщение, заполнив форму:</li>
	</ul>
	<p>Любой вопрос по работе сервиса Вы можете задать отправив эту форму. Предложения принимаются тут же.</p>
	<p>Если ваше сообщение предполагает ответ, пожалуйста, оставьте свои контактные данные</p>
	<?$APPLICATION->IncludeComponent(
		"api:main.feedback",
		"bootstrap",
		Array(
			"USE_CAPTCHA" => "N",
			"USE_HIDDEN_PROTECTION" => "Y",
			"REPLACE_FIELD_FROM" => "Y",
			"UNIQUE_FORM_ID" => "90d63044dcb463f4b476fd5ccf2af7ee",
			"OK_TEXT" => "Спасибо, Ваше сообщение принято.",
			"EMAIL_TO" => "aa74ko@gmail.com",
			"DISPLAY_FIELDS" => array("AUTHOR_NAME","AUTHOR_EMAIL","AUTHOR_PERSONAL_MOBILE","AUTHOR_MESSAGE"),
			"REQUIRED_FIELDS" => array("AUTHOR_NAME","AUTHOR_MESSAGE"),
			"CUSTOM_FIELDS" => array(""),
			"ADMIN_EVENT_MESSAGE_ID" => array("8"),
			// "USER_EVENT_MESSAGE_ID" => array(),
			"USER_EVENT_MESSAGE_ID" => array("9"),
			"TITLE_DISPLAY" => "N",
			"FORM_TITLE" => "Какой-то заголовок",
			"FORM_TITLE_LEVEL" => "1",
			"FORM_STYLE_TITLE" => "",
			"FORM_STYLE" => "",
			"FORM_STYLE_DIV" => "",
			"FORM_STYLE_LABEL" => "",
			"FORM_STYLE_TEXTAREA" => "",
			"FORM_STYLE_INPUT" => "",
			"FORM_STYLE_SELECT" => "",
			"FORM_STYLE_SUBMIT" => "",
			"FORM_SUBMIT_VALUE" => "Отправить",
			"INCLUDE_JQUERY" => "N",
			"VALIDTE_REQUIRED_FIELDS" => "Y",
			"INCLUDE_PLACEHOLDER" => "Y",
			"INCLUDE_PRETTY_COMMENTS" => "N",
			"INCLUDE_FORM_STYLER" => "N",
			"HIDE_FORM_AFTER_SEND" => "N",
			"SCROLL_TO_FORM_IF_MESSAGES" => "N",
			"SCROLL_TO_FORM_SPEED" => "1000",
			"BRANCH_ACTIVE" => "N",
			"SHOW_FILES" => "N",
			"USER_AUTHOR_FIO" => "",
			"USER_AUTHOR_NAME" => "",
			"USER_AUTHOR_LAST_NAME" => "",
			"USER_AUTHOR_SECOND_NAME" => "",
			"USER_AUTHOR_EMAIL" => "",
			"USER_AUTHOR_PERSONAL_MOBILE" => "",
			"USER_AUTHOR_WORK_COMPANY" => "",
			"USER_AUTHOR_POSITION" => "",
			"USER_AUTHOR_PROFESSION" => "",
			"USER_AUTHOR_STATE" => "",
			"USER_AUTHOR_CITY" => "",
			"USER_AUTHOR_STREET" => "",
			"USER_AUTHOR_ADRESS" => "",
			"USER_AUTHOR_PERSONAL_PHONE" => "",
			"USER_AUTHOR_WORK_PHONE" => "",
			"USER_AUTHOR_FAX" => "",
			"USER_AUTHOR_MAILBOX" => "",
			"USER_AUTHOR_WORK_MAILBOX" => "",
			"USER_AUTHOR_SKYPE" => "",
			"USER_AUTHOR_ICQ" => "",
			"USER_AUTHOR_WWW" => "",
			"USER_AUTHOR_WORK_WWW" => "",
			"USER_AUTHOR_MESSAGE_THEME" => "",
			"USER_AUTHOR_MESSAGE" => "",
			"USER_AUTHOR_NOTES" => "",
			"AJAX_MODE" => "Y",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"SHOW_CSS_MODAL_AFTER_SEND" => "N",
			"CSS_MODAL_HEADER" => "Информация",
			"CSS_MODAL_FOOTER" => "<a href=\"http://tuning-soft.ru/\" target=\"_blank\">Разработка модуля</a> - Тюнинг Софт",
			"CSS_MODAL_CONTENT" => "",
			"AJAX_OPTION_ADDITIONAL" => ""
		)
	);
	?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>