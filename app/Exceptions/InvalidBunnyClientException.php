<?php

namespace App\Exceptions;

use Exception;

class InvalidBunnyClientException extends Exception
{
    /**

     * Get the exception's context information.

     *

     * @return array<string, mixed>

     */

    public function context(): array

    {

        return ['additional_message' => 'Error setting up the Bunny client'];

    }
}
