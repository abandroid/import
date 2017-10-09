<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Importer;

use Endroid\Import\ProgressHandler\ProgressHandlerInterface;

interface ImporterInterface
{
    public function setProgressHandler(ProgressHandlerInterface $progressHandler): void;

    public function setActiveLoader(string $class): void;

    public function import(): void;
}
