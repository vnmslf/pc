<?
include_once ($_SERVER['DOCUMENT_ROOT'].'/local/vendor/autoload.php');
if (isset($_GET['noinit']) && !empty($_GET['noinit']))
{
	$strNoInit = strval($_GET['noinit']);
	if ($strNoInit == 'N')
	{
		if (isset($_SESSION['NO_INIT']))
			unset($_SESSION['NO_INIT']);
	}
	elseif ($strNoInit == 'Y')
	{
		$_SESSION['NO_INIT'] = 'Y';
	}
}
if (!(isset($_SESSION['NO_INIT']) && $_SESSION['NO_INIT'] == 'Y')) {
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/autoload.php'))
		require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/autoload.php');
}
AddEventHandler('main', 'OnEndBufferContent', 'deleteKernelJs');
function pre($data, $flag = true) {
	if($flag) {
		$bt = debug_backtrace();
		$bt = $bt[0];
		$dRoot = $_SERVER['DOCUMENT_ROOT'];
		$dRoot = str_replace('/','\\', $dRoot);
		$bt['file'] = str_replace($dRoot,'', $bt['file']);
		$dRoot = str_replace('\\','/', $dRoot);
		$bt['file'] = str_replace($dRoot,'', $bt['file']);?>
		<div style='font-size:12px; color:#000; background:#fff; border:1px dashed #000;'>
			<div style='padding:3px 5px; background:#99CCFF; font-weight:bold;'>File: <?=$bt['file']?> [<?=$bt['line']?>]</div>
			<pre style='padding:10px;'><?print_r($data)?></pre>
		</div>
	<?} else {
		echo '<pre>', print_r($data), '</pre>';
	}
}
function deleteKernelJs(&$content) {
	global $USER, $APPLICATION;
	if((is_object($USER) && $USER->IsAuthorized()) || strpos($APPLICATION->GetCurDir(), "/bitrix/")!==false) return;
	if($APPLICATION->GetProperty("save_kernel") == "Y") return;
	$arPatternsToRemove = Array(
		'/<script.+?src=".+?kernel_main\/kernel_main\.js\?\d+"><\/script\>/',
//		'/<script.+?src=".+?bitrix\/js\/main\/core\/core[^"]+"><\/script\>/',
		'/<script.+?>BX\.(setJSList)\(\[.+?\]\).*?<\/script>/',
		'/<script.+?>if\(\!window\.BX\)window\.BX.+?<\/script>/',
		'/<script[^>]+?>\(window\.BX\|\|top\.BX\)\.message[^<]+<\/script>/',
		'/<script.+?src=".+?bitrix\/js\/main\/loadext\/loadext[^"]+"><\/script\>/',
		'/<script.+?src=".+?bitrix\/js\/main\/loadext\/extension[^"]+"><\/script\>/',
	);

	$content = preg_replace($arPatternsToRemove, "", $content);
	$content = preg_replace("/\n{2,}/", "\n\n", $content);
}
AddEventHandler('iblock', 'OnBeforeIBlockElementAdd', 'OnBeforeIBlockElementHandler');
AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', 'OnBeforeIBlockElementHandler');
AddEventHandler('iblock', 'OnBeforeIBlockSectionAdd', 'OnBeforeIBlockElementHandler');
AddEventHandler('iblock', 'OnBeforeIBlockSectionUpdate', 'OnBeforeIBlockElementHandler');
function OnBeforeIBlockElementHandler(&$arFields) {
	$t = new \Akh\Typograf\Typograf();
	$simpleRule = new class extends \Akh\Typograf\Rule\AbstractRule {
		public $name = 'Замена "при" и "это"';
		protected $sort = 1000;
		public function handler(string $text): string {
			$text = str_replace("при ", "при&nbsp;", $text);
			$text = str_replace("При ", "При&nbsp;", $text);
			$text = str_replace("это ", "это&nbsp;", $text);
			$text = str_replace("Это ", "Это&nbsp;", $text);
			return $text;
		}
	};
	$t->addRule($simpleRule);
	if(!empty($arFields['PREVIEW_TEXT'])) {
		$typoText = $t->apply($arFields['PREVIEW_TEXT']);
		$arFields['PREVIEW_TEXT'] = $typoText;
	} elseif(!empty($arFields['DESCRIPTION'])) {
		$typoText = $t->apply($arFields['DESCRIPTION']);
		$arFields['DESCRIPTION'] = $typoText;
	}
	if(!empty($arFields['DETAIL_TEXT'])) {
		$typoText = $t->apply($arFields['DETAIL_TEXT']);
		$arFields['DETAIL_TEXT'] = $typoText;
	}
}

\Bitrix\Main\EventManager::getInstance()->addEventHandler(
	'iblock',
	'OnAfterIBlockElementUpdate',
	'createWebp'
);
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
	'iblock',
	'OnAfterIBlockElementAdd',
	'createWebp'
);
function createWebp(&$arFields) {
	$oldExtArr = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG');
	// preview picture prep
	$defaultImgUrl = \CFile::GetPath($arFields['PREVIEW_PICTURE_ID']);
	$filename_from_url = parse_url($defaultImgUrl);
	$info = pathinfo($filename_from_url['path']);
	$oldFile = CFile::MakeFileArray($arFields['PREVIEW_PICTURE']['old_file']);
	if($oldFile['size'] / 1024 > 300) {
		$original_path = $oldFile['tmp_name'];
		$file_size = $oldFile['size'];
		if($file_size > 300000) {
			$compression_quality = 80;
			while($file_size > 300000) {
				$input = \Tools\ImgHelper::webpConvert3($original_path, $compression_quality);
				list($width, $height) = getimagesize($input);
				if($width > 2545 || $height > 2545) {
					if($width >= $height) {
						$nw = 2545;
						$nh = $nw * $height / $width;
					} else {
						$nh = 2545;
						$nw = $nh * $width / $height;
					}
					$arNewFile = CFile::ResizeImageGet($arFields['PREVIEW_PICTURE']['old_file'], array('width' => $nw, 'height' => $nh), BX_RESIZE_IMAGE_EXACT, true);
					$value = \CFile::MakeFileArray($arNewFile['src']);
				} else {
					$value = \CFile::MakeFileArray($input);
				}
				$file_size = $value['size'];
				if($compression_quality < 60) {
					break;
				} else {
					$compression_quality = $compression_quality - 10;
				}
			}
			$arFields['PREVIEW_PICTURE'] = $value;
			$needFieldsUpdate = true;
		}
	} else if (in_array($info["extension"], $oldExtArr)) {
		$original_path = $_SERVER['DOCUMENT_ROOT'].$defaultImgUrl;
		$input = \Tools\ImgHelper::webpConvert2($original_path);
		$arFields['PREVIEW_PICTURE'] = \CFile::MakeFileArray($input);
		$needFieldsUpdate = true;
	}
	// detail picture prep
	$defaultImgUrl = \CFile::GetPath($arFields['DETAIL_PICTURE_ID']);
	$filename_from_url = parse_url($defaultImgUrl);
	$info = pathinfo($filename_from_url['path']);
	if (in_array($info["extension"], $oldExtArr)) {
		$original_path = $_SERVER['DOCUMENT_ROOT'].$defaultImgUrl;
		$input = \Tools\ImgHelper::webpConvert2($original_path);
		$arFields['DETAIL_PICTURE'] = \CFile::MakeFileArray($input);
		$needFieldsUpdate = true;
	}
	if ($needFieldsUpdate) {
		// fields updates
		$el = new \CIBlockElement;
		$id = $arFields['ID'];
		$el->Update($id, $arFields);
	}
	// all picture properties
	$newPicturesProps = [];
	$res = \CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], array("sort" => "asc"), Array());
	while ($ob = $res->GetNext()) {
		if ($ob['PROPERTY_TYPE'] == 'F' && $ob['VALUE']) {
			$defaultImgUrl = \CFile::GetPath($ob['VALUE']);
			$defaultFileArray = \CFile::MakeFileArray($defaultImgUrl);
			$filename_from_url = parse_url($defaultImgUrl);
			$info = pathinfo($filename_from_url['path']);
			if ($info['extension'] == 'webp') {
				// если уже webp - смотрим на размеры и делаем меньше 100кб
				$file_size = $defaultFileArray['size'];
				if($file_size > 300000) {
					$compression_quality = 80;
					while($file_size > 300000) {
						$original_path = $_SERVER['DOCUMENT_ROOT'].\CFile::GetPath($ob['VALUE']);
						$input = \Tools\ImgHelper::webpConvert3($original_path, $compression_quality);
						list($width, $height) = getimagesize($input);
						if($width > 2545 || $height > 2545) {
							if($width >= $height) {
								$nw = 2545;
								$nh = $nw * $height / $width;
							} else {
								$nh = 2545;
								$nw = $nh * $width / $height;
							}
							$arNewFile = CFile::ResizeImageGet($ob['VALUE'], array('width' => $nw, 'height' => $nh), BX_RESIZE_IMAGE_EXACT, true);
							$value = \CFile::MakeFileArray($arNewFile['src']);
						} else {
							$value = \CFile::MakeFileArray($input);
						}
						$file_size = $value['size'];
						if($compression_quality < 60) {
							break;
						} else {
							$compression_quality = $compression_quality - 10;
						}
						//pre($compression_quality);
					}
					$newPicturesProps[$ob['ID']][] = array('VALUE' => $value, 'DESCRIPTION' => $value['NAME']);
				} else {
					$newPicturesProps[$ob['ID']][] = array('VALUE' => \CFile::MakeFileArray($ob['VALUE']), 'DESCRIPTION' => $ob['DESCRIPTION']);
				}
			} else if (in_array($info["extension"], $oldExtArr)) {
				// если нет - конвертируем
				$original_path = $_SERVER['DOCUMENT_ROOT'].\CFile::GetPath($ob['VALUE']);
				$input = \Tools\ImgHelper::webpConvert2($original_path);
				$value = \CFile::MakeFileArray($input);
				$newPicturesProps[$ob['ID']][] = array('VALUE' => $value, 'DESCRIPTION' => $value['name']);
			}
		}
	}
	if (count($newPicturesProps) > 0) {
		\CIBlockElement::SetPropertyValuesEx($arFields['ID'], $arFields['IBLOCK_ID'], $newPicturesProps);
	}
}
function make_picture($input, $height_input = false) {
	$width = [
		'mobile' => [
			'start' => '0',
			'end' => '320',
		],
		'md-mobile' => [
			'start' => '321',
			'end' => '353',
		],
		'lg-mobile' => [
			'start' => '354',
			'end' => '414',
		],
		'xl-mobile' => [
			'start' => '415',
			'end' => '630',
		],
		'tablet' => [
			'start' => '631',
			'end' => '698',
		],
		'md-tablet' => [
			'start' => '699',
			'end' => '767',
		],
		'lg-tablet' => [
			'start' => '768',
			'end' => '779',
		],
		'xl-tablet' => [
			'start' => '780',
			'end' => '1023',
		],
		'desktop' => [
			'start' => '1024',
			'end' => '1069',
		],
		'md-desktop' => [
			'start' => '1070',
			'end' => '1199',
		],
		'lg-desktop' => [
			'start' => '1200',
			'end' => '1319',
		],
		'xl-desktop' => [
			'start' => '1320',
			'end' => 'max',
		],
	];
	$height = [
		'mobile' => $width['mobile']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'md-mobile' => $width['md-mobile']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'lg-mobile' => $width['lg-mobile']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'xl-mobile' => $width['xl-mobile']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'tablet' => $width['tablet']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'md-tablet' => $width['md-tablet']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'lg-tablet' => $width['lg-tablet']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'xl-tablet' => $width['xl-tablet']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'desktop' => $width['desktop']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'md-desktop' => $width['md-desktop']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'lg-desktop' => $width['lg-desktop']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'xl-desktop' => ($height_input['xl-desktop'] !== '' ? $height_input['xl-desktop'] : $input['HEIGHT']),
	];
	foreach ($width as $key => $value) {
		if($key == 'xl-desktop') {
			$input['PP'][$value['start'].'-'.$value['end']] = CFile::ResizeImageGet($input, array('width' => $input['WIDTH'], 'height' => $height[$key]), BX_RESIZE_IMAGE_EXACT, true);
		} else {
			$input['PP'][$value['start'].'-'.$value['end']] = CFile::ResizeImageGet($input, array('width' => $width[$key]['end'], 'height' => $height[$key]), BX_RESIZE_IMAGE_EXACT, true);
		}
	}
	$input['PP']['default'] = $input['SRC'];
	$output = $input['PP'];
	return $output;
}
function make_picture_min($input, $height) {
	$width = [
		'mobile' => [
			'start' => '0',
			'end' => '320',
		],
		'md-mobile' => [
			'start' => '321',
			'end' => '353',
		],
		'lg-mobile' => [
			'start' => '354',
			'end' => '414',
		],
		'xl-mobile' => [
			'start' => '415',
			'end' => '630',
		],
		'tablet' => [
			'start' => '631',
			'end' => '698',
		],
		'md-tablet' => [
			'start' => '699',
			'end' => '767',
		],
		'lg-tablet' => [
			'start' => '768',
			'end' => '779',
		],
		'xl-tablet' => [
			'start' => '780',
			'end' => '1023',
		],
		'desktop' => [
			'start' => '1024',
			'end' => '1069',
		],
		'md-desktop' => [
			'start' => '1070',
			'end' => '1199',
		],
		'lg-desktop' => [
			'start' => '1200',
			'end' => '1319',
		],
		'xl-desktop' => [
			'start' => '1320',
			'end' => 'max',
		],
	];
	foreach ($width as $key => $value) {
		$input['PP'][$value['start'].'-'.$value['end']] = CFile::ResizeImageGet($input, array('width' => $height[$key], 'height' => $height[$key]), BX_RESIZE_IMAGE_EXACT, true);
	}
	$input['PP']['default'] = $input['SRC'];
	$output = $input['PP'];
	return $output;
}
function make_picture_height($input, $height_input) {
	$width = [
		'mobile' => [
			'start' => '0',
			'end' => '320',
		],
		'md-mobile' => [
			'start' => '321',
			'end' => '353',
		],
		'lg-mobile' => [
			'start' => '354',
			'end' => '414',
		],
		'xl-mobile' => [
			'start' => '415',
			'end' => '630',
		],
		'tablet' => [
			'start' => '631',
			'end' => '698',
		],
		'md-tablet' => [
			'start' => '699',
			'end' => '767',
		],
		'lg-tablet' => [
			'start' => '768',
			'end' => '779',
		],
		'xl-tablet' => [
			'start' => '780',
			'end' => '1023',
		],
		'desktop' => [
			'start' => '1024',
			'end' => '1069',
		],
		'md-desktop' => [
			'start' => '1070',
			'end' => '1199',
		],
		'lg-desktop' => [
			'start' => '1200',
			'end' => '1319',
		],
		'xl-desktop' => [
			'start' => '1320',
			'end' => 'max',
		],
	];
	$height = [
		'mobile' => $width['mobile']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'md-mobile' => $width['md-mobile']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'lg-mobile' => $width['lg-mobile']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'xl-mobile' => $width['xl-mobile']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'tablet' => $width['tablet']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'md-tablet' => $width['md-tablet']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'lg-tablet' => $width['lg-tablet']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'xl-tablet' => $width['xl-tablet']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'desktop' => $width['desktop']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'md-desktop' => $width['md-desktop']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'lg-desktop' => $width['lg-desktop']['end'] * $input['HEIGHT'] / $input['WIDTH'],
		'xl-desktop' => ($height_input['xl-desktop'] !== '' ? $height_input['xl-desktop'] : $input['HEIGHT']),
	];
	foreach ($width as $key => $value) {
		if($key == 'xl-desktop') {
			$input['PP'][$value['start'].'-'.$value['end']] = CFile::ResizeImageGet($input, array('width' => $input['WIDTH'], 'height' => $height_input[$key]), BX_RESIZE_IMAGE_EXACT, true);
		} else {
			$input['PP'][$value['start'].'-'.$value['end']] = CFile::ResizeImageGet($input, array('width' => $height_input[$key], 'height' => $height_input[$key]), BX_RESIZE_IMAGE_EXACT, true);
		}
	}
	$input['PP']['default'] = $input['SRC'];
	$output = $input['PP'];
	return $output;
}
function calculateReadingTime($text, $wordsPerMinute = 50) {
	$words = str_word_count(strip_tags($text));
	$readingTime = ceil($words / $wordsPerMinute);
	return $readingTime;
}
function inclination($time, $arr) {
	$timex = substr($time, -1);
	if ($time >= 10 && $time <= 20) {
		return $arr[2];
	} elseif ($timex == 1) {
		return $arr[0];
	} elseif ($timex > 1 && $timex < 5) {
		return $arr[1];
	} else {
		return $arr[2];
	}
}