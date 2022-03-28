<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit771a1254d3ef37ec7cff32bbbdb3d24c
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit771a1254d3ef37ec7cff32bbbdb3d24c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit771a1254d3ef37ec7cff32bbbdb3d24c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit771a1254d3ef37ec7cff32bbbdb3d24c::$classMap;

        }, null, ClassLoader::class);
    }
}