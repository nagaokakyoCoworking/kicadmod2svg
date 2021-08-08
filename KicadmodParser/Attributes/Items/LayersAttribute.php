<?php
namespace Hk\KicadmodParser\Attributes\Items;

use Hk\KicadmodParser\Attributes\Attribute;

class LayersAttribute extends Attribute
{
    use NoBoundingBoxTrait;

    const NODE_NAME = 'layers';

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
     * @return array 値
     */
    public function getValues():array
    {
        return $this->parameters;
    }

}