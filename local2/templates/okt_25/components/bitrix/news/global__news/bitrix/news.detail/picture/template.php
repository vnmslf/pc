<?if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<picture class="detail">
<?foreach ($arResult['PP'] as $keyMedia => $valueMedia) {
	if($keyMedia !== 'default') {
		$explode = explode('-', $keyMedia);
		$start = $explode[0];
		$end = $explode[1];?>
	<source srcset="<?=$arResult['PP'][$keyMedia]['src']?>" media="(min-width: <?=$start?>px)<?if($end !== 'max') {?> and (max-width: <?=$end?>px)<?}?>" type="image/webp" />
	<?}
}?>
	<img srcset="<?=$arResult['PP']['default']?>" alt="<?=$arResult['NAME']?>, основное фото анонса" />
</picture>