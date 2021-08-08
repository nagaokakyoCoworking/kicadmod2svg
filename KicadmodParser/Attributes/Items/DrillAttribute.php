<?php
namespace Hk\KicadmodParser\Attributes\Items;

use Hk\KicadmodParser\Attributes\Attribute;
use Hk\KicadmodParser\Geometry\BoundingBox;

class DrillAttribute extends Attribute
{
    use NoBoundingBoxTrait;

    const NODE_NAME = 'drill';

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
     * ドリル穴の直径を取得する
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