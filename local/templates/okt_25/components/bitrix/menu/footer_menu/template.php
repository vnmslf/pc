<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
if (!empty($arResult)) {?>
<div class="footer__menu">
	<div class="footer__menu-left">
		<h5>Меню</h5>
		<ul>
	<?$previousLevel = 0;
	foreach($arResult as $arItem) {
		if ($previousLevel && $arItem['DEPTH_LEVEL'] < $previousLevel) {?>
			<?=str_repeat('</ul></li>', ($previousLevel - $arItem['DEPTH_LEVEL']));?>
		<?}
		if ($arItem['IS_PARENT']) {
			if ($arItem['DEPTH_LEVEL'] == 1) {?>
			<li<?if($arItem['SELECTED']) {?> class="active"<?}?>>
				<a href='<?=$arItem['LINK']?>'><?=$arItem['TEXT']?></a>
			<ul class="submenu">
			<?} else {?>
			<li<?if($arItem['SELECTED']) {?> class="active"<?}?>>
				<a href='<?=$arItem['LINK']?>'><?=$arItem['TEXT']?></a>
				<ul class="submenu">
			<?}
		} else {
			if ($arItem['PERMISSION'] > 'D') {
				if ($arItem['DEPTH_LEVEL'] == 1) {?>
					<li>
						<a href="<?=$arItem['LINK']?>"<?if($arItem['SELECTED']) {?> class="active"<?}?>><?=$arItem['TEXT']?></a>
					</li>
				<?} else {?>
					<li>
						<a href="<?=$arItem['LINK']?>"<?if($arItem['SELECTED']) {?> class="active"<?}?>><?=$arItem['TEXT']?></a>
					</li>
				<?}
			} else {
				if ($arItem['DEPTH_LEVEL'] == 1) {?>
					<li>
						<a href="" class="<?if ($arItem['SELECTED']) {?>root-item-selected<?} else {?>root-item<?}?>" title="<?=GetMessage('MENU_ITEM_ACCESS_DENIED')?>"><?=$arItem['TEXT']?></a>
					</li>
				<?} else {?>
					<li>
						<a href="" class="denied" title="<?=GetMessage('MENU_ITEM_ACCESS_DENIED')?>"><?=$arItem['TEXT']?></a>
					</li>
				<?}
			}
		}
		$previousLevel = $arItem['DEPTH_LEVEL'];
	}
	if ($previousLevel > 1) {?>
		<?=str_repeat('</ul></li>', ($previousLevel - 1) );
	}?>
		</ul>
	</div>
	<div class="footer__menu-right">
		<img src="<?=SITE_TEMPLATE_PATH?>/images/logo__white.svg" alt="Логотип Ветор тепла в подвале" />
	</div>
</div>
<?}?>