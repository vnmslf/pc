<?php

namespace Dao;

class Section
{
    /**
     * @var array
     */
    protected $data = array();
    /**
     * @var array
     */
    public $rawData = array();
    /**
     * @var null
     */
    protected $sub = null;
    /**
     * @var null
     */
    protected $infoblock = null;
    
    /**
     * Section constructor.
     * @param array $data
     */
    public function __construct($data = array())
    {
        foreach (array_keys($data) as $key) {
            if ($key[0] == '~') {
                $this->rawData[substr($key, 1)] = $data[$key];
                unset($data[$key]);
            }
        }
        $this->data = $data;
    }
    
    /**
     * @return null
     */
    public function id()
    {
        return isset($this->data['ID']) ? $this->data['ID'] : null;
    }
    
    /**
     * @return mixed|null
     */
    public function title()
    {
        return $this->data['NAME'];
    }
    
    /**
     * @return int
     */
    public function parentId()
    {
        return (int)$this['IBLOCK_SECTION_ID'];
    }
    
    /**
     * @return mixed
     */
    public function url()
    {
        return $this->data['SECTION_PAGE_URL'];
    }
}
