<?php

namespace org\octris\newt\component {
    /****c* component/form
     * NAME
     *      form
     * FUNCTION
     *      newt form
     * COPYRIGHT
     *      copyright (c) 2010 by Harald Lapp
     * AUTHOR
     *      Harald Lapp <harald@octris.org>
     ****
     */

    class form extends \org\octris\newt\component {
        /****m* form/__construct
         * SYNOPSIS
         */
        public function __construct(\org\octris\newt\component\vscrollbar $vscrollbar = null, $help = '', $flags = 0)
        /*
         * FUNCTION
         *      constructor
         * INPUTS
         *      * 
         * OUTPUTS
         *      
         ****
         */
        {
            $this->resource = newt_form((is_null($vscrollbar) ? null : $vscrollbar->getResource()), $help, $flags);
        }
        
        /****m* form/__destruct
         * SYNOPSIS
         */
        public function __destruct()
        /*
         * FUNCTION
         *      Destructor frees the memory used by the form and all it's assigned components.
         ****
         */
        {
            newt_form_destry($this->resource);
        }
        
        /****m* form/run
         * SYNOPSIS
         */
        public function run(&$exit_struct)
        /*
         * FUNCTION
         *      runs the form
         ****
         */
        {
            newt_form_run($this->resource, $exit_struct);
        }
    }
}