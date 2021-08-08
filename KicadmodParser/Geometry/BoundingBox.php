<?php
namespace Hk\KicadmodParser\Geometry;

use Hk\KicadmodParser\Geometry\DocumentSize;
use Hk\KicadmodParser\Geometry\Point;

/**
 * BoundingBox
 */
class BoundingBox extends Rectangle
{
    /**
     * 開始点から終了点までの領域から 最大のバウンディングボックスを更新する
     *
     * @param Point $startPoint 開始点
     * @param Point $endPoint 終了点
     */
    public function fittingRegion(Point $startPoint,Point $endPoint):void
    {
        if( $startPoint->getX() <= $endPoint->getX() )
        {
            if( $this->x1 > $startPoint->getX() )
            {
                $this->x1 = $startPoint->getX();
            }
            if( $this->x2 < $endPoint->getX() )
            {
                $this->x2 = $endPoint->getX();
            }
        }
        else
        {
            if( $this->x1 > $endPoint->getX() )
            {
                $this->x1 = $endPoint->getX();
            }
            if( $this->x2 < $startPoint->getX() )
            {
                $this->x2 = $startPoint->getX();
            }
        }
        if( $startPoint->getY() >= $endPoint->getY() )
        {
            if( $this->y1 < $startPoint->getY() )
            {
                $this->y1 = $startPoint->getY();
            }
            if( $this->y2 > $endPoint->getY() )
            {
                $this->y2 = $endPoint->getY();
            }
        }
        else
        {
            if( $this->y1 < $endPoint->getY() )
            {
                $this->y1 = $endPoint->getY();
            }
            if( $this->y2 > $startPoint->getY() )
            {
                $this->y2 = $startPoint->getY();
            }
        }
    }

    /**
     * 幅、高さ で大きいほうの値を取得する
     * @return float
     */
    public function getMaximumValue():float
    {
        $width = $this->getWidth();
        $height = $this->getHeight();
        if( $width > $height )
        {
            $ret = $width;
        }
        else
        {
            $ret = $height;
        }
        return $ret;
    }

    /**
     * SVG フォーマット用の文字列を取得する
     *
     * @return string
     */
    public function getStringForSvg():string
    {
        return '' . $this->x1 . ',' . $this->y1 . ',' . $this->x2 . ',' . $this->y2;
    }

    /**
     * SVG の viewBox [minX,minY,width,height] 形式で取得する
     *
     * @return string
     */
    public function getViewBox():string
    {
        return '' . $this->x1 . ',' . $this->y1 . ',' . ($this->x2-$this->x1) . ',' . ($this->y2 - $this->y1);
    }

}