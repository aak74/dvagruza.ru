<?
foreach ($arMENU as $key => $value) {
    # code...
     // $sMenu .= '<a href="'.$LINK.'" title="'.$TEXT.'">'.$TEXT.'</a>';
}

$sMenu .= '<div class="bottom-menu"><ul class="nav nav-pills">';
$CurDir = $APPLICATION->GetCurDir();
for ( $i=0; $i < count($arMENU); $i++ ) {
    $sMenu .= '<li role="presentation">';
    $MENU_ITEM = $arMENU[$i];
    extract($MENU_ITEM);
    if ($APPLICATION->GetCurPage() == "/404.php") $SELECTED = false;
    if ($SELECTED) {
        if ($CurDir == $LINK) {
            $sMenu .= '<strong>'.$TEXT.'</strong>';
        } else {
            $sMenu .= '<a href="'.$LINK.'" title="'.$TEXT.'">'.$TEXT.'</a>';
        }
        $GLOBALS["CUR_DIR_HREF"] = $LINK;
        $GLOBALS["CUR_DIR_TEXT"] = $TEXT;
    } else {
        $sMenu .= '<a href="'.$LINK.'" title="'.$TEXT.'">'.$TEXT.'</a>';
    }
    $sMenu .= $TdAddText;
    $sMenu .= '</li>';
}
$sMenu .= '</ul></div>';
?>

