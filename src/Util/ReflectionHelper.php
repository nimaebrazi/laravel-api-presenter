<?php


namespace LaravelApiPresenter\Util;


/**
 * Class ReflectionHelper
 * @package LaravelApiPresenter\Util
 */
class ReflectionHelper
{
    /**
     * @param $object
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function getProProperties($object)
    {
        $class = new \ReflectionClass($object);
        $properties = $class->getProperties();

        return self::getArrayOfProperties($object, $properties);

    }

    /**
     * @param $object
     * @param $properties
     * @return array
     */
    protected static function getArrayOfProperties($object, $properties): array
    {
        $all = [];

        /** @var \ReflectionProperty  $property */
        foreach ($properties as $property) {

            $property->setAccessible(true);

            $propertyValue = $property->getValue($object);
            if (!empty($propertyValue) || !is_null($propertyValue)) {

                $snakeCaseProProperty = \Str::snake($property->getName());
                $all[$snakeCaseProProperty] = $property->getValue($object);
            }
        }

        return $all;
    }
}