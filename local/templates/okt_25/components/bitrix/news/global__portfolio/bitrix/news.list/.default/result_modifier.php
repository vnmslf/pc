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
		'mobile'     => 110,
		'md-mobile'  => 110,
		'lg-mobile'  => 110,
		'xl-mobile'  => 110,
		'tablet'     => 110,
		'md-tablet'  => 110,
		'lg-tablet'  => 110,
		'xl-tablet'  => 110,
		'desktop'    => 110,
		'md-desktop' => 110,
		'lg-desktop' => 110,
		'xl-desktop' => 110,
	];
	$arItem['PREVIEW_PICTURE']['WIDTH'] = 150;
	if($arItem['PREVIEW_PICTURE'] !== false) {
		$arItem['PP'] = make_picture($arItem['PREVIEW_PICTURE'], $height_input, BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
	}
	$i = 0;
	foreach ($arItem['PROPERTIES']['GALLERY']['VALUE'] as $key => $id) {
		if($i < 5) {
			$picture = CFile::GetFileArray($id);
			$picture['WIDTH'] = 150;
			$arItem['GALLERY'][] = make_picture_min($picture, $height_input);
		} else {
			break;
		}
		$i++;
	}
	$arSections[$arItem['IBLOCK_SECTION_ID']]['ITEMS'][] = $arItem;
}
$arResult['SECTIONS'] = $arSections;
?>