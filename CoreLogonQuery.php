<?php
/*****************************************************************************
 *
 * CoreModLogonEnv.php - Module for handling logins by environment vars
 *
 * Copyright (c) 2004-2013 NagVis Project (Contact: info@nagvis.org)
 *
 * License:
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2 as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 *
 *****************************************************************************/

// ctsiri, 2014-11-20

class CoreLogonQuery extends CoreLogonModule {
    public function check($printErr = true) {
        global $AUTH, $CORE;

        $FHANDLER = new CoreRequestHandler(array_merge($_GET, $_POST));

        // Don't try to auth if one of the vars is missing or invalid
        if(!$FHANDLER->issetAndNotEmpty('username')
           || !$FHANDLER->issetAndNotEmpty('password'))
            return false;

        if(!$FHANDLER->match('username', MATCH_USER_NAME)
           || $FHANDLER->isLongerThan('username', AUTH_MAX_USERNAME_LENGTH))
            return false;

        if(!$FHANDLER->issetAndNotEmpty('password')
           || $FHANDLER->isLongerThan('password', AUTH_MAX_PASSWORD_LENGTH))
            return false;

        $data = Array('user'     => $FHANDLER->get('username'),
                      'password' => $FHANDLER->get('password'));

       // Remove authentication infos. Hide it from the following code
        if(isset($_REQUEST['username']))
            unset($_REQUEST['username']);
        if(isset($_REQUEST['password']))
            unset($_REQUEST['password']);
        if(isset($_POST['username']))
            unset($_POST['username']);
        if(isset($_POST['password']))
            unset($_POST['password']);
        if(isset($_GET['username']))
            unset($_GET['username']);
        if(isset($_GET['password']))
            unset($_GET['password']);

        $AUTH->setTrustUsername(false);
        $AUTH->setLogoutPossible(false);
        $AUTH->passCredentials($data);
        $result = $AUTH->isAuthenticated();
        if($result === true) {
            $AUTH->storeInSession();
            return true;
        } else {
            return false;
        }
    }
}
?>
