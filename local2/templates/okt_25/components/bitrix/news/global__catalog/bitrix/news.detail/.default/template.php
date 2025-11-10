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
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/libraries/owl.carousel/owl.carousel.min.js');
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/libraries/owl.carousel/assets/owl.carousel.min.css');
?>
<section class="product">
	<div class="container">
		<h1><?=$arResult['NAME']?></h1>
	</div>
	<div class="container">
<?if(!empty($arResult['PP'])) {?>
		<div class="product__left">
			<picture>
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
		</div>
<?}?>
		<div class="product__right">
<?if($arResult['PROPS_ME'] || $arResult['PROPS_VR']) {?>
			<h2>Варианты товара</h2>
<?}?>
<?if(!$arResult['PROPS_ME'] && !$arResult['PROPS_VR']) {?>
            <h2>Описание</h2>
            <?=$arResult['DETAIL_TEXT']?>
<?}?>
<?if($arResult['DEFAULT_ARTICLE']) {?>
			<div class="prop__block article" data-input="article">
				<div class="props__line">Артикул: <span class="active"><?=$arResult['DEFAULT_ARTICLE']?></span></div>
			</div>
<?}?>
<?// свойства для монтажных элементов
if($arResult['PROPS_ME']) {
	$props = $arResult['PROPS_ME'];
	if($props['DIAMETER']) {?>
			<div class="prop__block diameter" data-index="3" data-input="diameter">
				<div class="prop__line">Диаметр, мм:
					<div class="prop__container">
		<?$i = 0;
		foreach ($props['DIAMETER'] as $key => $value) {?>
						<span class="prop__button<?=($i == 0 ? ' active' : '')?>" data-value="<?=$value?>" data-index="<?=$i?>"><?=$value?></span>
			<?$i++;
		}?>
					</div>
				</div>
			</div>
	<?}
	if($props['WEIGHT']) {?>
			<div class="prop__block weight" data-index="1" data-input="weight">
				<div class="prop__line">Толщина стали, мм:
					<div class="prop__container">
		<?$i = 0;
		foreach ($props['WEIGHT'] as $key => $value) {?>
						<span class="prop__button<?=($i == 0 ? ' active' : '')?>" data-value="<?=((str_replace(',', '.', $value)) * 10)?>" data-index="<?=$i?>" data-output="mass__<?=$i?>"><?=$value?></span>
			<?$i++;
		}?>
					</div>
				</div>
			</div>
	<?}
	if($props['MASS_ONE']) {?>
			<div class="prop__block technical mass__one" data-input="mass__0">
		<?$i = 0;
		foreach ($props['MASS_ONE'] as $key => $value) {?>
				<span<?=($i == 0 ? ' class="active"' : '')?> data-value="<?=$value?>" data-index="<?=$i?>"><?=$value?></span>
			<?$i++;
		}?>
			</div>
	<?}
	if($props['MASS_TWO']) {?>
			<div class="prop__block technical mass__two" data-input="mass__1">
		<?$i = 0;
		foreach ($props['MASS_TWO'] as $key => $value) {?>
				<span<?=($i == 0 ? ' class="active"' : '')?> data-value="<?=$value?>" data-index="<?=$i?>"><?=$value?></span>
			<?$i++;
		}?>
			</div>
	<?}
}?>
<?// свойства для вентялиционных решеток
if($arResult['PROPS_VR']) {
	$props = $arResult['PROPS_VR'];
	if($props['COLOR']) {?>
			<div class="prop__block width__unset color" data-input="color">
				<div class="prop__line">Цвет:
					<div class="prop__container">
		<?$i = 0;
		foreach ($props['COLOR'] as $key => $value) {?>
			<?if($value['LINK'] == $props['NOW_URL']) {
				$active_color = $i;?>
						<span class="prop__button active" data-value="<?=$value['NAME']?>" data-index="<?=$i?>"><?=$value['NAME']?></span>
			<?} else {?>
						<a href="<?=$value['LINK']?>" class="prop__button" data-value="<?=$value['NAME']?>" data-index="<?=$i?>"><?=$value['NAME']?></a>
			<?}
			$i++;
		}?>
					</div>
				</div>
			</div>
	<?}
	if($props['WIDTH']) {?>
			<div class="prop__block width__unset width" data-input="width">
				<div class="prop__line">Длинная сторона, см:
					<div class="prop__container">
		<?$i = 0;
		foreach ($props['WIDTH'] as $key => $value) {?>
						<span class="prop__button<?=($i == 0 ? ' active' : '')?>" data-value="<?=$value?>" data-index="<?=$i?>"><?=$value?></span>
			<?$i++;
		}?>
					</div>
				</div>
			</div>
	<?}
	if($props['WIDTH_TWO']) {?>
			<div class="prop__block width__unset width_two" data-input="width_two">
				<div class="prop__line">Короткая сторона, см:
					<div class="prop__container">
		<?$i = 0;
		foreach ($props['WIDTH_TWO'] as $key => $value) {?>
						<span class="prop__button<?=($i == 0 ? ' active' : '')?>" data-value="<?=$value?>" data-index="<?=$i?>"><?=$value?></span>
			<?$i++;
		}?>
					</div>
				</div>
			</div>
	<?}
	if($props['HEIGHT']) {?>
			<div class="prop__block width__unset height" data-input="height">
				<div class="prop__line">Высота, см:
					<div class="prop__container">
		<?$i = 0;
		foreach ($props['HEIGHT'] as $key => $value) {?>
						<span class="prop__button<?=($i == 0 ? ' active' : '')?>" data-value="<?=$value?>" data-index="<?=$i?>"><?=$value?></span>
			<?$i++;
		}?>
					</div>
				</div>
			</div>
	<?}
	if($props['DEPTH']) {?>
			<div class="prop__block width__unset depth" data-input="depth">
				<div class="prop__line">Глубина, см:
					<div class="prop__container">
		<?$i = 0;
		foreach ($props['DEPTH'] as $key => $value) {?>
						<span class="prop__button<?=($i == 0 ? ' active' : '')?>" data-value="<?=$value?>" data-index="<?=$i?>"><?=$value?></span>
			<?$i++;
		}?>
					</div>
				</div>
			</div>
	<?}
}?>
		</div>
<?if($arResult['PROPS_ME'] || $arResult['PROPS_VR']) {?>
		<div class="product__technical">
			<h2>Технические характеристики</h2>
			<div class="product__table">
    <?if($arResult['DEFAULT_ARTICLE']) {?>
				<div class="product__row">
					<div class="product__col product__name">Артикул:</div>
					<div class="product__col product__value" data-output="article"><?=$arResult['DEFAULT_ARTICLE']?></div>
				</div>
    <?}?>
    <?if($arResult['PROPS_ME']['DIAMETER']) {?>
				<div class="product__row">
					<div class="product__col product__name">Диаметр, мм:</div>
					<div class="product__col product__value" data-output="diameter"><?=$arResult['PROPS_ME']['DIAMETER'][0]?></div>
				</div>
    <?}?>
    <?if($arResult['PROPS_ME']['WEIGHT']) {?>
				<div class="product__row">
					<div class="product__col product__name">Толщина стали, мм:</div>
					<div class="product__col product__value" data-output="weight"><?=$arResult['PROPS_ME']['WEIGHT'][0]?></div>
				</div>
    <?}?>
    <?if($arResult['PROPS_ME']['MASS_ONE']) {?>
				<div class="product__row">
					<div class="product__col product__name">Масса, кг:</div>
					<div class="product__col product__value" data-output="mass"><?=$arResult['PROPS_ME']['MASS_ONE'][0]?></div>
				</div>
    <?}?>
    <?if($arResult['PROPS_VR']['COLOR']) {?>
				<div class="product__row">
					<div class="product__col product__name">Цвет:</div>
					<div class="product__col product__value" data-output="color"><?=$arResult['PROPS_VR']['COLOR'][$active_color]['NAME']?></div>
				</div>
    <?}?>
    <?if($arResult['PROPS_VR']['WIDTH']) {?>
				<div class="product__row">
					<div class="product__col product__name">Длинная сторона, см:</div>
					<div class="product__col product__value" data-output="width"><?=$arResult['PROPS_VR']['WIDTH'][0]?></div>
				</div>
    <?}?>
    <?if($arResult['PROPS_VR']['WIDTH_TWO']) {?>
				<div class="product__row">
					<div class="product__col product__name">Короткая сторона, см:</div>
					<div class="product__col product__value" data-output="width_two"><?=$arResult['PROPS_VR']['WIDTH_TWO'][0]?></div>
				</div>
    <?}?>
    <?if($arResult['PROPS_VR']['HEIGHT']) {?>
				<div class="product__row">
					<div class="product__col product__name">Высота, см:</div>
					<div class="product__col product__value" data-output="height"><?=$arResult['PROPS_VR']['HEIGHT'][0]?></div>
				</div>
    <?}?>
    <?if($arResult['PROPS_VR']['DEPTH']) {?>
				<div class="product__row">
					<div class="product__col product__name">Глубина, см:</div>
					<div class="product__col product__value" data-output="depth"><?=$arResult['PROPS_VR']['DEPTH'][0]?></div>
				</div>
    <?}?>
    <?if($arResult['PROPS_VR']['WEIGHT']) {?>
				<div class="product__row">
					<div class="product__col product__name">Вес, кг:</div>
					<div class="product__col product__value" data-output="none"><?=$arResult['PROPS_VR']['WEIGHT'][0]?> &ndash; <?=end($arResult['PROPS_VR']['WEIGHT'])?></div>
				</div>
    <?}?>
			</div>
		</div>
<?}?>
	</div>
<?if($arResult['GALLERY']) {?>
	<div class="container">
		<div class="catalog__gallery owl-carousel">
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
	</div>
<?}?>
</section>