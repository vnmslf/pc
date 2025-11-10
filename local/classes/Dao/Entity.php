<?php

namespace Dao;

class Entity
{
    /**
     * @var array
     */
    public $fieldsData = array();
    /**
     * @var array
     */
    public $propertiesData = array();
    
    /**
     * @var \Dao\InfoBlock|null
     */
    protected $infoblock;
    
    /**
     * Entity constructor.
     * @param array $fields
     * @param array $properties
     */
    public function __construct($fields = array(), $properties = array())
    {
        $this->fieldsData = $fields;
        $this->propertiesData = $properties;
    }
    
    /**
     * @param \Dao\InfoBlock $infoblock
     */
    public function setInfoBlock($infoblock)
    {
        $this->infoblock = $infoblock;
        $this->fieldsData['IBLOCK_ID'] = $infoblock->id();
    }
    
    /**
     * @return int
     */
    public function id()
    {
        return isset($this->fieldsData['ID']) ? $this->fieldsData['ID'] : null;
    }
    
    /**
     * @return \Dao\InfoBlock
     */
    public function infoblock()
    {
        return $this->infoblock;
    }
    
    /**
     * @return string
     */
    public function title()
    {
        return isset($this->fieldsData['NAME']) ? $this->fieldsData['NAME'] : '';
    }
    
    /**
     * @return bool
     */
    public function isActive()
    {
        return $this['ACTIVE'] == 'Y';
    }
    
    /**
     * @return \Dao\InfoBlock[]
     */
    public function getCategories()
    {
        $rows = array();
        $result = \CIBlockElement::GetElementGroups($this->id(), true);
        while ($row = $result->GetNext()) {
            $rows[$row['ID']] = $this->infoblock()->makeSectionItemByRow($row);
        }
        return $rows;
    }
    
    /**
     * @param string $mode
     * @return string
     */
    public function url()
    {
        $url = '';
        if (isset($this->fieldsData['DETAIL_PAGE_URL'])) {
            $url = trim($this->fieldsData['DETAIL_PAGE_URL']);
        }
        return $url;
    }
}
