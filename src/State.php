<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import;

class State
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->data = [];
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->data[$key];
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }
}