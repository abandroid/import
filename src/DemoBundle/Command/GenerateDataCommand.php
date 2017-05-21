<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\DemoBundle\Command;

use Endroid\Import\Exception\LockException;
use Endroid\Import\ProgressHandler\ProgressBarProgressHandler;
use Endroid\Import\ProgressHandler\ProgressHandlerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\LockHandler;

class GenerateDataCommand extends Command
{
    /**
     * @var ProgressHandlerInterface
     */
    protected $progressHandler;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('import:demo:generate-data')
            ->setDescription('Generate demo data');
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

        $this->progressHandler = new ProgressBarProgressHandler($input, $output);
    }
}
