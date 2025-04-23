<?php

namespace Illuminate\Support\Facades;

interface Auth
{
    /**
     * @return \App\Models\Accounts|false
     */
    public static function loginUsingId(mixed $id, bool $remember = false);

    /**
     * @return \App\Models\Accounts|false
     */
    public static function onceUsingId(mixed $id);

    /**
     * @return \App\Models\Accounts|null
     */
    public static function getUser();

    /**
     * @return \App\Models\Accounts
     */
    public static function authenticate();

    /**
     * @return \App\Models\Accounts|null
     */
    public static function user();

    /**
     * @return \App\Models\Accounts|null
     */
    public static function logoutOtherDevices(string $password);

    /**
     * @return \App\Models\Accounts
     */
    public static function getLastAttempted();
}