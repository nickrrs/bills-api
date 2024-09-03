<?php

namespace App\Traits;

trait FillableFromArray
{
    public function fillFromArray(array $data, array $existingData = []): void
    {
        foreach (get_object_vars($this) as $propertyName => $value) {
            $this->$propertyName = $data[$propertyName] ?? $existingData[$propertyName] ?? $value;
        }
    }
}
