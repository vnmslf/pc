<?
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
if($arResult['PREVIEW_PICTURE']) {
	$arResult['PP'] = make_picture($arResult['PREVIEW_PICTURE'], $height_input);
}
?>