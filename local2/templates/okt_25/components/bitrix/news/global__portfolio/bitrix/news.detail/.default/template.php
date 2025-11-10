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
use Bitrix\Main\Page\Asset;
?>
<section class="article">
	<div class="container">
		<div class="article__header">
			<div class="article__about">
				<span class="day">
					<span class="day__header"></span>
					<span class="day__body"><?=$arResult['day']['number']?></span>
					<span class="day__footer">
						<?=$arResult['day']['month']?>
						<span class="day__year"><?=$arResult['day']['year']?></span>
					</span>
				</span>
<?if($arResult['DETAIL_TEXT']) {?>
				<span class="read">
					<span class="read__header"></span>
					<span class="read__body"><?=$arResult['READ_TIME']?>-<?=$arResult['READ_TIME'] + 2?> мин</span>
					<span class="read__footer">время чтения</span>
				</span>
<?}?>
				<span class="counter">
					<span class="counter__header"></span>
					<span class="counter__body"><?=$arResult['SHOW_COUNTER']?></span>
					<span class="counter__footer">
						<?=inclination($arResult['SHOW_COUNTER'], array('раз', 'раза', 'раз'))?>
						<span class="counter__read">просмотрено</span>
					</span>
				</span>
			</div>
			<h1><?=$arResult['NAME']?></h1>
		</div>
		<div class="article__body">
			<div class="article__gallery">
<?foreach ($arResult['GALLERY'] as $key => $picture) {
	$max = CFile::GetFileArray($key);?>
				<picture class="gallery__item" data-max="<?=$max['SRC']?>">
	<?foreach ($picture as $keyMedia => $valueMedia) {
		if($keyMedia !== 'default') {
			$explode = explode('-', $keyMedia);
			$start = $explode[0];
			$end = $explode[1];?>
					<source srcset="<?=$picture[$keyMedia]['src']?>" media="(min-width: <?=$start?>px)<?if($end !== 'max') {?> and (max-width: <?=$end?>px)<?}?>" type="image/webp" />
		<?}
	}?>
					<img srcset="<?=$picture['default']?>" alt="<?=$arResult['NAME']?>, основное фото анонса" />
				</picture>
<?}?>
			</div>
			<?=$arResult['DETAIL_TEXT'];?>
		</div>
	</div>
</section>