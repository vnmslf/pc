<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
<section class="hero">
	<div class="container">
		<div class="hero__left">
			<div class="hero__precapt"><?=$arResult['PROPERTIES']['CAPT_2']['~VALUE']?></div>
			<h1><?=$arResult['PROPERTIES']['CAPT_1']['~VALUE']?></h1>
			<?=$arResult['PREVIEW_TEXT']?>
<?/*			<div class="link">
				<a href="#">Обсудить проект</a>
			</div>*/?>
			<div class="hero__props">
<?foreach ($arResult['PROPS'] as $value) {?>
				<div class="prop">
					<div class="prop__number">
						<span><?=$value[0]?></span>%
					</div>
					<h3><?=$value[1]?></h3>
					<span><?=$value[2]?></span>
				</div>
<?}?>
			</div>
		</div>
		<div class="hero__right">
			<picture>
<?foreach ($arResult['PP'] as $keyMedia => $valueMedia) {
	if($keyMedia !== 'default') {
		$explode = explode('-', $keyMedia);
		$start = $explode[0];
		$end = $explode[1];?>
				<source srcset="<?=$arResult['PP'][$keyMedia]['src']?>" media="(min-width: <?=$start?>px)<?if($end !== 'max') {?> and (max-width: <?=$end?>px)<?}?>" type="image/webp" />
	<?}
}?>
				<img srcset="<?=$arResult['PP']['default']?>" alt="<?=$arResult['NAME']?>" />
			</picture>
		</div>
	</div>
</section>