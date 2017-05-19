<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Bundle\Controller;

use Endroid\Guide\Guide;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends Controller
{
    /**
     * @Route("/", name="endroid_import_index")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        return [

        ];
    }
}
