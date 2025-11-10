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
<div class="listing">
	<div class="container">
		<div class="list__blocks">
<?foreach ($arResult['SECTIONS'] as $arSection) {?>
			<div class="block">
				<h2><?=$arSection['NAME']?></h2>
    <?if(!empty($arSection['DESCRIPTION'])) {?>
                <?=$arSection['DESCRIPTION']?>
    <?}?>
				<div class="list">
	<?foreach ($arSection['ITEMS'] as $arItem) {
		if(!empty($arItem['PROPERTIES']['PROPS_ME']['VALUE']) || !empty($arItem['DETAIL_TEXT'])) {
			$tag = 'a';
		} else {
			$tag = 'div';
		}?>
					<<?=$tag?> class="item"<?if($tag === 'a') {?> href="<?=$arItem['DETAIL_PAGE_URL']?>"<?} else {?> data-order="header__cta-order"<?}?>>
						<h3><?=$arItem['NAME']?></h3>
						<span class="info">
		<?if(!empty($arItem['PP'])) {?>
							<picture>
			<?foreach ($arItem['PP'] as $keyMedia => $valueMedia) {
				if($keyMedia !== 'default') {
					$explode = explode('-', $keyMedia);
					$start = $explode[0];
					$end = $explode[1];?>
								<source srcset="<?=$arItem['PP'][$keyMedia]['src']?>" media="(min-width: <?=$start?>px)<?if($end !== 'max') {?> and (max-width: <?=$end?>px)<?}?>" type="image/webp" />
				<?}
			}?>
								<img srcset="<?=$arItem['PP']['default']?>" alt="<?=$arItem['NAME']?>, основное фото анонса" />
							</picture>
		<?} else {?>
							<span class="icon__nophoto">
								<i class="fas fa-ban"></i>
								<i class="fas fa-camera"></i>
							</span>
		<?}?>
							<span class="link">Подробнее</a>
						</span>
					</<?=$tag?>>
	<?}?>
				</div>
			</div>
<?}?>
		</div>
	</div>
</div>