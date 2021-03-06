<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc8cb9aa06bc20ccd41d5b99cd38eb854
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DG2\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DG2\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc8cb9aa06bc20ccd41d5b99cd38eb854::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc8cb9aa06bc20ccd41d5b99cd38eb854::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc8cb9aa06bc20ccd41d5b99cd38eb854::$classMap;

        }, null, ClassLoader::class);
    }
}
