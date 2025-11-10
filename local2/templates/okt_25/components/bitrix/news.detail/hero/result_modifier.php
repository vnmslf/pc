<?if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();
$counter = count($arResult['PROPERTIES']['COL_NUMBER']['~VALUE']);
for ($i = 0; $i < $counter; $i++) {
	$prop[$i] = [
		$arResult['PROPERTIES']['COL_NUMBER']['~VALUE'][$i],
		$arResult['PROPERTIES']['COL_CAPT']['~VALUE'][$i],
		str_replace('{{year}}', date('Y') - 1, $arResult['PROPERTIES']['COL_TEXT']['~VALUE'][$i]),
	];
}
$arResult['PROPS'] = $prop;
$height_input = [
	'mobile'     => $arResult['PROPERTIES']['MOBILE']['VALUE'],
	'md-mobile'  => $arResult['PROPERTIES']['MD_MOBILE']['VALUE'],
	'lg-mobile'  => $arResult['PROPERTIES']['LG_MOBILE']['VALUE'],
	'xl-mobile'  => $arResult['PROPERTIES']['XL_MOBILE']['VALUE'],
	'tablet'     => $arResult['PROPERTIES']['TABLET']['VALUE'],
	'md-tablet'  => $arResult['PROPERTIES']['MD_TABLET']['VALUE'],
	'lg-tablet'  => $arResult['PROPERTIES']['LG_TABLET']['VALUE'],
	'xl-tablet'  => $arResult['PROPERTIES']['XL_TABLET']['VALUE'],
	'desktop'    => $arResult['PROPERTIES']['DESKTOP']['VALUE'],
	'md-desktop' => $arResult['PROPERTIES']['MD_DESKTOP']['VALUE'],
	'lg-desktop' => $arResult['PROPERTIES']['LG_DESKTOP']['VALUE'],
	'xl-desktop' => $arResult['PROPERTIES']['XL_DESKTOP']['VALUE'],
];
$arResult['PP'] = make_picture_height($arResult['PREVIEW_PICTURE'], $height_input);
?>