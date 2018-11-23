<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Loader;

use Endroid\Import\Importer\ImporterInterface;
use Endroid\Import\ProgressHandler\ProgressHandlerInterface;

interface LoaderInterface
{
    public function setImporter(ImporterInterface $importer): void;

    public function setProgressHandler(ProgressHandlerInterface $progressHandler): void;

    public function setState(array &$state): void;

    public function activate(): void;

    public function deactivate(): void;

    public function isActive(): bool;

    public function initialize(): void;

    public function load(): void;
}
