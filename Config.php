<?php
/**
 * Created by PhpStorm.
 * User: sten
 */

namespace Excel;


/**
 * Class Config
 * @package Excel
 */
class Config
{
    /**
     * @var string
     */
    private $path;

    /**
     * Config constructor.
     */
    function __construct()
    {
        $this->path = sprintf('%s/Files/', getcwd());
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Config
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
}