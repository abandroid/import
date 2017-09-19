<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Bundle\ImportBundle\Controller;

use Endroid\Import\Importer\Importer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends Controller
{
    /**
     * @Route("/{name}", name="endroid_import")
     * @Template()
     *
     * @param string $name
     *
     * @return Response
     */
    public function indexAction($name)
    {
        $importer = $this->getImporter($name);
        $importer->import();
    }

    /**
     * @param string $name
     *
     * @return Importer
     */
    protected function getImporter($name)
    {
        /** @var Importer $importer */
        $importer = $this->get('endroid_import.importer.'.$name);

        return $importer;
    }
}
