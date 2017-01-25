<?php

namespace Damianopetrungaro\CleanArchitecture\Persistence;


interface TransactionInterface
{
    /**
     * Begin a new transaction
     *
     * @return bool
     */
    public function begin() : bool;

    /**
     * Commit a transaction
     *
     * @return bool
     */
    public function commit() : bool;

    /**
     * Rollback a transaction
     *
     * @return bool
     */
    public function rollback() : bool;
}