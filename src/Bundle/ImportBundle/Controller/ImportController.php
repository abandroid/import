<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Bundle\ImportBundle\Controller;

use Endroid\Import\Command\AbstractImportCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends Controller
{
    /**
     * @Route("/{name}", name="endroid_import")
     * @Template()
     *
     * @param string $name
     * @return Response
     */
    public function indexAction($name)
    {
        $kernel = $this->get('kernel');

        $application = new Application($kernel);

        /** @var AbstractImportCommand $command */
        $command = $application->find('importer:run:'.$name);

        $importer = $command->getImporter();
        $importer->import();
    }
}
