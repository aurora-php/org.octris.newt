#!/usr/bin/env php
<?php

/*
 * Copyright (c) 2010, Harald Lapp <harald@octris.org>.
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
 *   * Neither the name of Harald Lapp nor the names of its 
 *     contributors may be used to endorse or promote products derived 
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS 
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT 
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS 
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE 
 * COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, 
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, 
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER 
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT 
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN 
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
 * POSSIBILITY OF SUCH DAMAGE.
 *
 */

require_once('org.octris.newt/newt.class.php');

use \org\octris\newt\newt as newt;
use \org\octris\newt\component as component;

$app = newt::getInstance();
$app->drawRootText(0, 0, 'Network Configuration');
$app->drawRootText(-23, 0, '(c) 2010 by Harald Lapp');

$window = new component\window(37, 13, 'Enter the network configuration:');

$window->addComponent(new component\label(2, 1, 'Hostname'));
$entry1 = $window->addComponent(new component\entry(15, 1, 20));

$window->addComponent(new component\label(2, 2, 'Domain Name'));
$entry2 = $window->addComponent(new component\entry(15, 2, 20));

$window->addComponent(new component\label(2, 4, 'Netmask'));
$entry3 = $window->addComponent(new component\entry(15, 4, 20));

$window->addComponent(new component\label(2, 5, 'Gateway'));
$entry4 = $window->addComponent(new component\entry(15, 5, 15));

$window->addComponent(new component\label(2, 6, 'Primary DNS'));
$entry5 = $window->addComponent(new component\entry(15, 6, 15));

$chk = $window->addComponent(new component\checkbox(2, 8, 'Use HTTP Proxy', ' '));

$window->addComponent(new component\label(2, 9, 'Proxy URL'));
$entry6 = $window->addComponent(new component\entry(15, 9, 20));

$btn1 = $window->addComponent(new component\button(2, 11, 'Done', true));
$window->registerAction($btn1, function($data) use ($window) { 
    // exit dialog -- therefore return ~false~
    return false;
});

$btn2 = $window->addComponent(new component\button(10, 11, 'Cancel', true));
$window->registerAction($btn2, function($data) use ($window) { 
    // exit dialog -- therefore return ~false~
    return false;
});

$window->show();
$window->hide();
