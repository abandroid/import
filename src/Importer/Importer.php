<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Importer;

use Endroid\Import\Loader\LoaderInterface;
use Endroid\Import\ProgressHandler\ProgressHandlerInterface;
use Endroid\Import\State;

class Importer
{
    /**
     * @var State
     */
    protected $state;

    /**
     * @var LoaderInterface[]
     */
    protected $loaders;

    /**
     * @var ProgressHandlerInterface
     */
    protected $progressHandler;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->loaders = [];
    }

    /**
     * @param LoaderInterface $loader
     * @return $this
     */
    public function addLoader(LoaderInterface $loader)
    {
        $this->loaders[get_class($loader)] = $loader;
        $loader->setImporter($this);
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
