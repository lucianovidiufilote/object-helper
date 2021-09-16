<?php


namespace LucianOvidiuFilote\ObjectHelper;

/**
 * Class ObjectHelper
 */
class ObjectHelper
{
    /**
     * Class casting
     *
     * @param $object
     * @return array
     */
    public static function toArray($object)
    {
        $public = [];

        $reflection = new \ReflectionClass(get_class($object));

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);

            $value = $property->getValue($object);
            $name = $property->getName();

            if (is_array($value)) {
                $public[$name] = [];

                foreach ($value as $item) {
                    if (is_object($item)) {
                        $itemArray = self::toArray($item);
                        $public[$name][] = $itemArray;
                    } else {
                        $public[$name][] = $item;
                    }
                }
            } else if (is_object($value)) {
                $public[$name] = self::toArray($value);
            } else $public[$name] = $value;
        }

        return $public;
    }
}
