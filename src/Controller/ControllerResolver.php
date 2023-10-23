<?php 

declare(strict_types=1);

namespace App\Controller;

use App\Request;

class ControllerResolver 
{
    protected const DEFAULT_ENTITY = 'Client';

    public static function resolve (Request $request): string
    {
        $entity = $request->getParam('entity', self::DEFAULT_ENTITY);
        $controller = $entity . "Controller";

        return $controller;
    }

}