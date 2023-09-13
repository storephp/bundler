<?php

namespace StorePHP\Bundler\Contracts\ACL;

use StorePHP\Bundler\Lib\ACL;

interface HasPermissions
{
    public function permissions(ACL $acl);
}
