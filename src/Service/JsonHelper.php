<?php

namespace App\Service;

class JsonHelper
{
    public static function serialize(array $items): array
    {
        $data = [];
        foreach ($items as $item) {
            $data[] = $item->jsonSerialize();
        }

        return $data;
    }
}
