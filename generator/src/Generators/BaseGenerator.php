<?php

namespace Delosfei\Generator\Generators;

use Delosfei\Generator\Utils\FileUtil;
use Illuminate\Support\Str;

class BaseGenerator
{
    public function rollbackFile($path, $fileName, $info = null)
    {
        if (file_exists($path.$fileName)) {
            FileUtil::deleteFile($path, $fileName);
            $path = Str::after($path, base_path());

            return ('- '.$path.$fileName.$info);
        }

        return false;
    }


    public function createFileAndShowInfo($path, $fileName, $templateData, $info = null)
    {
        FileUtil::createFile($path, $fileName, $templateData);
        $path = Str::after($path, base_path());

        return ('+ '.$path.$fileName.$info);
    }


}
