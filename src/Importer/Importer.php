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
     * @var State
     */
    protected $state;

    /**
     * @var AbstractLoader[]
     */
    protected $loaders;

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
                dump($data);
                die;
            }
        }
    }
}
