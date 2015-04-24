<?php

/*
 * The MIT License
 *
 * Copyright 2015 Mitchfizz05.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Placeholder handler for getting the realms that the player is invited to.
 *
 * @author Mitchfizz05
 */
class RequestWorlds {
    public function should_respond($request, $session) {
        return ($request->path == '/worlds');
    }
    
    public function respond($request, $session) {
        // Forge response
        $responsetext = array(
            'servers' => array(
                array(
                    'id' => 1,
                    'remoteSubscriptionId' => '1',
                    'name' => 'Potatocraft',
                    'players' => array('mitchfizz05', 'mindlux', 'Spazzer400'),
                    'motd' => 'Potatocraft. :)',
                    'state' => 'OPEN',
                    'owner' => 'mitchfizz05',
                    "ownerUUID" => 'b6284cef69f440d2873054053b1a925d',
                    'daysLeft' => 365,
                    'ip' => 'potatocraft.pw:25565',
                    'expired' => false,
                    'minigame' => false
                )
            )
        );
        $responsetext = json_encode($responsetext);
        
        $resp = new Response();
        $resp->contentbody = $responsetext;
        return $resp;
    }
}
