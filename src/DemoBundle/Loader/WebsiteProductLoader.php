<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\DemoBundle\Loader;

use Endroid\Import\Loader\AbstractLoader;

class WebsiteProductLoader extends AbstractLoader
{
    /**
     * {@inheritdoc}
     */
    function loadNext()
    {
        return [];
    }
}
