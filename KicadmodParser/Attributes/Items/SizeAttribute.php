<?php
namespace Hk\KicadmodParser\Attributes\Items;

use Hk\KicadmodParser\Attributes\Attribute;
use Hk\KicadmodParser\Geometry\Point;
use Hk\KicadmodParser\Geometry\Size;

class SizeAttribute extends Attribute
{
    use NoBoundingBoxTrait;

    const NODE_NAME = 'size';

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
     * @return Size
     */
    public function getSize():Size
    {
        $ret = new Size();
        if( isset($this->parameters[0]) === TRUE && is_numeric($this->parameters[0]) === TRUE )
        {
            $ret->setWidth($this->parameters[0]);
        }
        if( isset($this->parameters[1]) === TRUE && is_numeric($this->parameters[1]) === TRUE )
        {
            $ret->setHeight($this->parameters[1]);
        }
        return $ret;
    }

}