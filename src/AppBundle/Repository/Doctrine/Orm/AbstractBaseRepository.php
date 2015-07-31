<?php
/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/31/2015
 * Time: 10:04 AM
 */

namespace AppBundle\Repository\Doctrine\Orm;

use Doctrine\ORM\EntityRepository;

abstract class AbstractBaseRepository extends EntityRepository
{
    /**
     * @param object $entity
     * @param bool   $sync
     *
     * @return int
     */
    public function update($entity, $sync = true)
    {
        return $this->add($entity, $sync);
    }
    /**
     * @param object $entity
     * @param bool   $sync
     *
     * @return int
     */
    public function add($entity, $sync = true)
    {
        $this->_em->persist($entity);
        if ($sync === true) {
            $this->_em->flush();
        }
        return $entity->getId();
    }
    /**
     * @param object $entity
     * @param bool   $sync
     */
    public function remove($entity, $sync = true)
    {
        $this->_em->remove($entity);
        if ($sync === true) {
            $this->_em->flush();
        }
    }
}