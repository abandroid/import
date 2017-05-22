<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Bundle\ImportDemoBundle\Loader;

use Endroid\Import\Loader\AbstractLoader;
use XmlIterator\XmlIterator;

class WebsiteProductLoader extends AbstractLoader
{
    /**
     * @var XmlIterator
     */
    protected $iterator;

    /**
     * {@inheritdoc}
     */
    public function loadNext()
    {
        $this->ensureIterator();

        if (!$this->iterator->valid()) {
            return null;
        }

        $item = $this->iterator->current();
        $this->iterator->next();

        return $item;
    }

    /**
     * Ensures that the iterator exists.
     */
    protected function ensureIterator()
    {
        if ($this->iterator instanceof XmlIterator) {
            return;
        }

        $this->iterator = new XmlIterator(__DIR__.'/../Resources/data/website_product_data.xml', 'product');
        $this->iterator->rewind();
    }
}
