<?php

namespace StorePHP\Bundler\Compiling;

use Illuminate\Support\Facades\Cache;
use StorePHP\Bundler\Lib\ACL;

class ACLCompile
{
    public $count = 0;

    public function __construct(
        protected $cachePrefix = null,
    ) {
    }

    public function merge($paths)
    {
        $outACLs = [];

        foreach ($paths as $id => $path) {
            $pathACLFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'acl.php';

            if (file_exists($pathACLFile)) {
                $acl = new ACL;
                $pathACLFile = require $pathACLFile;
                $pathACLFile = new $pathACLFile;
                $pathACLFile->permissions($acl);

                $outACLs[$id] = array_merge($outACLs[$id] ?? [], $acl->getPermissions());
            }
        }

        return $outACLs;
    }

    public function cache($acls)
    {
        Cache::forever($this->cachePrefix . 'storephp_acls', $acls);
    }

    public function manage($paths)
    {
        $acls = $this->merge($paths);
        $this->cache($acls);
        $this->count = count($acls);
    }
}
