<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Bundle\ImportDemoBundle\Command;

use DOMDocument;
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
            ->setName('importer:demo:generate-data')
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

        $products = $this->createProducts();

        $this->generateProductCollectionData($products);
        $this->generateWebsiteProductData($products);
        $this->generateMobileProductData($products);
    }

    /**
     * @return array
     */
    protected function createProducts()
    {
        $products = [];
        for ($n = 1; $n <= 100000; $n++) {
            $product = [
                'id' => $n,
                'label' => 'Product '.$n,
                'url' => 'http://endroid.nl/product-'.$n,
                'phone' => '0600000000'
            ];
            $products[] = $product;
        }

        return $products;
    }

    /**
     * @param array $products
     */
    protected function generateProductCollectionData(array $products)
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
        $productsXml = $xml->createElement('products');
        $xml->appendChild($productsXml);

        foreach ($products as $product) {
            $productXml = $xml->createElement('product');
            $productXml->appendChild($xml->createElement('id', $product['id']));
            $productXml->appendChild($xml->createElement('label', $product['label']));
            $productsXml->appendChild($productXml);
        }

        $xmlString = $xml->saveXML();

        file_put_contents(__DIR__.'/../Resources/data/product_collection_data.xml', $xmlString);
    }

    /**
     * @param array $products
     */
    protected function generateWebsiteProductData(array $products)
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
        $productsXml = $xml->createElement('products');
        $xml->appendChild($productsXml);

        foreach ($products as $product) {
            $productXml = $xml->createElement('product');
            $productXml->appendChild($xml->createElement('id', $product['id']));
            $productXml->appendChild($xml->createElement('url', $product['url']));
            $productsXml->appendChild($productXml);
        }

        $xmlString = $xml->saveXML();

        file_put_contents(__DIR__.'/../Resources/data/website_product_data.xml', $xmlString);
    }

    /**
     * @param array $products
     */
    protected function generateMobileProductData(array $products)
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
        $productsXml = $xml->createElement('products');
        $xml->appendChild($productsXml);

        foreach ($products as $product) {
            $productXml = $xml->createElement('product');
            $productXml->appendChild($xml->createElement('id', $product['id']));
            $productXml->appendChild($xml->createElement('phone', $product['phone']));
            $productsXml->appendChild($productXml);
        }

        $xmlString = $xml->saveXML();

        file_put_contents(__DIR__.'/../Resources/data/mobile_product_data.xml', $xmlString);
    }
}
