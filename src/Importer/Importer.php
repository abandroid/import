<?php

declare(strict_types=1);

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
    protected $loaders;
    protected $state;
    protected $progressHandler;

    public function __construct(array $loaders = [])
    {
        $this->loaders = [];
        $this->state = [];
        $this->progressHandler = new NullProgressHandler();

        foreach ($loaders as $loader) {
            $this->addLoader($loader);
        }
    }

    public function addLoader(LoaderInterface $loader): void
    {
        $this->loaders[get_class($loader)] = $loader;
        $loader->setImporter($this);
        $loader->setProgressHandler($this->progressHandler);
        $loader->setState($this->state);
    }

    public function setProgressHandler(ProgressHandlerInterface $progressHandler): void
    {
        $this->progressHandler = $progressHandler;

        foreach ($this->loaders as $loader) {
            $loader->setProgressHandler($progressHandler);
        }
    }

    public function setActiveLoader(string $class): void
    {
        $loader = $this->loaders[$class];
        unset($this->loaders[$class]);

        // Set the active loader as the first loader to run
        $this->loaders = [$class => $loader] + $this->loaders;

        $loader->activate();
    }

    public function import(): void
    {
        $this->progressHandler->start();
        $this->progressHandler->setMessage('Import started');

        foreach ($this->loaders as $loader) {
            $loader->initialize();
        }

        $activeLoader = $this->getActiveLoader();
        while ($activeLoader instanceof LoaderInterface) {
            while ($activeLoader->isActive()) {
                $activeLoader->load();
            }
            $activeLoader = $this->getActiveLoader();
        }

        $this->progressHandler->setMessage('Import completed');
    }

    protected function getActiveLoader(): ?LoaderInterface
    {
        foreach ($this->loaders as $loader) {
            if ($loader->isActive()) {
                return $loader;
            }
        }

        return null;
    }

    public function setCompleted(): void
    {
        foreach ($this->loaders as $loader) {
            $loader->deactivate();
        }
    }

    public abstract function getName(): string;
}
