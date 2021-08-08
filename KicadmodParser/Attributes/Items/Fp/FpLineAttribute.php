<?php
namespace Hk\KicadmodParser\Attributes\Items\Fp;

use Hk\KicadmodParser\Attributes\Attribute;
use Hk\KicadmodParser\Attributes\Items\EndAttribute;
use Hk\KicadmodParser\Attributes\Items\LayerAttribute;
use Hk\KicadmodParser\Attributes\Items\StartAttribute;
use Hk\KicadmodParser\Attributes\Items\WidthAttribute;
use Hk\KicadmodParser\Geometry\BoundingBox;
use Hk\KicadmodParser\Geometry\Point;

class FpLineAttribute extends Attribute
{
    const NODE_NAME = 'fp_line';

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
     * 開始点 を取得する
     *
     * @return Point
     */
    public function getStartPoint(): Point
    {
        $ret = new Point();
        $values = $this->getAttributes(StartAttribute::NODE_NAME);
        if( is_array($values) === TRUE )
        {
            /**
             * @var StartAttribute $obj
             */
            foreach($values as $obj)
            {
                $ret = $obj->getPoint();
            }
        }
        return $ret;
    }

    /**
     * 終了点 を取得する
     *
     * @return Point
     */
    public function getEndPoint(): Point
    {
        $ret = new Point();
        $values = $this->getAttributes(EndAttribute::NODE_NAME);
        if( is_array($values) === TRUE )
        {
            /**
             * @var EndAttribute $obj
             */
            foreach($values as $obj)
            {
                $ret = $obj->getPoint();
            }
        }
        return $ret;
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        $ret = -1;
        $values = $this->getAttributes(WidthAttribute::NODE_NAME);
        if( is_array($values) === TRUE )
        {
            /**
             * @var WidthAttribute $obj
             */
            foreach($values as $obj)
            {
                $ret = $obj->getValue();
            }
        }
        return $ret;
    }


    /**
     * レイヤー名を取得する
     *
     * @return string
     */
    public function getLayerName()
    {
        $ret = '';
        $values = $this->getAttributes(LayerAttribute::NODE_NAME);
        if( is_array($values) === TRUE )
        {
            /**
             * @var LayerAttribute $obj
             */
            foreach($values as $obj)
            {
                $ret = $obj->getValue();
            }
        }
        return $ret;
    }

    /**
     * @return bool
     */
    public function hasBoundingBox(): bool
    {
        return TRUE;
    }

    /**
     * @return BoundingBox
     */
    public function getBoundingBox(): BoundingBox
    {
        $boundingBox = new BoundingBox();
        $boundingBox->setStartPoint($this->getStartPoint());
        $boundingBox->setEndPoint($this->getEndPoint());
        return $boundingBox;
    }

}