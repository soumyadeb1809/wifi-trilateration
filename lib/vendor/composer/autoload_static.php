<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit534455c94e57a049b20f51a4fb306c2a
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tuupola\\' => 8,
        ),
        'S' => 
        array (
            'Symfony\\Component\\Process\\' => 26,
        ),
        'N' => 
        array (
            'Nubs\\Vectorix\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tuupola\\' => 
        array (
            0 => __DIR__ . '/..' . '/tuupola/trilateration/src',
        ),
        'Symfony\\Component\\Process\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/process',
        ),
        'Nubs\\Vectorix\\' => 
        array (
            0 => __DIR__ . '/..' . '/nubs/vectorix/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit534455c94e57a049b20f51a4fb306c2a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit534455c94e57a049b20f51a4fb306c2a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}