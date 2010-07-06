#!/usr/bin/env php
<?php

require_once('org.octris.newt/newt.class.php');

use \org\octris\newt\newt as newt;
use \org\octris\newt\component as component;

$app = newt::getInstance();
$app->drawRootText(0, 0, 'Test');
$app->pushHelpLine(null);
$app->drawRootText(-23, 0, '(c) 2010 by Harald Lapp');

$size = newt::getScreenSize();

$window = new component\window($size->width / 2 - 10, $size->height / 2 - 10);

$window->addComponent(new component\button(0, 0, 'QUIT'));
$window->show();

unset($window);

?>