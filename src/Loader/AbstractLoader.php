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
use Endroid\Import\State\State;

abstract class AbstractLoader implements LoaderInterface
{
    /**
     * @var Importer
     */
    protected $importer;

    /**
     * @var bool
     */
    protected $active = true;

    /**
     * @var State
     */
    protected $state;

    /**
     * @var ProgressHandlerInterface
     */
    protected $progressHandler;

    /**
     * {@inheritdoc}
     */
    public function setImporter(Importer $importer)
    {
        $this->importer = $importer;
        $this->state = $importer->getState();
        $this->progressHandler = $importer->getProgressHandler();
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    public function initialize()
    {
    }

    abstract public function load();
}
