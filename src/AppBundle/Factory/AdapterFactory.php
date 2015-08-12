<?php

namespace AppBundle\Factory;

use AppBundle\Entity\Api;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;
use AppBundle\Model\Constants;
use AppBundle\Interfaces\AdapterInterface;

/**
 * Class AdapterFactory
 *
 * @package AppBundle\Factory
 */
class AdapterFactory
{

    /**
     * Creates the apis adapter class
     *
     * @param Api $api
     * @param bool|true $is_api
     *
     * @return AdapterInterface
     */
    public static function make(Api $api, $is_api = true)
    {
        $info = explode(' ', $api->getName());

        if ($is_api) {
            $namespace = 'AppBundle\Adapter\Api\%s\%s\Adapter';
        }
        else
        {
            $namespace = 'AppBundle\Adapter\%s\%s\Adapter';
        }

        $adapterClass = sprintf(
            $namespace,
            $info[0],
            $info[1]
        );

        if (!class_exists($adapterClass))
        {
            throw new InvalidArgumentException('Adapter class: '. $adapterClass .'does not exist');
        }
        if (is_null($api->getKey()))
        {
            return new $adapterClass();
        }

        return new $adapterClass([Constants::GOOGLE_BOOKS_LABEL_API_KEY => $api->getKey()]);
    }

}