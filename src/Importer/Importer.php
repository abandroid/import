<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Importer;

use Endroid\Import\Loader\AbstractLoader;
use Endroid\Import\ProgressHandler\ProgressHandlerInterface;
use Endroid\Import\State;

class Importer
{
    /**
     * @var AbstractLoader[]
     */
    protected $loaders;

    /**
     * @var State
     */
    protected $state;

    /**
     * @var ProgressHandlerInterface
     */
    protected $progressHandler;

    /**
     * @param AbstractLoader[] $loaders
     */
    public function __construct(array $loaders = [])
    {
        $this->loaders = [];
        $this->state = new State();

        foreach ($loaders as $loader) {
            $this->addLoader($loader);
        }
    }

    /**
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param ProgressHandlerInterface $progressHandler
     * @return $this
     */
    public function setProgressHandler(ProgressHandlerInterface $progressHandler)
    {
        $this->progressHandler = $progressHandler;

        return $this;
    }

    /**
     * @return ProgressHandlerInterface
     */
    public function getProgressHandler()
    {
        return $this->progressHandler;
    }

    /**
     * @param AbstractLoader $loader
     * @return $this
     */
    public function addLoader(AbstractLoader $loader)
    {
        $this->loaders[get_class($loader)] = $loader;
        $loader->setImporter($this);

        return $this;
    }

    /**
     * Imports data from all loaders.
     */
    public function import()
    {
        foreach ($this->loaders as $loader) {
            while ($data = $loader->loadNext()) {

            }
        }
    }
}
