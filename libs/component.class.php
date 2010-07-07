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

        /****v* component/$events = array()
         * SYNOPSIS
         */
        protected $events = array();
        /*
         * FUNCTION
         *      Registered events
         ****
         */

        /****v* component/$parent
         * SYNOPSIS
         */
        protected $parent = null;
        /*
         * FUNCTION
         *      Parent form component
         ****
         */

        /****m* component/__call
         * SYNOPSIS
         */
        public function __call($name, $args)
        /*
         * FUNCTION
         *      implements magic method __call for triggering event handlers
         * INPUTS
         *      * $name (string) -- name of event handler triggered
         *      * $args (mixed) -- (optional) arguments
         ****
         */
        {
            if (substr($name, 0, 2) == 'on' && isset($this->events[$evt = strtolower(substr($name, 2))])) {
                $cb = $this->events[$evt];
                $cb($args);
            }
        }

        /****m* component/__toString
         * SYNOPSIS
         */
        public function __toString()
        /*
         * FUNCTION
         *      Returns internal resource ID.
         * OUTPUTS
         *      (string) -- internal component ID
         ****
         */
        {
            return (string)$this->resource;
        }
        
        /****m* entry/addEvent
         * SYNOPSIS
         */
        public function addEvent($name, $callback)
        /*
         * FUNCTION
         *      Add event to entry box. The following events are supported:
         *
         *      * blur -- is triggered, when entry box looses focus
         * INPUTS
         *      * $name (string) -- name of event
         *      * $callback (callback) -- callback to call when event is triggered
         ****
         */
        {
            $this->events[strtolower($name)] = $callback;
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
        
        /****m* component/setParent
         * SYNOPSIS
         */
        public function setParent(\org\octris\newt\component\form $parent)
        /*
         * FUNCTION
         *      Set parent form component
         * INPUTS
         *      * $parent (component) -- parent form component
         ****
         */
        {
            if (is_null($this->parent)) {
                $this->parent = $parent;
            } else {
                throw new \Exception('reparenting is currently not supported!');
            }
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