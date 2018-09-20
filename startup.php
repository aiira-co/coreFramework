<?php

/**
 * Copyright (c) 2018 airDesign.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of the
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package     [ Project-AIR ]
 * @subpackage  [ coreFramework ]
 * @author      Owusu-Afriyie Kofi <koathecedi@gmail.com>
 * @copyright   2018 airDesign.
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link        http://airdesign.co.nf
 * @version     @@2.00@@
 */

declare(strict_types=1);

use Lynq\Core\Programe;
use Lynq\Core\AirJax;

session_start();

/**
 * Boostrap the app
 */
class Startup
{
    private $zenoConfig;
    private $bootstrapComponent ='app';

    // the bootraped will tell us the router


    //check if the app is offline,
    //if yes, show offline page and account login,
    //if login, display app

    //else if no, show the default page that is set as home.
    //check if the page exists,
    //if yes, show page
    //else, it show error page

    public function __construct()
    {
        require_once 'config.php';

        $this->zenoConfign = new  Config;

        if ($this->zenoConfign->offline) {
            echo $isAirJax ? json_encode(["noti"=>"success","result"=>$zenoConfig->offline_message]): $zenoConfig->$displayOfflineMessage ? $zenoConfig->offlineMessage:null;
        } else {
            define('DS', DIRECTORY_SEPARATOR);
            require_once __DIR__.DS.'vendor'.DS.'autoload.php';
            $this->checkRequestType() ? $this->loadAirJaxComp():
            $this->bootstrapApp() ;
        }
    }

    private function checkRequestType():bool
    {
        // dont just check for airJaxPath, also verify the value else die.
        return
        isset($_GET['airJaxPath']) ||
        isset($_POST['airJaxPath'])
        ;
    }


    private function loadAirJaxComp()
    {
        if ($this->authorization()) {
            $airJax = new AirJax($this->bootstrapComponent, new Config);
        } else {
            die('WHO ARE YOU');
        }
    }

    private function bootstrapApp()
    {
        // print_r(new Config);
        $app = new Programe(new Config);
        if (isset($_GET['api']) && $_GET['api'] =='airJax') {
            $app->renderO($this->bootstrapComponent);
        } else {
            $app->bootstrapComponent($this->bootstrapComponent);
        }
    }




    // Also look for a way to generate TOKENS per each call(ajax) for verfication.
    // To prevent spoofing, also check to see if the requested component requires authentication and if the person
    // or client is authenticated, and the right user to make those changes

    //CrossOringin Checks
    // This should be a separate class

    private function authorization():bool
    {
        return true;

        if (isset($zenoConfig->cors)) {
            for ($i=0; $i < count($zenoConfig->cors); $i++) {
                if ($zenoConfig->cors[$i] == $_SERVER['REMOTE_ADDR']) {
                    return true;
                }

                return false;
            }
        } else {
            return false;
        }
    }
}

$app = new startup;
