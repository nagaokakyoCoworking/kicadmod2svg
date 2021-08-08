<?php
namespace Hk\KicadmodParser\Attributes\Items;

use Hk\KicadmodParser\Attributes\Attribute;
use Hk\KicadmodParser\Geometry\BoundingBox;

class WidthAttribute extends Attribute
{
    use NoBoundingBoxTrait;

    const NODE_NAME = 'width';

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
     * 幅を取得する
     *
     * @return float
     */
    public function getValue():float
    {
        $ret = -1;
        if( isset($this->parameters[0]) === TRUE && is_numeric($this->parameters[0]) === TRUE )
        {
            $ret = $this->parameters[0];
        }
        return $ret;
    }
}