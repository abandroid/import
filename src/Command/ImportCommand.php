<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Command;

use Endroid\Import\Exception\LockException;
use Endroid\Import\Importer\Importer;
use Endroid\Import\ProgressHandler\ProgressBarProgressHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\LockHandler;

class ImportCommand extends Command
{
    /**
     * @var Importer
     */
    protected $importer;

    /**
     * @param string $name
     */
    public function __construct($name, Importer $importer)
    {
        parent::__construct($name);

        $this->importer = $importer;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lock = new LockHandler($this->getName());
        if (!$lock->lock()) {
            throw new LockException('Lock could not be obtained');
        }

        $progressHandler = new ProgressBarProgressHandler($input, $output);
        $this->importer->setProgressHandler($progressHandler);
        $this->importer->import();
    }

    /**
     * @return Importer
     */
    public function getImporter()
    {
        return $this->importer;
    }
}
