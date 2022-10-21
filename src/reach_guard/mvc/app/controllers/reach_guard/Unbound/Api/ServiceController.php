<?php

/*
 * Copyright (C) 2019 Michael Muenz <m.muenz@gmail.com>
 * Copyright (C) 2020 Cloud_Etel
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace reach_guard\Unbound\Api;

use reach_guard\Base\ApiMutableServiceControllerBase;
use reach_guard\Core\Backend;

class ServiceController extends ApiMutableServiceControllerBase
{
    protected static $internalServiceClass = '\reach_guard\Unbound\Unbound';
    protected static $internalServiceTemplate = 'reach_guard/Unbound/*';
    protected static $internalServiceEnabled = 'service_enabled';
    protected static $internalServiceName = 'unbound';

    public function dnsblAction()
    {
        $this->sessionClose();
        $backend = new Backend();
        $backend->configdRun('template reload ' . escapeshellarg(static::$internalServiceTemplate));
        $response = json_decode(trim($backend->configdRun(static::$internalServiceName . ' dnsbl')), true);
        if ($response !== null) {
            $response['status'] = "OK";
            $response['status_msg'] = sprintf(
                gettext("Added %d and removed %d resource records."),
                $response['additions'],
                $response['removals']
            );
            return $response;
        }

        return array(
            'status' => 'ERR',
            'status_msg' => gettext('An error occurred during script execution. Check the logs for details'),
        );
    }
}
