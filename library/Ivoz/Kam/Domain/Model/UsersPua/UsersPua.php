<?php

namespace Ivoz\Kam\Domain\Model\UsersPua;

/**
 * UsersPua
 */
class UsersPua extends UsersPuaAbstract implements UsersPuaInterface
{
    use UsersPuaTrait;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}

