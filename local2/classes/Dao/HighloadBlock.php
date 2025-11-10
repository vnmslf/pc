<?php

namespace Dao;

use \Bitrix\Main\Loader as Loader;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Entity;
//use \Bitrix\Main\ORM\Entity;

class HighloadBlock
{
    /**
     * @var string|bool
     */
    protected $hlClassName = false;
    /**
     * @var string|bool
     */
    protected $tableName = false;
    /**
     * @var string|bool
     */
    protected $hlName = false;
    /**
     * @var number|bool
     */
    protected $id = false;
    /**
     * @var \Bitrix\Main\ORM\Entity|bool
     */
    protected $hlEntity = false;
    
    /**
     * HighloadBlock constructor.
     * @param $hlNameOrId
     */
    public function __construct($hlNameOrId)
    {
        Loader::includeModule("highloadblock");
        
        $hlblock = false;
        
        if (is_numeric($hlNameOrId)) {
            $hlblock = HL\HighloadBlockTable::getById($hlNameOrId)->fetch();
            
            if ($hlblock) {
                $this->id = $hlNameOrId;
            }
        } else {
            $hlblock = HL\HighloadBlockTable::getList([
                'filter' => ['=NAME' => $hlNameOrId]
            ])->fetch();
        }
        
        if (!$hlblock) {
            return false;
            // throw new \Exception('[04072017.1331.1]');
        } else {
            $this->id = $hlblock['ID'];
            $this->hlName = $hlblock['NAME'];
            $this->tableName = $hlblock['TABLE_NAME'];
        }
    
        $this->hlEntity = HL\HighloadBlockTable::compileEntity($hlblock);
        $this->hlClassName = $this->hlEntity->getDataClass();
    }
    
    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }
    
    /**
     * @return string|bool
     */
    public function hlName()
    {
        return $this->hlName;
    }
    
    /**
     * @param string код поля
     *
     * @return array массив с информацией о поле
     */
    public function getFieldInfo($code)
    {
        $dbField = \CUserTypeEntity::GetList(
            [],
            ['ENTITY_ID' => 'HLBLOCK_' . $this->id(), 'FIELD_NAME' => $code, 'LANG' => LANGUAGE_ID]
        );
        
        return $dbField->Fetch();
    }
    
    /**
     * @return array
     */
    public function getFields() {
        return $this->hlEntity->getFields();
    }
    
    /**
     * TODO: найти более оптимальный способ, желательно - через D7
     *
     * @param $fieldCode
     * @param $xmlId
     *
     * @return false|mixed
     */
    public function getEnumListFieldIdByXmlId($fieldCode, $xmlId)
    {
        $fieldData = $this->getUFFieldData($fieldCode);
        if (count($fieldData['ENUMERATION_LIST']) < 1) {
            return false;
        }
        foreach ($fieldData['ENUMERATION_LIST'] as $item) {
            if ($item['XML_ID'] === $xmlId) {
                return $item['ID'];
            }
        }
        return false;
    }
    
    public function getXmlIdByEnumListFieldId($fieldCode, $fieldId)
    {
        $fieldData = $this->getUFFieldData($fieldCode);
        if (count($fieldData['ENUMERATION_LIST']) < 1) {
            return false;
        }
        foreach ($fieldData['ENUMERATION_LIST'] as $id => $item) {
            if ((int)$id === (int)$fieldId) {
                return $item['XML_ID'];
            }
        }
        return false;
    }
    
    public function getUFFieldData($fieldCode) {
        $ufFields = $this->getOldData()['UF'];
        if (count($ufFields) < 1) {
            return false;
        }
        foreach ($ufFields as $field) {
            if ($field['FIELD_NAME'] === $fieldCode) {
                return $field;
            }
        }
        return false;
    }
    
    public function getOldData()
    {
        Loader::includeModule("highloadblock");
        
        $arHlFileds = array();
        $hlblockID = $this->id();
        
        if (!$hlblockID) return false;
        $hlblock = HL\HighloadBlockTable::getById($hlblockID)->fetch();
        if (!$hlblock) return false;
        
        $arHlFileds['FIELD'] = $hlblock;
        
        $res = \Bitrix\Highloadblock\HighloadBlockLangTable::getList(array(
            "filter"=>array("ID"=>$hlblock['ID']),
        ));
        while($ar = $res->fetch()){
            $arS = $ar;
            unset($arS['ID']);
            $arHlFileds['LANG'][] = $arS;
        }
        //TODO right //dev.1c-bitrix.ru/api_d7/bitrix/highloadblock/highloadblockrightstable/index.php
        
        
        $arSaveFields = array();
        $entity = "HLBLOCK_" . $hlblockID;
        
        $arEnumerator = $AR_ID = array();
        
        $rsData = \CUserTypeEntity::GetList(array("SORT" => "ASC"), array(
            "ENTITY_ID" => $entity,
        ));
        while($ar = $rsData->fetch()){
            
            if($ar['USER_TYPE_ID'] == "enumeration"){
                $arEnumerator[] = $ar['ID'];
            }
            
            $arS = $ar;
            unset($arS['ID'], $arS['ENTITY_ID']);
            
            $arSaveFields[$ar['ID']] = $arS;
            $AR_ID[] = $ar['ID'];
        }
        
        if(count($arEnumerator)>0){
            $rsEnum = \CUserFieldEnum::GetList(array('SORT'=>"ASC"), array(
                "USER_FIELD_ID" =>$arEnumerator,
            ));
            while($arEnum = $rsEnum->Fetch())
            {
                $arS = $arEnum;
                $arSaveFields[$arEnum['USER_FIELD_ID']]['ENUMERATION_LIST'][$arEnum['ID']]  = $arS;
            }
        }
        
        if(count($AR_ID)>0){
            $arLangFields = array(
                "EDIT_FORM_LABEL", "LIST_COLUMN_LABEL", "LIST_FILTER_LABEL", "ERROR_MESSAGE", "HELP_MESSAGE"
            );
            $STR_ID = implode(",",$AR_ID);
            $connection = \Bitrix\Main\Application::getConnection();
            $res = $connection->query("SELECT * FROM b_user_field_lang WHERE USER_FIELD_ID IN (".$STR_ID.")");
            while($ar = $res->Fetch()){
                foreach($arLangFields as $field){
                    if($ar[$field]){
                        $arSaveFields[$ar['USER_FIELD_ID']][$field][$ar['LANGUAGE_ID']] = $ar[$field];
                    }
                }
            }
        }
        $arHlFileds['UF'] = $arSaveFields;
        return $arHlFileds;
    }
    
    public function getItems($args = [])
    {
        if (!isset($args['select'])) {
            $args['select'] = ['*'];
        }
        if (!isset($args['order'])) {
            $args['order'] = ['ID' => 'DESC'];
        }
    
        $items = $this->hlClassName::getList($args)->fetchAll();
        
        return $items;
    }
    
    public function addItem($args = [])
    {
        return $this->hlClassName::add($args);
    }
    
    public function updateItem($itemId, $args = [])
    {
        return $this->hlClassName::update($itemId, $args);
    }
    
    public function deleteItem($itemId)
    {
        return $this->hlClassName::delete($itemId);
    }
}
