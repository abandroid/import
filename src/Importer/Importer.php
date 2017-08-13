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
use Endroid\Import\State\State;

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
        $this->state = new State();
        $this->progressHandler = new NullProgressHandler();

        foreach ($loaders as $loader) {
            $this->addLoader($loader);
        }
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
     * @param int $timeLimit
     *
     * @return $this
     */
    public function setTimeLimit($timeLimit)
    {
        set_time_limit($timeLimit);

        return $this;
    }

    /**
     * @param string $memoryLimit
     *
     * @return $this
     */
    public function setMemoryLimit($memoryLimit)
    {
        ini_set('memory_limit', $memoryLimit);

        return $this;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function setActiveLoader($class)
    {
        $this->activeLoader = $this->loaders[$class];
        $this->activeLoader->setActive(true);

        return $this;
    }

    public function setCompleted()
    {
        foreach ($this->loaders as $loader) {
            $loader->setActive(false);
        }
    }

    /**
     * Imports data from all loaders.
     */
    public function import()
    {
        $this->progressHandler->start();
        $this->progressHandler->setMessage('Import started');

        $this->initializeLoaders();
        $this->ensureActiveLoader();

        while ($this->hasActiveLoaders()) {
            while ($this->activeLoader->getActive()) {
                $this->activeLoader->load();
            }
            $this->ensureActiveLoader();
        }

        $this->progressHandler->setMessage('Import completed');
    }

    protected function initializeLoaders()
    {
        foreach ($this->loaders as $loader) {
            $loader->initialize();
        }
    }

    protected function ensureActiveLoader()
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

    /**
     * @param array $data
     */
    protected function process(array $data)
    {
    }
}
