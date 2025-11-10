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
	$arSections[$arItem['IBLOCK_SECTION_ID']]['ITEMS'][] = $arItem;
}
$arResult['SECTIONS'] = $arSections;
?>