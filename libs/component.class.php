<?php

namespace org\octris\newt {
    /****c* newt/component
     * NAME
     *      component
     * FUNCTION
     *      component base class
     * COPYRIGHT
     *      copyright (c) 2010 by Harald Lapp
     * AUTHOR
     *      Harald Lapp <harald@octris.org>
     ****
     */

    class component {
        /****v* component/$resource
         * SYNOPSIS
         */
        protected $resource = null;
        /*
         * FUNCTION
         *      newt resource of widget
         ****
         */
        
        /****m* component/addCallback
         * SYNOPSIS
         */
        public function addCallback($callback)
        /*
         * FUNCTION
         *      add callback to a component
         * INPUTS
         *      * $callback (callback) -- callback to add for component
         ****
         */
        {
            newt_component_add_callback($this->resource, $callback, array());
        }
        
        /****m* component/takesFocus
         * SYNOPSIS
         */
        public function takesFocus($focus)
        /*
         * FUNCTION
         *      Whether component may take the focus.
         * INPUTS
         *      * $focus (bool) -- whether component may take the focus
         ****
         */
        {
            newt_component_takes_focus($this->resource, $focus);
        }
        
        /****m* component/getResource
         * SYNOPSIS
         */
        public function getResource()
        /*
         * FUNCTION
         *      return resource identifier of component
         * OUTPUTS
         *      (resource) -- resource identifier of component
         ****
         */
        {
            return $this->resource;
        }
    }
}