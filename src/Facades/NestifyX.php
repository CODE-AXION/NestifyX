<?php

namespace CodeAxion\NestifyX\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CodeAxion\NestifyX\Skeleton\SkeletonClass
 */
class NestifyX extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nestifyx';
    }
}
