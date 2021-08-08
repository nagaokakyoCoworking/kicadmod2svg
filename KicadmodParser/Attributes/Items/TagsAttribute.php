<?php
namespace Hk\KicadmodParser\Attributes\Items;

use Hk\KicadmodParser\Attributes\Attribute;
use Hk\KicadmodParser\Geometry\BoundingBox;

/**
 * "tags" Attribute
 *
 */
class TagsAttribute extends Attribute
{
    use NoBoundingBoxTrait;

    const NODE_NAME = 'tags';

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
        $ret = implode('\n',$this->parameters);
        return $ret;
    }
}