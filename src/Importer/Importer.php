<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Importer;

use Endroid\Import\Loader\AbstractLoader;
use Endroid\Import\ProgressHandler\NullProgressHandler;
use Endroid\Import\ProgressHandler\ProgressHandlerInterface;
use Endroid\Import\State;

class Importer
{
    /**
     * @var AbstractLoader[]
     */
    protected $loaders;

    /**
     * @var AbstractLoader
     */
    protected $activeLoader;

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

        foreach ($loaders as $loader) {
            $this->addLoader($loader);
        }

        $this->state = new State();
        $this->progressHandler = new NullProgressHandler();
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
        $this->loaders[$loader->getName()] = $loader;
        $loader->setImporter($this);

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setActiveLoader($name)
    {
        $this->activeLoader = $this->loaders[$name];
        $this->activeLoader->setActive(true);

        return $this;
    }

    /**
     * @return bool
     */
    public function hasActiveLoaders()
    {
        foreach ($this->loaders as $loader) {
            if ($loader->getActive()) {
                return true;
            }
        }

        return false;
    }

    public function ensureActiveLoader()
    {
        if ($this->activeLoader instanceof AbstractLoader && $this->activeLoader->getActive()) {
            return;
        }

        foreach ($this->loaders as $loader) {
            if ($loader->getActive()) {
                $this->activeLoader = $loader;
                return;
            }
        }
    }

    /**
     * Imports data from all loaders.
     */
    public function import()
    {
        $this->progressHandler->setMessage('Import started');

        $this->ensureActiveLoader();

        while ($this->hasActiveLoaders()) {
            while ($this->activeLoader->getActive()) {
                $data = $this->activeLoader->loadNext();
                if (!is_null($data)) {
                    $this->process($data);
                }
            }
            $this->ensureActiveLoader();
        }

        $this->progressHandler->setMessage('Import completed');
    }

    /**
     * @param array $data
     */
    protected function process(array $data)
    {

    }
}
