<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Loader;

use Endroid\Import\Importer\Importer;
use Endroid\Import\ProgressHandler\ProgressHandlerInterface;
use Endroid\Import\State;

abstract class AbstractLoader
{
    /**
     * @var Importer
     */
    protected $importer;

    /**
     * @var State
     */
    protected $state;

    /**
     * @var ProgressHandlerInterface
     */
    protected $progressHandler;

    /**
     * @param Importer $importer
     * @return $this
     */
    public function setImporter(Importer $importer)
    {
        $this->importer = $importer;
        $this->state = $importer->getState();
        $this->progressHandler = $importer->getProgressHandler();
    }

    /**
     * @return array
     */
    abstract public function loadNext();
}
