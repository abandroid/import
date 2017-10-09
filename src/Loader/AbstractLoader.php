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
    /** @var ImporterInterface $importer */
    protected $importer;

    protected $progressHandler;
    protected $state;
    protected $isActive = true;

    public function setImporter(ImporterInterface $importer): void
    {
        $this->importer = $importer;
    }

    public function setProgressHandler(ProgressHandlerInterface $progressHandler): void
    {
        $this->progressHandler = $progressHandler;
    }

    public function setState(array &$state): void
    {
        $this->state = &$state;
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function deactivate(): void
    {
        $this->isActive = false;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    abstract public function initialize(): void;

    abstract public function load(): void;
}
