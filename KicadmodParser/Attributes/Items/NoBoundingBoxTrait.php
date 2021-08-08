<?php
namespace Hk\KicadmodParser\Attributes\Items;

use Hk\KicadmodParser\Geometry\BoundingBox;

/**
 * BoundingBox を持たない Attribute 用 Trait
 *
 */
trait NoBoundingBoxTrait
{

    /**
     * @return bool
     */
    public function hasBoundingBox(): bool
    {
        return FALSE;
    }

    /**
     * @return BoundingBox
     */
    public function getBoundingBox(): BoundingBox
    {
        return new BoundingBox();
    }
}