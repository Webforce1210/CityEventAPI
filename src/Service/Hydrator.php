<?php

namespace App\Service;

class Hydrator
{
    /**
     * Hydrate une entité et la retourne.
     *
     * @param mixed $entity
     *
     * @return mixed
     */
    public static function hydrate(array $data, $entity)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            if (str_contains($method, 'Date') || str_contains($method, 'Heure')) {
                $entity->$method(new \DateTime($value));
            } else {
                $entity->$method($value);
            }
        }

        return $entity;
    }
}
