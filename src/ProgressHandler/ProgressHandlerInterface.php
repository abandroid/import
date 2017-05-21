<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\ProgressHandler;

interface ProgressHandlerInterface
{
    /**
     * Starts the progress.
     *
     * @param $count
     */
    public function start($count = 0);

    /**
     * Updates the progress.
     *
     * @param $count
     */
    public function update($count);

    /**
     * Increments the progress.
     *
     * @param int $step
     */
    public function increment($step = 1);

    /**
     * Sets the message.
     *
     * @param $message
     */
    public function setMessage($message);

    /**
     * Ends the progress.
     */
    public function end();
}
