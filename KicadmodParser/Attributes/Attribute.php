<?php
namespace Hk\KicadmodParser\Attributes;

use Hk\KicadmodParser\Geometry\BoundingBox;

/**
 *
 */
abstract class Attribute
{
    /**
     * Attribute Primary Name
     *
     * @var string
     */
    protected $name;

    /**
     * parameters
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Attributes constructor.
     * @param $name
     */
    public function __construct($name,$parameters)
    {
        $this->name = $name;
        $this->parameters = $parameters;
    }

    /**
     * Attribute Primary Name を取得する
     * @return string
     */
    public function getAttributeName():string
    {
        return $this->name;
    }

    /**
     * 属性名を指定すると、その属性名のみを取得する
     * 指定なしは、すべてを取得する
     *
     * @param string $name 属性名
     * @return array
     */
    public function getAttributes($name = '')
    {
        $factory = AttributesRegistory::getInstance();
        $values = [];
        if( is_array($this->parameters) === TRUE )
        {
            foreach($this->parameters as $data)
            {
                $attributes = $factory->parse($data);
                if( $attributes !== NULL )
                {
                    if( empty($name) === TRUE )
                    {
                        $values[] = $attributes;
                    }
                    else
                    {
                        if( $attributes->getAttributeName() == $name )
                        {
                            $values[] = $attributes;
                        }
                    }
                }
            }
        }
        return $values;
    }

    /**
     * バウンディングボックス が存在するかを判定する
     * @return bool
     */
    public abstract function hasBoundingBox():bool;

    /**
     * バウンディングボックス を取得する
     * @return BoundingBox
     */
    public abstract function getBoundingBox():BoundingBox;
}