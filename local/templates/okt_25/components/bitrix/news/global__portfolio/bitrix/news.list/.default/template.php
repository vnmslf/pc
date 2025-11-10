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
				<div class="list">
	<?foreach ($arSection['ITEMS'] as $arItem) {?>
					<a class="item" href="<?=$arItem['DETAIL_PAGE_URL']?>">
						<h3><?=$arItem['NAME']?></h3>
						<span class="info">
		<?foreach ($arItem['GALLERY'] as $key => $picture) {?>
							<picture>
			<?foreach ($picture as $keyMedia => $valueMedia) {
				if($keyMedia !== 'default') {
					$explode = explode('-', $keyMedia);
					$start = $explode[0];
					$end = $explode[1];?>
								<source srcset="<?=$picture[$keyMedia]['src']?>" media="(min-width: <?=$start?>px)<?if($end !== 'max') {?> and (max-width: <?=$end?>px)<?}?>" type="image/webp" />
				<?}
			}?>
								<img srcset="<?=$picture['default']?>" alt="<?=$arItem['NAME']?>, основное фото анонса" />
							</picture>
		<?}?>
							<span class="link">Далее</a>
						</span>
					</a>
	<?}?>
				</div>
			</div>
<?}?>
		</div>
	</div>
</div>