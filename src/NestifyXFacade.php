<?php

namespace CodeAxion\NestifyX;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CodeAxion\NestifyX\Skeleton\SkeletonClass
 */
class NestifyXFacade extends Facade
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
