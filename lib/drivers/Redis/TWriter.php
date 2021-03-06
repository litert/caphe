<?php
/**
 * File: TWriter.php
 * Created Date: 2017年6月1日 上午11:03:16
 */
declare (strict_types = 1);

namespace Caphe\Driver\Redis;

use Caphe\Exception;

trait TWriter
{
    public function add(
        string $key,
        $val,
        int $ttl = null
    ): bool
    {
        if ($this->_writeConn->setnx($key, serialize($val))) {

            if ($ttl) {

                return $this->_writeConn->expire(
                    $key,
                    $ttl
                );
            }
            else {

                return true;
            }
        }

        return false;
    }

    public function addString(
        string $key,
        string $val,
        int $ttl = null
    ): bool
    {
        if ($this->_writeConn->setnx($key, $val)) {

            if ($ttl) {

                return $this->_writeConn->expire(
                    $key,
                    $ttl
                );
            }
            else {

                return true;
            }
        }

        return false;
    }

    public function addInt(
        string $key,
        int $val,
        int $ttl = null
    ): bool
    {
        if ($this->_writeConn->setnx($key, $val)) {

            if ($ttl) {

                return $this->_writeConn->expire(
                    $key,
                    $ttl
                );
            }
            else {

                return true;
            }
        }

        return false;
    }

    public function addFloat(
        string $key,
        float $val,
        int $ttl = null
    ): bool
    {
        if ($this->_writeConn->setnx($key, $val)) {

            if ($ttl) {

                return $this->_writeConn->expire(
                    $key,
                    $ttl
                );
            }
            else {

                return true;
            }
        }

        return false;
    }

    public function set(
        string $key,
        $val,
        int $ttl = null
    ): bool
    {
        if ($this->_writeConn->set($key, serialize($val))) {

            if ($ttl) {

                return $this->_writeConn->expire($key, $ttl);
            }
            else {

                return true;
            }
        }

        return false;
    }

    public function setMulti(
        array $items,
        int $ttl = null
    ): bool
    {
        if ($ttl !== null) {

            $conn = $this->_writeConn;
            $conn->pipeline();

            foreach ($items as $key => $val) {

                $conn->setex($key, $ttl, serialize($val));
            }

            $conn->exec();
        }
        else {

            foreach ($items as $key => &$val) {

                $val = serialize($val);
            }

            $this->_writeConn->mSet($items);
        }

        return true;
    }

    public function setMultiString(
        array $items,
        int $ttl = null
    ): bool
    {
        if ($ttl !== null) {

            $conn = $this->_writeConn;
            $conn->pipeline();

            foreach ($items as $key => $val) {

                $conn->setex($key, $ttl, (string)$val);
            }

            $conn->exec();
        }
        else {

            $this->_writeConn->mSet($items);
        }

        return true;
    }

    public function setMultiInt(
        array $items,
        int $ttl = null
    ): bool
    {
        if ($ttl !== null) {

            $conn = $this->_writeConn;
            $conn->pipeline();

            foreach ($items as $key => $val) {

                $conn->setex($key, $ttl, (int)$val);
            }

            $conn->exec();
        }
        else {

            $this->_writeConn->mSet($items);
        }

        return true;
    }

    public function setMultiFloat(
        array $items,
        int $ttl = null
    ): bool
    {
        if ($ttl !== null) {

            $conn = $this->_writeConn;
            $conn->pipeline();

            foreach ($items as $key => $val) {

                $conn->setex($key, $ttl, (float)$val);
            }

            $conn->exec();
        }
        else {

            $this->_writeConn->mSet($items);
        }

        return true;
    }

    public function setString(
        string $key,
        string $val,
        int $ttl = null
    ): bool
    {
        if ($this->_writeConn->set($key, $val)) {

            if ($ttl) {

                return $this->_writeConn->expire($key, $ttl);
            }
            else {

                return true;
            }
        }

        return false;
    }

    public function setInt(
        string $key,
        int $val,
        int $ttl = null
    ): bool
    {
        if ($this->_writeConn->set($key, $val)) {

            if ($ttl) {

                return $this->_writeConn->expire($key, $ttl);
            }
            else {

                return true;
            }
        }

        return false;
    }

    public function setFloat(
        string $key,
        float $val,
        int $ttl = null
    ): bool
    {
        if ($this->_writeConn->set($key, $val)) {

            if ($ttl) {

                return $this->_writeConn->expire($key, $ttl);
            }
            else {

                return true;
            }
        }

        return false;
    }

    public function cas(
        string $key,
        int $current,
        int $new
    ): bool
    {
        return $this->_writeConn->evalSHA(
            SHA_CAS,
            [$key, $current, $new],
            1
        ) ? true : false;
    }

    public function increase(string $key, int $step = 1): int
    {
        $ret = $this->_writeConn->incrBy($key, $step);

        if ($ret === false) {

            $this->_assertConnected();

            return 0;
        }

        return $ret;
    }

    public function decrease(string $key, int $step = 1): int
    {
        $ret = $this->_writeConn->decrBy($key, $step);

        if ($ret === false) {

            $this->_assertConnected();

            return 0;
        }

        return $ret;
    }

    public function remove(string $key): bool
    {
        return $this->_writeConn->delete($key) ? true : false;
    }

    public function removeMulti(array $keys): int
    {
        $ret = $this->_writeConn->delete($keys);

        if ($ret === false) {

            $this->_assertConnected();
            return 0;
        }

        return $ret;
    }

    public function removeAll(): bool
    {
        $ret = $this->_writeConn->flushDB();

        if ($ret === false) {

            $this->_assertConnected();

            return false;
        }

        return $ret;
    }
}
