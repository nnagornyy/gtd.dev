<?php

namespace GTD\Dev\Options\Entity;

use GTD\Dev\Options\BaseEntity;

class Tab
{
    private $name;

    /* @var BaseEntity[]*/
    public $fields = [];

    private $title;

    private $id;

    public function __construct($title)
    {
        $this->setTitle($title);
        $this->generateId();
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $id
     */
    protected function generateId()
    {
        $this->id = 'gtd_option_tab_'.rand(1000,9999);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getHtml()
    {
        foreach ($this->fields as $field){
            $this->startRow($field);
            $field->getHtml();
            $this->endRow();
        }
    }

    public function startRow(BaseEntity $field){
        ?>
        <tr>
            <td><?=$field->getTitle()?></td>
            <td>
        <?
    }

    public function endRow(){
        ?>
            </td>
        </tr>
        <?
    }

    public function setField(BaseEntity $filed): self
    {
        $this->fields[] = $filed;
        return $this;
    }
}