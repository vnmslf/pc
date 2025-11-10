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
<div class="services__listing">
	<div class="container">
		<div class="list__blocks">
<?foreach ($arResult['SECTIONS'] as $arSection) {?>
			<div class="block">
				<h2><?=$arSection['NAME']?></h2>
				<div class="list">
	<?foreach ($arSection['ITEMS'] as $arItem) {?>
					<a class="item" href="<?=$arItem['DETAIL_PAGE_URL']?>">
						<span class="item__left">
							<picture class="detail">
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
						</span>
						<span class="item__right">
							<span class="info">
								<h3><?=$arItem['NAME']?></h3>
								<span class="announce"><?=$arItem['PREVIEW_TEXT']?></span>
								<span class="link">Далее</span>
							</span>
							<span class="day">
								<span class="day__header"></span>
								<span class="day__body"><?=$arItem['day']['number']?></span>
								<span class="day__footer">
									<?=$arItem['day']['month']?>
									<span class="day__year"><?=$arItem['day']['year']?>г.</span>
								</span>
							</span>
						</span>
					</a>
	<?}?>
				</div>
			</div>
<?}?>
		</div>
	</div>
</div>