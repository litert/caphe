<?php
/**
 * File: TWriter.php
 * Created Date: 2017-08-09 11:16:23
 */
declare (strict_types = 1);

namespace Caphe\Driver\APCu;

trait TNSWriter
{
    public function nsAdd(
        string $ns,
        string $key,
        $val,
        int $ttl = 0
    ): bool
    {
        return apcu_add(
            "{$this->_nsGetNSLock($ns)}/{$key}",
            $val,
            $ttl
        );
    }

    public function nsAddString(
        string $ns,
        string $key,
        string $val,
        int $ttl = 0
    ): bool
    {
        return apcu_add(
            "{$this->_nsGetNSLock($ns)}/{$key}",
            $val,
            $ttl
        );
    }

    public function nsAddInt(
        string $ns,
        string $key,
        int $val,
        int $ttl = 0
    ): bool
    {
        return apcu_add(
            "{$this->_nsGetNSLock($ns)}/{$key}",
            $val,
            $ttl
        );
    }

    public function nsAddFloat(
        string $ns,
        string $key,
        float $val,
        int $ttl = 0
    ): bool
    {
        return apcu_add(
            "{$this->_nsGetNSLock($ns)}/{$key}",
            $val,
            $ttl
        );
    }

    public function nsSet(
        string $ns,
        string $key,
        $val,
        int $ttl = 0
    ): bool
    {
        return apcu_store(
            "{$this->_nsGetNSLock($ns)}/{$key}",
            $val,
            $ttl
        );
    }

    public function nsSetString(
        string $ns,
        string $key,
        string $val,
        int $ttl = 0
    ): bool
    {
        return apcu_store(
            "{$this->_nsGetNSLock($ns)}/{$key}",
            $val,
            $ttl
        );
    }

    public function nsSetInt(
        string $ns,
        string $key,
        int $val,
        int $ttl = 0
    ): bool
    {
        return apcu_store(
            "{$this->_nsGetNSLock($ns)}/{$key}",
            $val,
            $ttl
        );
    }

    public function nsSetFloat(
        string $ns,
        string $key,
        float $val,
        int $ttl = 0
    ): bool
    {
        return apcu_store(
            "{$this->_nsGetNSLock($ns)}/{$key}",
            $val,
            $ttl
        );
    }

    public function nsCAS(
        string $ns,
        string $key,
        int $current,
        int $new
    ): bool
    {
        return apcu_cas(
            "{$this->_nsGetNSLock($ns)}/{$key}",
            $current,
            $new
        );
    }

    public function nsIncrease(
        string $ns,
        string $key,
        int $step = 1
    ): int
    {
        $ret = apcu_inc(
            "{$this->_nsGetNSLock($ns)}/{$key}",
            $step,
            $success
        );
        return $success ? $ret : 0;
    }

    public function nsDecrease(
        string $ns,
        string $key,
        int $step = 1
    ): int
    {
        $ret = apcu_dec(
            "{$this->_nsGetNSLock($ns)}/{$key}",
            $step,
            $success
        );
        return $success ? $ret : 0;
    }

    public function nsRemove(string $ns, string $key): bool
    {
        return apcu_delete(
            "{$this->_nsGetNSLock($ns)}/{$key}"
        );
    }

    public function nsRemoveMulti(string $ns, array $keys): int
    {
        $lockedPrefix = $this->_nsGetNSLock($ns);

        foreach ($keys as &$key) {

            $key = "{$lockedPrefix}/{$key}";
        }

        $ret = apcu_delete($keys);

        return count($keys) - $ret;
    }

    public function nsRemoveAll(string $ns): bool
    {
        return $this->_nsRemoveLock($ns);
    }
}