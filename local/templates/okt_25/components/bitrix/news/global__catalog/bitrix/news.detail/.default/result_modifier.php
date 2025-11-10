<?if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
if($arResult['DETAIL_TEXT']) {
	$arResult['READ_TIME'] = calculateReadingTime(strip_tags($arResult['DETAIL_TEXT']));
}
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
	$arResult['PP'] = make_picture_min($arResult['PREVIEW_PICTURE'], $height_input);
}
if($arResult['PROPERTIES']['PROPS_ME']['VALUE']) {
	$hlblock__name = $arResult['PROPERTIES']['PROPS_ME']['USER_TYPE_SETTINGS']['TABLE_NAME'];
	$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter' => array('=TABLE_NAME' => $hlblock__name)))->fetch();
	$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();
	$res = $entity_data_class::getList(array(
		'select' => array('ID', 'UF_ARTICLE', 'UF_DIAMETER', 'UF_WEIGHT', 'UF_MASS_ONE', 'UF_MASS_TWO'),
		'filter' => array('=UF_XML_ID' => $arResult['ID'])
	));
	if ($item = $res->Fetch()) {
		$props_me['ARTICLE'] = $item['UF_ARTICLE'];
		$props_me['DIAMETER'] = $item['UF_DIAMETER'];
		$props_me['WEIGHT'] = $item['UF_WEIGHT'];
		$props_me['MASS_ONE'] = $item['UF_MASS_ONE'];
		$props_me['MASS_TWO'] = $item['UF_MASS_TWO'];
	}
	if($props_me) {
		if($props['ARTICLE']) {
			$default__article = str_replace('{D}', $props_me['DIAMETER'][0], $props_me['ARTICLE']);
			$default__article = str_replace('{W}', ((str_replace(',', '.', $props_me['WEIGHT'][0])) * 10), $default__article);
			$arResult['DEFAULT_ARTICLE'] = $default__article;
		}
		$arResult['PROPS_ME'] = $props_me;
	}
}
if($arResult['PROPERTIES']['PROPS_VR']['VALUE']) {
	$hlblock__name = $arResult['PROPERTIES']['PROPS_VR']['USER_TYPE_SETTINGS']['TABLE_NAME'];
	$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter' => array('=TABLE_NAME' => $hlblock__name)))->fetch();
	$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();
	$res = $entity_data_class::getList(array(
		'select' => array('ID', 'UF_COLOR', 'UF_WIDTH', 'UF_WIDTH_TWO', 'UF_HEIGHT', 'UF_DEPTH', 'UF_WEIGHT', 'UF_ELEMENTS'),
	));
	if ($item = $res->Fetch()) {
		$props_vr['COLOR'] = $item['UF_COLOR'];
		$props_vr['WIDTH'] = array_unique($item['UF_WIDTH']);
		$props_vr['WIDTH_TWO'] = array_unique($item['UF_WIDTH_TWO']);
		$props_vr['HEIGHT'] = array_unique($item['UF_HEIGHT']);
		$props_vr['DEPTH'] = array_unique($item['UF_DEPTH']);
		$props_vr['WEIGHT'] = $item['UF_WEIGHT'];
		$props_vr['ELEMENTS'] = $item['UF_ELEMENTS'];
	}
	if($props_vr) {
		/*if($props['ARTICLE']) {
			$default__article = str_replace('{D}', $props_vr['DIAMETER'][0], $props_vr['ARTICLE']);
			$default__article = str_replace('{W}', ((str_replace(',', '.', $props_vr['WEIGHT'][0])) * 10), $default__article);
			$arResult['DEFAULT_ARTICLE'] = $default__article;
		}*/
		$iblock_code = \Dao\App::ib('catalog')->code();
		$now_url = $_SERVER['REQUEST_URI'];
		$now_url = explode('?', $now_url);
		$now_url = $now_url[0];
		foreach ($props_vr['ELEMENTS'] as $key => $value) {
			$element = \Bitrix\Iblock\Elements\ElementCatalogTable::getByPrimary($value, [
				'select' => ['ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'CODE', 'NAME', 'COLOR_' => 'COLOR', 'DETAIL_PAGE_URL' => 'IBLOCK.DETAIL_PAGE_URL'],
			])->fetch();
			$colors[] = [
				'NAME' => $element['COLOR_VALUE'],
				'LINK' => '/'.$iblock_code.CIBlock::ReplaceDetailUrl($element['DETAIL_PAGE_URL'], $element, false, 'E'),
			];
		}
		$props_vr['COLOR'] = $colors;
		$props_vr['NOW_URL'] = $now_url;
		$arResult['PROPS_VR'] = $props_vr;
	}
}
$height_input_min = [
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
	$arResult['GALLERY'][$id] = make_picture_min($picture, $height_input_min);
}
?>