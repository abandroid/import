<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Bundle\ImportDemoBundle\Command;

use DOMDocument;
use DOMElement;
use Endroid\Import\Exception\LockException;
use Endroid\Import\ProgressHandler\ProgressBarProgressHandler;
use Endroid\Import\ProgressHandler\ProgressHandlerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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
     * @var array
     */
    protected $counts = [
        'location' => 50000,
        'office' => 50000,
        'employee' => 50000
    ];

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('endroid:import:generate-demo-data')
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

        $this->generateGenericXml('location');
        $this->generateGenericXml('office');
        $this->generateGenericXml('employee');
    }

    /**
     * @param string $name
     * @return array
     */
    protected function generateGenericXml($name)
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        $document->formatOutput = true;
        $collection = $document->createElement($name.'s');
        $document->appendChild($collection);

        for ($n = 1; $n <= $this->counts[$name]; $n++) {
            $element = $document->createElement($name);
            $element->appendChild($document->createElement('id', $n));
            $element->appendChild($document->createElement('label', ucfirst($name).' '.$n));
            if (method_exists($this, 'add'.ucfirst($name).'Fields')) {
                $this->{'add'.ucfirst($name).'Fields'}($element, $document);
            }
            $collection->appendChild($element);
        }

        $xmlString = $document->saveXML();

        file_put_contents(__DIR__.'/../Resources/data/'.$name.'s.xml', $xmlString);
    }

    /**
     * @param DOMElement $element
     * @param DOMDocument $document
     */
    protected function addOfficeFields(DOMElement $element, DomDocument $document)
    {
        $element->appendChild($document->createElement('location_id', rand(1, $this->counts['location'])));
    }

    /**
     * @param DOMElement $element
     * @param DOMDocument $document
     */
    protected function addEmployeeFields(DOMElement $element, DomDocument $document)
    {
        $element->appendChild($document->createElement('location_id', rand(1, $this->counts['location'])));
        $element->appendChild($document->createElement('office_id', rand(1, $this->counts['office'])));
    }
}
