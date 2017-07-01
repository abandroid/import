<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\State;

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
     * @param string $path
     * @return mixed
     */
    public function get($path)
    {
        $parts = explode('.', $path);
        $element = $this->data;
        foreach ($parts as $part) {
            if (!isset($element[$part])) {
                return null;
            }
            $element = $element[$part];
        }

        return $element;
    }

    /**
     * @param string $path
     * @param mixed $value
     */
    public function set($path, $value)
    {
        $parts = explode('.', $path);
        $key = array_pop($parts);
        $element = &$this->data;
        foreach ($parts as $part) {
            if (!isset($element[$part]) || !is_array($element[$part])) {
                $element[$part] = [];
                $element = &$element[$part];
            }
        }

        $element[$key] = $value;
    }
}
