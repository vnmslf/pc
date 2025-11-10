<?php

namespace Dao;

class UserField
{
    /**
     * @var string|bool
     */
    protected $code = false;
    
    /**
     * @var number|bool
     */
    protected $id = false;
    
    /**
     * @var number|bool
     */
    protected $entityId = false;
    
    /**
     * @var array|bool
     */
    protected $data = false;
    
    /**
     * InfoBlock constructor.
     * @param $codeOrId
     */
    public function __construct($codeOrId, $entityId = false)
    {
        if (is_numeric($codeOrId)) {
            $this->id = $codeOrId;
        } else {
            $this->setCode($codeOrId);
        }
        
        if ($entityId) {
            $this->entityId = $entityId;
        }
        $this->data = $this->loadData();
    }
    
    /**
     * @param $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    
    /**
     * @return string|bool
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * @return string|bool
     */
    public function getEntityId()
    {
        return $this->entityId;
    }
    
    /**
     * @return array
     */
    protected function loadData()
    {
        $arFilter = [];
        if ($this->getEntityId()) {
            $arFilter['ENTITY_ID'] = $this->getEntityId();
        }
        if ($this->getCode()) {
            $arFilter['FIELD_NAME'] = $this->getCode();
        }
        if ($this->id()) {
            $arFilter['ID'] = $this->id();
        }
    
        $result = \CUserTypeEntity::GetList(
            [],
            $arFilter
        );
    
        $field = [];
        while($arRes = $result->Fetch()) {
            if ($arRes['USER_TYPE_ID'] === 'enumeration') {
                $obEnum = new \CUserFieldEnum;
                $rsEnum = $obEnum->GetList(array(), array("USER_FIELD_ID" => $arRes["ID"]));
                $enum = array();
                while($arEnum = $rsEnum->Fetch()) {
                    $enum[$arEnum["ID"]] = $arEnum;
                }
                $arRes['LIST_VALUES'] = $enum;
            }
            $field = $arRes;
        }
        
        return $field ? $field : false;
    }
    
    /**
     * @return mixed
     */
    public function id()
    {
        if (is_array($this->data) && isset($this->data['ID'])) {
            return $this->data['ID'];
        }
    }
    
    /**
     * @return mixed
     */
    public function type()
    {
        if (is_array($this->data) && isset($this->data['USER_TYPE_ID'])) {
            return $this->data['USER_TYPE_ID'];
        }
    }
    
    /**
     * @return string|bool
     */
    public function code()
    {
        if (is_array($this->data) && isset($this->data['CODE'])) {
            return $this->data['CODE'];
        }
    }
    
    /**
     * @return array|bool
     */
    public function getData()
    {
        return $this->data;
    }
}
