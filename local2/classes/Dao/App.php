<?php

namespace Dao;

class App
{
    public static $infoblocks;
    public static $highloadblocks;
    public static $userFields;
    
    /**
     * @param $code
     *
     * @return \Dao\InfoBlock|mixed
     */
    public static function ib($code)
    {
        if (!isset(self::$infoblocks[$code])) {
            $ibObj = new \Dao\InfoBlock($code);
            self::$infoblocks[$code] = $ibObj;
        } else {
            $ibObj = self::$infoblocks[$code];
        }
        
        return $ibObj;
    }
    
    /**
     * @param $code
     *
     * @return \Dao\InfoBlock|mixed
     */
    public static function userField($code, $entityId = false)
    {
        if (!isset(self::$userFields[$code])) {
            $ufObj = new \Dao\UserField($code);
            self::$userFields[$code] = $ufObj;
        } else {
            $ufObj = self::$userFields[$code];
        }
        
        return $ufObj;
    }
    
    /**
     * @param $hlName
     *
     * @return \Dao\HighloadBlock|mixed
     */
    public static function hl($hlName)
    {
        if (!isset(self::$highloadblocks[$hlName])) {
            $hlObj = new \Dao\HighloadBlock($hlName);
            self::$highloadblocks[$hlName] = $hlObj;
        } else {
            $hlObj = self::$highloadblocks[$hlName];
        }
        
        return $hlObj;
    }
    
    public static function isAjax()
    {
        if (config('APP_ENV') == 'local') {
            return true;
        }
        
        $request = \Bitrix\Main\Context::getCurrent()->getRequest();
        return $request->isAjaxRequest();
    }
    
    /**
     * @return mixed
     */
    public static function config($name)
    {
        return \Bitrix\Main\Config\Configuration::getInstance()->get('configs')[$name];
    }
    
    /**
     * Получаем данные по урлу
     *
     * @param $url
     *
     * @return bool|string
     */
    public static function getJSONDataByUrl($url)
    {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        return curl_exec($ch);
    }
    
    /**
     * Получаем текущий хост
     *
     * @return string
     */
    public static function getHost()
    {
        $host = str_replace(":443", "", $_SERVER['HTTP_HOST']);
        return ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $host;
    }
    
    /**
     * Получаем ip посетителя
     *
     * @return string
     */
    public static function getIp()
    {
    
        return filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
    }
    
    public static function getStageType()
    {
        $isProd = config('APP_ENV') == 'prod' && self::getHost() == 'https://tarantasik.ru';
        return $isProd ? 'prod' : 'dev';
    }
    
    public static function getUrlFromPath($filePath)
    {
        return self::getHost().str_replace($_SERVER['DOCUMENT_ROOT'], '', $filePath);
    }
    
    public static function fileSizeConvert($bytes)
    {
        $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );
    
        foreach($arBytes as $arItem)
        {
            if($bytes >= $arItem["VALUE"])
            {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
                break;
            }
        }
        return $result;
    }
    
    public static function uniqidReal($length = 13)
    {
        // uniqid gives 13 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $length);
    }
    
    /**
     * Создает CSV файл из переданных в массиве данных.
     *
     * @param array  $rawData   Массив данных, из которых нужно создать CSV файл.
     * @param string $filePath          Путь до файла 'path/to/test.csv'. Если не указать, то просто вернет результат.
     * @param string $colDelimiter Разделитель колонок. Default: `;`.
     * @param string $rowDelimiter Разделитель рядов. Default: `\r\n`.
     *
     * @return false|string CSV строку или false, если не удалось создать файл.
     *
     * @version 2
     */
    public static function makeCsvFile($rawData, $filePath = null,
        $colDelimiter = ';', $rowDelimiter = "\r\n"
    ) {
        
        if (!is_array($rawData)) {
            return false;
        }
        
        if ($filePath && !is_dir(dirname($filePath))) {
            return false;
        }
        
        // строка, которая будет записана в csv файл
        $CSV_str = '';
        
        // перебираем все данные
        foreach ($rawData as $row) {
            $cols = array();
            
            foreach ($row as $col_val) {
                // строки должны быть в кавычках ""
                // кавычки " внутри строк нужно предварить такой же кавычкой "
                if ($col_val && preg_match('/[",;\r\n]/', $col_val)) {
                    // поправим перенос строки
                    if ($rowDelimiter === "\r\n") {
                        $col_val = str_replace(["\r\n", "\r"], ['\n', ''],
                            $col_val);
                    } elseif ($rowDelimiter === "\n") {
                        $col_val = str_replace(["\n", "\r\r"], '\r', $col_val);
                    }
                    
                    $col_val = str_replace('"', '""', $col_val); // предваряем "
                    $col_val = '"' . $col_val . '"'; // обрамляем в "
                }
                
                $cols[] = $col_val; // добавляем колонку в данные
            }
            
            $CSV_str .= implode($colDelimiter, $cols)
                . $rowDelimiter; // добавляем строку в данные
        }
        
        $CSV_str = rtrim($CSV_str, $rowDelimiter);
        
        if ($filePath) {
//            $CSV_str = iconv("UTF-8", "cp1251", $CSV_str);
            
            // создаем csv файл и записываем в него строку
            $done = file_put_contents($filePath, $CSV_str);
            
            return $done ? $CSV_str : false;
        }
        
        return $CSV_str;
        
    }
    
    /**
     * @param $cachePath // папка, в которой лежит кеш
     * @param $cacheTtl // срок годности кеша (в секундах)
     * @param $cacheKey // имя кеша
     * @param $data array // кешируемые данные
     *
     * @return mixed
     */
    public static function btrxCacheForArr($cachePath, $cacheTtl, $cacheKey, $data)
    {
        $cache = \Bitrix\Main\Data\Cache::createInstance(); // Служба кеширования
    
        if ($cache->initCache($cacheTtl, $cacheKey, $cachePath))
        {
            $vars = $cache->getVars(); // Получаем переменные
        }
        elseif ($cache->startDataCache())
        {
            $vars = $data;
            $cache->endDataCache($vars);
        }
        
        return $vars;
    }
}
