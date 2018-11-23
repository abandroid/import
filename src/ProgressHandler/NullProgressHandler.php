<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\ProgressHandler;

class NullProgressHandler implements ProgressHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function start($count = 0)
    {
        // do nothing
    }

    /**
     * {@inheritdoc}
     */
    public function update($count)
    {
        // inhibit
    }

    /**
     * {@inheritdoc}
     */
    public function increment($step = 1)
    {
        // act busy
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        // nothing to see here
    }

    /**
     * {@inheritdoc}
     */
    public function end()
    {
        // void
    }
}
