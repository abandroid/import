<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\ProgressHandler;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProgressBarProgressHandler implements ProgressHandlerInterface
{
    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var ProgressBar
     */
    protected $progressBar;

    /**
     * Creates a new instance.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * {@inheritdoc}
     */
    public function start($count = 0)
    {
        $this->progressBar = new ProgressBar($this->output, $count);
        $this->progressBar->setFormat($count == 0 ? '%current% [%bar%] %message%' : '%current%/%max% [%bar%] %message%');
        $this->progressBar->setBarCharacter('<fg=magenta>=</fg=magenta>');
        $this->progressBar->display();
    }

    /**
     * {@inheritdoc}
     */
    public function update($count)
    {
        $this->progressBar->clear();
        $this->progressBar->setProgress($count);
    }

    /**
     * {@inheritdoc}
     */
    public function increment($step = 1)
    {
        $this->progressBar->clear();
        $this->progressBar->advance($step);
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        $this->progressBar->clear();
        $this->progressBar->setMessage($message."\n");
        $this->progressBar->display();
    }

    /**
     * {@inheritdoc}
     */
    public function end()
    {
        $this->progressBar->finish();
        $this->output->writeln('');
    }
}
