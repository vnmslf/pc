<?if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();
$rsSections = CIBlockSection::GetList(
	Array('SORT' => 'ASC'),
	Array(
		'=IBLOCK_ID' => $arParams['IBLOCK_ID'],
		'=ACTIVE'    => 'Y'
	)
);
while ($arSection = $rsSections->GetNext()) {
	$arSections[$arSection['ID']] = $arSection;
}
foreach($arResult['ITEMS'] as $arItem) {
	$height_input = [
		'mobile'     => $arItem['PROPERTIES']['MOBILE']['VALUE'],
		'md-mobile'  => $arItem['PROPERTIES']['MD_MOBILE']['VALUE'],
		'lg-mobile'  => $arItem['PROPERTIES']['LG_MOBILE']['VALUE'],
		'xl-mobile'  => $arItem['PROPERTIES']['XL_MOBILE']['VALUE'],
		'tablet'     => $arItem['PROPERTIES']['TABLET']['VALUE'],
		'md-tablet'  => $arItem['PROPERTIES']['MD_TABLET']['VALUE'],
		'lg-tablet'  => $arItem['PROPERTIES']['LG_TABLET']['VALUE'],
		'xl-tablet'  => $arItem['PROPERTIES']['XL_TABLET']['VALUE'],
		'desktop'    => $arItem['PROPERTIES']['DESKTOP']['VALUE'],
		'md-desktop' => $arItem['PROPERTIES']['MD_DESKTOP']['VALUE'],
		'lg-desktop' => $arItem['PROPERTIES']['LG_DESKTOP']['VALUE'],
		'xl-desktop' => $arItem['PROPERTIES']['XL_DESKTOP']['VALUE'],
	];
	if($arItem['PREVIEW_PICTURE']) {
		$arItem['PP'] = make_picture_min($arItem['PREVIEW_PICTURE'], $height_input);
	}
	$arSections[$arItem['IBLOCK_SECTION_ID']]['ITEMS'][] = $arItem;
}
$arResult['SECTIONS'] = $arSections;
foreach ($arResult['SECTIONS'] as $key => $arSection) {
	if(empty($arSection['ITEMS'])) {
		unset($arResult['SECTIONS'][$key]);
	}
}
?>