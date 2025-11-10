<?if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();
$date = strtolower(FormatDate("d F Y", MakeTimeStamp($arResult['ACTIVE_FROM'])));
$exp = explode(' ', $date);
$arResult['day'] = [
	'number' => $exp[0],
	'month' => $exp[1],
	'year' => $exp[2]
];
$arResult['READ_TIME'] = calculateReadingTime(strip_tags($arResult['DETAIL_TEXT']));
?>