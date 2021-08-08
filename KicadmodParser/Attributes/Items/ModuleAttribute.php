<?php
namespace Hk\KicadmodParser\Attributes\Items;

use Hk\KicadmodParser\Attributes\Attribute;

class ModuleAttribute extends Attribute
{
    use NoBoundingBoxTrait;

    const NODE_NAME = 'module';

    /**
     * ModuleAttribute constructor.
     *
     * @param array $parameters
     */
    public function __construct($parameters)
    {
        parent::__construct(self::NODE_NAME,$parameters);
    }

    public function getModuleName()
    {
        return $this->parameters[0];
    }
}