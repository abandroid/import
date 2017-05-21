<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Loader;

use Endroid\Import\Importer\Importer;

abstract class AbstractLoader
{
    /**
     * @var Importer
     */
    protected $importer;

    /**
     * @param Importer $importer
     * @return $this
     */
    public function setImporter(Importer $importer)
    {
        $this->importer = $importer;
    }

    /**
     * @return array
     */
    abstract function loadNext();
}
