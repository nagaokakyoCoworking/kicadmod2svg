<?php
namespace Hk\KicadmodParser\Attributes\Items;

use Hk\KicadmodParser\Attributes\Attribute;
use Hk\KicadmodParser\Geometry\BoundingBox;
use Hk\KicadmodParser\Geometry\Point;
use Hk\KicadmodParser\Geometry\Size;

class PadAttribute extends Attribute
{
    const NODE_NAME = 'pad';

    const PAD_TYPE_RECTANGLE = 'rect';
    const PAD_TYPE_OVAL = 'oval';

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
     * インデックス番号を取得する
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->parameters[0];
    }

    /**
     * パッド種別 を取得する
     *
     * @return string
     */
    public function getType()
    {
        return $this->parameters[1];
    }

    /**
     * 描写種別 を取得する
     *
     * @return string
     */
    public function getRenderingType()
    {
        return $this->parameters[2];
    }

    /**
     * 中心位置 を取得する
     * @return Point|null
     */
    public function getCenterPoint():Point
    {
        $ret = NULL;
        $values = $this->getAttributes(AtAttribute::NODE_NAME);
        if( is_array($values) === TRUE )
        {
            /**
             * @var AtAttribute $obj
             */
            foreach($values as $obj)
            {
                $ret = $obj->getPoint();
            }
        }
        return $ret;
    }

    /**
     * サイズを取得する
     * @return Size
     */
    public function getSize():Size
    {
        $ret = NULL;
        $values = $this->getAttributes(SizeAttribute::NODE_NAME);
        if( is_array($values) === TRUE )
        {
            /**
             * @var SizeAttribute $obj
             */
            foreach($values as $obj)
            {
                $ret = $obj->getSize();
            }
        }
        return $ret;
    }

    /**
     * レイヤー を取得する
     * @return array
     */
    public function getLayers():array
    {
        $ret = [];
        $values = $this->getAttributes(LayersAttribute::NODE_NAME);
        if( is_array($values) === TRUE )
        {
            /**
             * @var LayersAttribute $obj
             */
            foreach($values as $obj)
            {
                $ret = $obj->getValues();
            }
        }
        return $ret;
    }

    /**
     * ドリルのサイズ を取得する
     * @return int
     */
    public function getDrillSize():int
    {
        $ret = 0;
        $values = $this->getAttributes(DrillAttribute::NODE_NAME);
        if( is_array($values) === TRUE )
        {
            /**
             * @var DrillAttribute $obj
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

        $point = $this->getCenterPoint();
        $size = $this->getSize();
        if( $point !== NULL && $size !== NULL )
        {
            $widthHalf = $size->getWidth()/2;
            $heightHalf = $size->getWidth()/2;

            $x = $point->getX() - $widthHalf;
            $y = $point->getY() + $heightHalf;
            $startPoint = new Point($x,$y);
            $boundingBox->setStartPoint($startPoint);

            $x = $point->getX() + $widthHalf;
            $y = $point->getY() - $heightHalf;
            $endPoint = new Point($x,$y);
            $boundingBox->setEndPoint($endPoint);
        }
        return $boundingBox;
    }
}