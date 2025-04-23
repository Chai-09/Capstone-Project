<?php

namespace Illuminate\Http;

interface Request
{
    /**
     * @return \App\Models\Accounts|null
     */
    public function user($guard = null);
}