<?php

namespace GTD\Dev\Options\Entity;

use GTD\Dev\Options\BaseEntity;

class InputField implements BaseEntity {

    private $value;

    private $id;

    private $title;

    private $default_value;

    private $size = 50;

    public function __construct($id, $title, $default_value = "")
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setDefaultValue($default_value);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return \COption::GetOptionString(PAGE_BUILDER_MODULE_ID, $this->getId(), $this->getDefaultValue());
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        $prefix = str_replace('.','_', PAGE_BUILDER_MODULE_ID);
        return strtoupper($prefix).'_'.$this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = strtoupper($id);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->default_value;
    }

    /**
     * @param mixed $default_value
     */
    public function setDefaultValue($default_value)
    {
        $this->default_value = $default_value;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size)
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    public function getHtml(){
        ?>
            <input type="text" value="<?=$this->getValue()?>" name="<?=$this->getId()?>" size="<?=$this->getSize()?>" placeholder="<?=$this->getTitle()?>">
        <?
    }
}