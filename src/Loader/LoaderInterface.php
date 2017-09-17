<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Loader;

use Endroid\Import\Importer\ImporterInterface;

interface LoaderInterface
{
    /**
     * The loader needs to know the importer to be able to
     * pass control to another loader. The importer also
     * passes the global state and progress handler.
     *
     * @param ImporterInterface $importer
     * @return $this
     */
    public function setImporter(ImporterInterface $importer);

    /**
     * Returns the active state.
     *
     * @return bool
     */
    public function getActive();

    /**
     * Sets the active state. When set to inactive this loader
     * will be ignored by the importer.
     *
     * @param bool $active
     * @return $this
     */
    public function setActive($active);

    /**
     * Prepares the loader so it can be used. Try to keep the
     * footprint of this method as small as possible as it is
     * even executed when the load method is never called.
     */
    public function initialize();

    /**
     * Loads data from a data source and adds all necessary
     * data to the state. Might include some pre-processing.
     */
    public function load();
}
