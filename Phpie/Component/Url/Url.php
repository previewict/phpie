<?php

namespace Phpie\Component\Url;

class Url
{
    public function getSubdomain($domain = null)
    {
        if(empty($domain)){
            return false;
        }

        if(isset($domain))
        {
            return $domain;
        }
        return true;
    }
}