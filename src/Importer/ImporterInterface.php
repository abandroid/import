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
    /**
     * @return array
     */
    public function getState(): array;

    /**
     * @return ProgressHandlerInterface
     */
    public function getProgressHandler(): ProgressHandlerInterface;

    /**
     * @param string $class
     *
     * @return ImporterInterface
     */
    public function setActiveLoader(string $class): ImporterInterface;

    /**
     * Starts the actual import.
     */
    public function import(): void;
}
