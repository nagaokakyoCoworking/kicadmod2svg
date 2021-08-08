<?php
namespace Hk\KicadmodParser\Attributes\Items;

use Hk\KicadmodParser\Attributes\Attribute;

class LayerAttribute extends Attribute
{
    use NoBoundingBoxTrait;

    const NODE_NAME = 'layer';

    /**
     * constructor.
     *
     * @param array $parameters
     */
    public function __construct($parameters)
    {
        parent::__construct(self::NODE_NAME,$parameters);
    }

    /**
     * 値を取得する
     *
     * @return string 値
     */
    public function getValue()
    {
        $ret = isset($this->parameters[0]) === TRUE ? $this->parameters[0] : '';
        return $ret;
    }

}