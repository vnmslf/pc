<?php

namespace Dao;

class InfoBlock
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
     * @var array|bool
     */
    protected $data = false;
    
    /**
     * InfoBlock constructor.
     * @param $codeOrId
     */
    public function __construct($codeOrId)
    {
        if(\CModule::IncludeModule("iblock"))
        {
            if (is_numeric($codeOrId)) {
                $this->id = $codeOrId;
            } else {
                $this->setCode($codeOrId);
            }
            $this->data = $this->loadData();
        }
    }
    /*public function __construct($codeOrId)
    {
        if (is_numeric($codeOrId)) {
            $this->id = $codeOrId;
        } else {
            $this->setCode($codeOrId);
        }
        $this->data = $this->loadData();
    }*/
    
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
     * @return array
     */
    protected function loadData()
    {
        if ($this->getCode()) {
            $result = \CIBlock::GetList(array('SORT' => 'ASC'), array('CODE' => $this->getCode(), 'CHECK_PERMISSIONS' => 'N'));
        } else if ($this->id) {
            $result = \CIBlock::GetList(array('SORT' => 'ASC'), array('ID' => $this->id, 'CHECK_PERMISSIONS' => 'N'));
        }
        
        return $result ? $result->Fetch() : false;
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
        if (is_array($this->data) && isset($this->data['IBLOCK_TYPE_ID'])) {
            return $this->data['IBLOCK_TYPE_ID'];
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
}
