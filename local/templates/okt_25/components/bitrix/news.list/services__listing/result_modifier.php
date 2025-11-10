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
	$date = strtolower(FormatDate("d F Y", MakeTimeStamp($arItem['ACTIVE_FROM'])));
	$exp = explode(' ', $date);
	$arItem['day'] = [
		'number' => $exp[0],
		'month' => $exp[1],
		'year' => $exp[2]
	];
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
	$arItem['PREVIEW_PICTURE']['WIDTH'] = 350;
	$arItem['PP'] = make_picture($arItem['PREVIEW_PICTURE'], $height_input, BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
	$arSections[$arItem['IBLOCK_SECTION_ID']]['ITEMS'][] = $arItem;
}
$arResult['SECTIONS'] = $arSections;
?>