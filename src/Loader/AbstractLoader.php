<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Loader;

use Endroid\Import\Importer\ImporterInterface;
use Endroid\Import\ProgressHandler\ProgressHandlerInterface;

abstract class AbstractLoader implements LoaderInterface
{
    /**
     * @var ImporterInterface
     */
    protected $importer;

    /**
     * @var bool
     */
    protected $active = true;

    /**
     * @var array
     */
    protected $state;

    /**
     * @var ProgressHandlerInterface
     */
    protected $progressHandler;

    /**
     * {@inheritdoc}
     */
    public function setImporter(ImporterInterface $importer)
    {
        $this->importer = $importer;
        $this->progressHandler = $importer->getProgressHandler();

        // The state is not an object so we need to explicitly reference
        $this->state = &$importer->getState();
    }

    /**
     * {@inheritdoc}
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * {@inheritdoc}
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        // Does nothing by default
        // Not required to run the import
    }

    /**
     * {@inheritdoc}
     */
    abstract public function load();
}
