<?php
namespace Hk\KicadmodParser\Geometry;

use Hk\KicadmodParser\Geometry\Point;

/**
 *
 */
class Rectangle
{
    /**
     * 開始点 (X座標)
     * @var float
     */
    protected $x1;

    /**
     * 開始点 (Y座標)
     * @var float
     */
    protected $y1;

    /**
     * 終了点 (X座標)
     * @var float
     */
    protected $x2;

    /**
     * 終了点 (Y座標)
     * @var float
     */
    protected $y2;

    /**
     * コンストラクタ
     *
     * @param float $x1 開始点 (X座標)
     * @param float $y1 開始点 (Y座標)
     * @param float $x2 終了点 (X座標)
     * @param float $y2 終了点 (Y座標)
     */
    public function __construct($x1=0,$y1=0,$x2=0,$y2=0)
    {
        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x2;
        $this->y2 = $y2;
    }

    /**
     * 幅を取得する
     * @return int
     */
    public function getWidth():int
    {
        return (int )abs($this->x2 - $this->x1);
    }

    /**
     * 高さを取得する
     * @return int
     */
    public function getHeight():int
    {
        return (int )abs($this->y1 - $this->y2);
    }

    /**
     * 開始点 を取得する
     * @return Point
     */
    public function getStartPoint():Point
    {
        return new Point($this->x1,$this->y1);
    }

    /**
     * 開始点 をセットする
     * @param Point $point
     */
    public function setStartPoint($point):void
    {
        $this->x1 = $point->getX();
        $this->y1 = $point->getY();
    }

    /**
     * 終了点 を取得する
     * @return Point
     */
    public function getEndPoint():Point
    {
        return new Point($this->x2,$this->y2);
    }

    /**
     * 終了点 をセットする
     * @param Point $point
     */
    public function setEndPoint($point):void
    {
        $this->x2 = $point->getX();
        $this->y2 = $point->getY();
    }
}