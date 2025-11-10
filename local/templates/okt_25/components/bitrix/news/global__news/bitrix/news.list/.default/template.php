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
					<div class="item">
						<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
							<span class="day">
								<span class="day__header"></span>
								<span class="day__body"><?=$arItem['day']['number']?></span>
								<span class="day__footer">
									<?=$arItem['day']['month']?>
									<span class="day__year"><?=$arItem['day']['year']?>г.</span>
								</span>
							</span>
							<?=$arItem['NAME']?>
						</a>
						<div class="info">
							<div class="announce"><?=$arItem['PREVIEW_TEXT']?></div>
							<a href="<?=$arItem['DETAIL_PAGE_URL']?>">Далее</a>
						</div>
					</div>
	<?}?>
				</div>
			</div>
<?}?>
		</div>
	</div>
</div>