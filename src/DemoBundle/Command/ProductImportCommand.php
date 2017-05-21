<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\DemoBundle\Command;

use Exception;
use ImportBundle\Importer\Importer;
use ImportBundle\ProgressHandler\ProgressBarProgressHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\LockHandler;

class ProductImportCommand extends Command
{


    /**
     * Creates a new instance.
     *
     * @param Importer $importer
     */
    public function __construct(Importer $importer)
    {
        parent::__construct('import');

        $this->importer = $importer;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('import:import')
            ->setDescription('Runs the import')
            ->setDefinition(array(
                new InputOption(
                    'force', 'f', InputOption::VALUE_NONE,
                    'Causes the import to be physically executed.'
                ),
            ));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lock = new LockHandler($this->getName());
        if (!$lock->lock()) {
            throw new Exception('Lock could not be obtained');
        }

        $this->input = $input;
        $this->output = $output;

        $this->importer->setProgressHandler(new ProgressBarProgressHandler($input, $output));
        $this->importer->import();
    }
}
