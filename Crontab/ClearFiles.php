<?php
/**
 * Created by PhpStorm.
 * User: sten
 */

 namespace Crontab;


 /**
  * Class ClearFiles
  * @package Excel
  */
class ClearFiles
{
    /**
     * Config constructor.
     */
    function __construct(Config $config)
    {
        $files = glob('%s*.xlsx', $config->getPath());
        foreach($files as $file) {
            if(is_file($file)) {
                unlink(file);
            }
        }
    }
}
