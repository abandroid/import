<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\State;

use Endroid\PropertyAccess\PropertyAccessor;

class State
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->data = [];
        $this->propertyAccessor = new PropertyAccessor();
    }

    /**
     * @param string $propertyPath
     * @return mixed
     */
    public function get($propertyPath)
    {
        return $this->propertyAccessor->getValue($this->data, $propertyPath);
    }

    /**
     * @param string $propertyPath
     * @param mixed $value
     */
    public function set($propertyPath, $value)
    {
        $this->propertyAccessor->setValue($this->data, $propertyPath, $value);
    }
}
