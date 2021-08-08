<?php
namespace Hk\KicadmodParser\Attributes\Items;

use Hk\KicadmodParser\Attributes\Attribute;
use Hk\KicadmodParser\Geometry\Point;

class AtAttribute extends Attribute
{
    use NoBoundingBoxTrait;

    const NODE_NAME = 'at';

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
     * X,Y 座標を取得する
     *
     * @return Point
     */
    public function getPoint():Point
    {
        $ret = new Point();
        if( isset($this->parameters[0]) === TRUE && is_numeric($this->parameters[0]) === TRUE )
        {
            $ret->setX($this->parameters[0]);
        }
        if( isset($this->parameters[1]) === TRUE && is_numeric($this->parameters[1]) === TRUE )
        {
            $ret->setY($this->parameters[1]);
        }
        return $ret;
    }

}