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
    /****c* component/radio
     * NAME
     *      radio
     * FUNCTION
     *      radio button _group_ component
     * COPYRIGHT
     *      copyright (c) 2010 by Harald Lapp
     * AUTHOR
     *      Harald Lapp <harald@octris.org>
     ****
     */

    class radio extends \org\octris\newt\component {
        /****v* radio/$parent
         * SYNOPSIS
         */
        protected $parent = null;
        /*
         * FUNCTION
         *      parent form
         ****
         */
        
        /****v* radio/$buttons
         * SYNOPSIS
         */
        protected $buttons = array();
        /*
         * FUNCTION
         *      Stores resource handlers of all for this group created buttons
         ****
         */
        
        /****m* radio/__construct
         * SYNOPSIS
         */
        public function __construct(\org\octris\newt\component\form $parent)
        /*
         * FUNCTION
         *      constructor
         ****
         */
        {
            $this->parent   = $parent;
            $this->resource = newt_form(null, null, 0);
        }
        
        /****m* radio/__destruct
         * SYNOPSIS
         */
        public function __destruct()
        /*
         * FUNCTION
         *      destructor
         ****
         */
        {
            if (is_null($this->parent)) newt_form_destroy($this->resource);
        }
        
        /****m* radio/addButton
         * SYNOPSIS
         */
        public function addButton($x, $y, $text, $value, $default = false)
        /*
         * FUNCTION
         *      Add radio button to the group.
         * INPUTS
         *      * $x (int) -- column the radio button is displayed at
         *      * $y (int) -- row the radio button is displayed in
         *      * $text (string) -- label for the radio button
         *      * $value (mixed) -- value to store with the radio button
         *      * $default (bool) -- (optional) whether the radio button should be activated as default button (default: false)
         ****
         */
        {
            $prev = (($cnt = count($this->buttons)) > 0
                        ? $this->buttons[$cnt - 1]['resource']
                        : null);

            $button = newt_radiobutton($x, $y, $text, $default, $prev);
            
            newt_form_add_component($this->resource, $button);
            
            array_push($this->buttons, array(
                'resource' => $button,
                'value'    => $value
            ));
        }
        
        /****m* radio/getCurrent
         * SYNOPSIS
         */
        public function getCurrent()
        /*
         * FUNCTION
         *      Get current activated radio button.
         * OUTPUTS
         *      (mixed) -- value that was stored with the radio button
         ****
         */
        {
            $activated = (string)newt_radio_get_current($this->buttons[0]['resource']);
            $return    = null;
            
            foreach ($this->buttons as $button) {
                if ($activated == (string)$button['resource']) {
                    $return = $button['value'];
                }
            }
            
            return $return;
        }
    }
}
