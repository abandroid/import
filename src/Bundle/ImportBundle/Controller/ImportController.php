<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Bundle\ImportBundle\Controller;

use Endroid\Import\Importer\ImporterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends Controller
{
    /**
     * @Route("/{name}", name="endroid_import")
     */
    public function indexAction(string $name): Response
    {
        $importer = $this->getImporter($name);
        $importer->import();

        return new Response('Done');
    }

    protected function getImporter($name): ImporterInterface
    {
        return $this->get('endroid_import.importer.'.$name);
    }
}
