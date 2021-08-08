<?php
namespace Hk\KicadmodParser\Geometry;

/**
 * Point
 */
class Point
{
    /**
     * X 座標
     * @var float
     */
    protected $x;

    /**
     * Y 座標
     * @var float
     */
    protected $y;

    /**
     * コンストラクタ
     * @param int $x
     * @param int $y
     */
    public function __construct($x = 0,$y = 0)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * X 座標 をセットする
     * @param float $x
     */
    public function setX($x): void
    {
        $this->x = $x;
    }

    /**
     * X 座標 を取得する
     * @return float
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Y 座標 をセットする
     * @param float $y
     */
    public function setY($y): void
    {
        $this->y = $y;
    }

    /**
     * Y 座標 を取得する
     * @return float
     */
    public function getY()
    {
        return $this->y;
    }
}