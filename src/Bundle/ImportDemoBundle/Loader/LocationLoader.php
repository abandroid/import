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

class LocationLoader extends AbstractLoader
{
    /**
     * @var XmlIterator
     */
    protected $iterator;

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        $this->ensureIterator();

        if (!$this->iterator->valid()) {
            $this->setActive(false);
            return null;
        }

        $item = $this->iterator->current();
        $this->iterator->next();

        $this->importer->setActiveLoader(EmployeeLoader::class);

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

        $this->iterator = new XmlIterator(__DIR__.'/../Resources/data/locations.xml', 'location');
        $this->iterator->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'location_loader';
    }
}
