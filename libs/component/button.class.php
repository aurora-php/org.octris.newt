<?php

namespace org\octris\newt\component {
    /****c* component/button
     * NAME
     *      button
     * FUNCTION
     *      button component
     * COPYRIGHT
     *      copyright (c) 2010 by Harald Lapp
     * AUTHOR
     *      Harald Lapp <harald@octris.org>
     ****
     */

    class button extends \org\octris\newt\component {
        /****m* button/__construct
         * SYNOPSIS
         */
        public function __construct($x, $y, $text)
        /*
         * FUNCTION
         *      constructor
         * INPUTS
         *      * $x (int) -- column to display button at
         *      * $y (int) -- row to display button in
         *      * $text (string) -- text to display in button
         ****
         */
        {
            $this->resource = newt_button($x, $y, $text);
        }
    }
}