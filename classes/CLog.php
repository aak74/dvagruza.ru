<?php
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


// global $USER;
// pr_var($USER, '$USER');

class CLog {
	private $folderName = "/upload/log/";
	private $traceDepth = 5;

    public function __construct($folderName = false) {
    	$this->folderName = ($folderName) ? $folderName : $this->folderName;
    }
	
    public function add2Log($sText) {
    	if (is_array($sText)) {

    	} else {
    	}
    	$fileName = $_SERVER["DOCUMENT_ROOT"] . $this->folderName . date("Ymd") . ".log";
    	$handle = fopen($fileName, "a+");
    	$str = date("Y-m-d H:i:s") . PHP_EOL
			.$sText . PHP_EOL;
		// fwrite($handle, $str);
		// fclose($handle);

        if(!is_string($sText))
        {
            $sText = var_export($sText, true);
        }
        if (strlen($sText)>0)
        {
            ignore_user_abort(true);
            if ($fp = @fopen($fileName, "ab"))
            {
                if (flock($fp, LOCK_EX))
                {
                    @fwrite($fp, 
                    	"Host: ".$_SERVER["HTTP_HOST"]."\n"
                    	. "Date: " . date("Y-m-d H:i:s") . "\n" 
                    	. "User: ". $GLOBALS['USER']->GetID() . "\n"
                    	. "-----\n" 
                    	. $sText. "\n"
                	);

                    $arBacktrace = Bitrix\Main\Diag\Helper::getBackTrace($this->traceDepth, ($bShowArgs? null : DEBUG_BACKTRACE_IGNORE_ARGS));
                    $strFunctionStack = "";
                    $strFilesStack = "";
                    $iterationsCount = min(count($arBacktrace), $this->traceDepth);
                    for ($i = 1; $i < $iterationsCount; $i++)
                    {
                        if (strlen($strFunctionStack)>0)
                            $strFunctionStack .= " < ";

                        if (isset($arBacktrace[$i]["class"]))
                            $strFunctionStack .= $arBacktrace[$i]["class"]."::";

                        $strFunctionStack .= $arBacktrace[$i]["function"];

                        if(isset($arBacktrace[$i]["file"]))
                            $strFilesStack .= "\t".$arBacktrace[$i]["file"].":".$arBacktrace[$i]["line"]."\n";
                        if($bShowArgs && isset($arBacktrace[$i]["args"]))
                        {
                            $strFilesStack .= "\t\t";
                            if (isset($arBacktrace[$i]["class"]))
                                $strFilesStack .= $arBacktrace[$i]["class"]."::";
                            $strFilesStack .= $arBacktrace[$i]["function"];
                            $strFilesStack .= "(\n";
                            foreach($arBacktrace[$i]["args"] as $value)
                                $strFilesStack .= "\t\t\t".$value."\n";
                            $strFilesStack .= "\t\t)\n";

                        }
                    }

                    if (strlen($strFunctionStack)>0)
                    {
                        @fwrite($fp, "    ".$strFunctionStack."\n".$strFilesStack);
                    }

                    @fwrite($fp, "------------------------------\n");
                    @fflush($fp);
                    @flock($fp, LOCK_UN);
                    @fclose($fp);
                }
            }
            ignore_user_abort(false);
        }
    }


}
?>
