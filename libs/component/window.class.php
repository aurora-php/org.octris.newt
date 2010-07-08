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
    use \org\octris\newt\newt as newt;
    
    /****c* component/window
     * NAME
     *      window
     * FUNCTION
     *      window component
     * COPYRIGHT
     *      copyright (c) 2010 by Harald Lapp
     * AUTHOR
     *      Harald Lapp <harald@octris.org>
     ****
     */

    class window extends \org\octris\newt\component\form {
        /****v* window/$x
         * SYNOPSIS
         */
        protected $x = null;
        /*
         * FUNCTION
         *      x position of window
         ****
         */
        
        /****v* window/$y
         * SYNOPSIS
         */
        protected $y = null;
        /*
         * FUNCTION
         *      y position of window
         ****
         */
        
        /****v* window/$width
         * SYNOPSIS
         */
        protected $width = 0;
        /*
         * FUNCTION
         *      width of window
         ****
         */
        
        /****v* window/$height
         * SYNOPSIS
         */
        protected $height = 0;
        /*
         * FUNCTION
         *      height of window
         ****
         */
        
        /****v* window/$title
         * SYNOPSIS
         */
        protected $title = '';
        /*
         * FUNCTION
         *      title of window
         ****
         */
        
        /****v* window/$helpline
         * SYNOPSIS
         */
        protected $helpline = null;
        /*
         * FUNCTION
         *      optional helpline of the window
         ****
         */
        
        /****v* window/$visible
         * SYNOPSIS
         */
        protected $visible = false;
        /*
         * FUNCTION
         *      whether the window is visible
         ****
         */
        
        /****v* window/$stack
         * SYNOPSIS
         */
        protected static $stack = array();
        /*
         * FUNCTION
         *      window stack
         ****
         */
        
        /****m* window/__construct
         * SYNOPSIS
         */
        public function __construct($w, $h, $title = '', $x = null, $y = null)
        /*
         * FUNCTION
         *      Opens a new window. If x, y are not specified, the window will be displayed centered
         * INPUTS
         *      * $w (int) -- width of window
         *      * $h (int) -- height of window
         *      * $title (string) -- (optional) title of window
         *      * $x (int) -- (optional) column
         *      * $y (int) -- (optional) row
         ****
         */
        {
            $this->x      = $x;
            $this->y      = $y;
            $this->width  = $w;
            $this->height = $h;
            $this->title  = $title;
            
            parent::__construct();
        }
        
        /****m* window/setHelp
         * SYNOPSIS
         */
        public function setHelp($text)
        /*
         * FUNCTION
         *      Set help to display when the method window::show is called. The helpline can only be set,
         *      when the window is invisible.
         * INPUTS
         *      * $text (string) -- helpline text for the window
         ****
         */
        {
            if (!$this->visible) $this->helpline = $text;
        }

        /****m* window/show
         * SYNOPSIS
         */
        public function show()
        /*
         * FUNCTION
         *      show window
         ****
         */
        {
            if ($this->visible) {
                throw new \Exception('The window was already opened!');
            } else {
                if (is_null($this->x) || is_null($this->y)) {
                    newt_centered_window($this->width, $this->height, $this->title);
                } else {
                    newt_open_window($this->x, $this->y, $this->width, $this->height, $this->title);
                }
            
                if (!is_null($this->helpline)) {
                    newt::pushHelpLine($this->helpline);
                }
            
                // push method for hiding _this_ window on window-stack
                $visible  =& $this->visible;
                $helpline =& $this->helpline;
                
                array_push(self::$stack, function() use (&$visible, &$helpline) {
                    newt_pop_window();
                    
                    $visible = false;
                    
                    if (!is_null($helpline)) {
                        newt::popHelpLine();
                    }
                });
            
                // run form
                parent::run();
            }
        }
        
        /****m* window/hide
         * SYNOPSIS
         */
        public static function hide()
        /*
         * FUNCTION
         *      Hide window which is on top of stack. This method is static, because it's only allowed to hide the least opened
         *      window.
         ****
         */
        {
            if ($cb = array_pop(self::$stack)) {
                $cb();
            }
        }
        
        /****m* window/run
         * SYNOPSIS
         */
        public function run()
        /*
         * FUNCTION
         *      Overwrite run method of parent class and make it an alias for ~self::show~
         ****
         */
        {
            $this->show();
        }
    }
}
