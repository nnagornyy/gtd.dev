<?php
namespace Gtd\Dev\Model;

class BaseIblockModel implements IblockModelInterface{

    protected $fields;

    protected $property;

    public function getMap(): array
    {
        return [];
    }

    public function __construct(\_CIBElement $ob)
    {
        $this->fields = $ob->GetFields();
        $this->property = $ob->GetProperties();
    }

    public static function createInstance(\_CIBElement $ob)
    {
        return new static($ob);
    }

    public function getApiModel(): array
    {
        $arResult = [];
        if(empty($this->getMap())){
            foreach ($this->fields as $k => $v){
                if(substr($k,0,1) === '~')
                    continue;

                $arResult[$this->dashesToCamelCase($k)] = $v;
            }
            foreach ($this->property as $k => $v){
                $arResult['property'][$this->dashesToCamelCase($k)] = $v['VALUE'];
            }
        }
        return $arResult;
    }

    public function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
    {
        $string = strtolower($string);
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }
        return $str;
    }
}