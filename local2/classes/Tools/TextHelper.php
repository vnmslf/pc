<?php
namespace Tools;
/**
 * Class TextHelper
 */
class TextHelper
{

    /**
     * $number — число
     * $value — слово, например «результат»
     * $suffix — окончания слова, например ['', 'а', 'ов']
     */
    public static function numberSuffix($number, $value, $suffix) {
		//ключи массива suffix
		$keys = array(2, 0, 1, 1, 1, 2);
		
		//берем 2 последние цифры
		$mod = $number % 100;
		
		//определяем ключ окончания
		$suffix_key = $mod > 4 && $mod < 21 ? 2 : $keys[min($mod%10, 5)];
		
		return $value . $suffix[$suffix_key];
	}
}