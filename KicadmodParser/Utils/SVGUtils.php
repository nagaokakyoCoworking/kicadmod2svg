<?php

namespace Hk\KicadmodParser\Utils;

use Hk\KicadmodParser\Geometry\BoundingBox;
use Hk\KicadmodParser\Geometry\DocumentSize;
use Hk\KicadmodParser\Geometry\Point;

class SVGUtils
{
    /**
     * 領域範囲からドキュメントのサイズを取得する
     *
     * @param BoundingBox $boundingBox
     * @return DocumentSize ドキュメントのサイズ
     */
    public static function getDocumentSize(BoundingBox $boundingBox):DocumentSize
    {
        $width  = $boundingBox->getWidth();
        $height = $boundingBox->getHeight();
        $size = new DocumentSize(100,100,'mm');
        if( $width > $height )
        {
            $needle = $width;
        }
        else
        {
            $needle = $height;
        }
        $ratio = ceil($needle / 100);
        if( $ratio >= 2 )
        {
            $size = new DocumentSize(100 * $ratio ,100 * $ratio,'mm');
        }
        return $size;
    }


    /**
     * SVG ドキュメントの座標軸に変換する
     *
     * @param Point $point
     * @param DocumentSize $documentSize
     * @return Point
     */
    public static function mappingDocumentPoint(Point $point,DocumentSize $documentSize):Point
    {
        $ret = new Point();
        $x = $point->getX() + $documentSize->getCenterX();
        $y = $documentSize->getCenterY() - $point->getY();
        $ret->setX($x);
        $ret->setY($y);
        return $ret;
    }

    /**
     * viewBox を取得する
     *
     * @param BoundingBox $boundingBox
     * @param DocumentSize $size
     * @return BoundingBox
     */
    public static function getViewBox(BoundingBox $boundingBox,DocumentSize $size):BoundingBox
    {
        $box = new BoundingBox();
        $point = self::mappingDocumentPoint($boundingBox->getStartPoint(),$size);
        $box->setStartPoint($point);
        $point = self::mappingDocumentPoint($boundingBox->getEndPoint(),$size);
        $box->setEndPoint($point);
        return $box;
    }

    /**
     * レイヤー名を CSS のクラス名に変換する
     * カンマ→アンダースコアに変換する
     *
     * @param string $name レイヤー名
     * @return string
     */
    public static function getLayerNameForCss($name):string
    {
        return str_replace('.','_' , $name);
    }


    /**
     *
     * @param string $name
     * @return array
     */
    public static function getMultiLayersForCss($name)
    {
        $ret = [];
        if( $name == '*.Cu' )
        {
            $ret[] = self::getLayerNameForCss('F.Cu');
            for($i = 1; $i <= 30 ; $i++ )
            {
                $ret[] = self::getLayerNameForCss('In' . $i . '.Cu');
            }
            $ret[] = self::getLayerNameForCss('B.Cu');
        }
        else if( $name == '*.Mask' )
        {
            $ret[] = self::getLayerNameForCss('F.Mask');
            $ret[] = self::getLayerNameForCss('B.Mask');
        }
        else
        {
            $ret[] = $name;
        }
        return $ret;
    }

}