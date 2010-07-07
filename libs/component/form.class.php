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
        /****v* window/$parent
         * SYNOPSIS
         */
        protected $parent = null;
        /*
         * FUNCTION
         *      stores instance of parent form, if the form has a parent
         ****
         */
        
        
        /****v* window/$actions
         * SYNOPSIS
         */
        protected $actions = array();
        /*
         * FUNCTION
         *      Actions registered for the form
         ****
         */
        
        /****m* form/__construct
         * SYNOPSIS
         */
        public function __construct(\org\octris\newt\component\form $parent = null, \org\octris\newt\component\vscrollbar $vscrollbar = null, $help = '', $flags = 0)
        /*
         * FUNCTION
         *      Creates a newt form component. The first parameter is _required_, when the form is intended to be a subform --
         *      when it's added to an other form using the ~addComponent~ method of the parent form.
         * INPUTS
         *      * $parent (form) -- (optional) parent form component (default: null).
         *      * $vscrollbar (vscrollbar) -- (optional) instance of a vertical scrollbar (default: null)
         *      * $help (string) -- (optional) helpline text
         *      * $flags (int) -- (optional) flags
         ****
         */
        {
            $this->parent   = null;
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
            newt_form_destroy($this->resource);
        }
        
        /****m* form/registerAction
         * SYNOPSIS
         */
        public function registerAction(\org\octris\newt\component $component, $callback)
        /*
         * FUNCTION
         *      Register an action for a specified component
         * INPUTS
         *      * $component (component) -- component to register action for
         *      * $callback (callback) -- callback to call, if action is performed
         ****
         */
        {
            $this->actions[(string)$component] = $callback;
        }
        
        /****m* form/dispatchAction
         * SYNOPSIS
         */
        protected function dispatchAction($exit_struct)
        /*
         * FUNCTION
         *      Action dispatcher
         * INPUTS
         *      * $exit_struct (array) -- requires to be an exit structure as it's provided when a formular was run
         ****
         */
        {
            if (is_array($exit_struct) && isset($exit_struct['component'])) {
                $res = (string)$exit_struct['component'];
                
                if (isset($this->actions[$res])) {
                    $cb = $this->actions[$res];
                    $cb($exit_struct);
                }
            }
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
            
            $this->dispatchAction($exit_struct);
        }
        
        /****m* form/addComponent
         * SYNOPSIS
         */
        public function addComponent(\org\octris\newt\component $component)
        /*
         * FUNCTION
         *      add component to the form
         * INPUTS
         *      * $component (component) -- component to add to the window form
         * OUTPUTS
         *      (component) -- returns instance of specified component
         ****
         */
        {
            newt_form_add_component($this->resource, $component->getResource());
            
            return $component;
        }
    }
}