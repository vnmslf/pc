<?if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();
$date = strtolower(FormatDate("d F Y", MakeTimeStamp($arResult['ACTIVE_FROM'])));
$exp = explode(' ', $date);
$arResult['day'] = [
	'number' => $exp[0],
	'month' => $exp[1],
	'year' => $exp[2]
];
if($arResult['DETAIL_TEXT']) {
	$arResult['READ_TIME'] = calculateReadingTime(strip_tags($arResult['DETAIL_TEXT']));
}
$height_input = [
	'mobile'     => 150,
	'md-mobile'  => 150,
	'lg-mobile'  => 150,
	'xl-mobile'  => 170,
	'tablet'     => 170,
	'md-tablet'  => 190,
	'lg-tablet'  => 190,
	'xl-tablet'  => 220,
	'desktop'    => 220,
	'md-desktop' => 250,
	'lg-desktop' => 250,
	'xl-desktop' => 300,
];
foreach ($arResult['PROPERTIES']['GALLERY']['VALUE'] as $key => $id) {
	$picture = CFile::GetFileArray($id);
	$picture['WIDTH'] = 150;
	$arResult['GALLERY'][$id] = make_picture_min($picture, $height_input);
}
?>