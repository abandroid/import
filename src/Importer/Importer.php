<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Importer;

use Endroid\Import\Loader\LoaderInterface;
use Endroid\Import\ProgressHandler\NullProgressHandler;
use Endroid\Import\ProgressHandler\ProgressHandlerInterface;

class Importer implements ImporterInterface
{
    /**
     * @var LoaderInterface[]
     */
    protected $loaders;

    /**
     * @var LoaderInterface
     */
    protected $activeLoader;

    /**
     * @var array
     */
    protected $state;

    /**
     * @var ProgressHandlerInterface
     */
    protected $progressHandler;

    /**
     * @param LoaderInterface[] $loaders
     */
    public function __construct(array $loaders = [])
    {
        $this->loaders = [];
        $this->state = [];
        $this->progressHandler = new NullProgressHandler();

        foreach ($loaders as $loader) {
            $this->addLoader($loader);
        }
    }

    /**
     * @param LoaderInterface $loader
     *
     * @return $this
     */
    public function addLoader(LoaderInterface $loader)
    {
        $this->loaders[get_class($loader)] = $loader;
        $loader->setImporter($this);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function &getState(): array
    {
        return $this->state;
    }

    /**
     * @param ProgressHandlerInterface $progressHandler
     *
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
    public function getProgressHandler(): ProgressHandlerInterface
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
     * {@inheritdoc}
     */
    public function setActiveLoader(string $class): ImporterInterface
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
    public function import(): void
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
        if ($this->activeLoader instanceof LoaderInterface && $this->activeLoader->getActive()) {
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
