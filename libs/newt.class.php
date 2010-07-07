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
    /****c* newt/newt
     * NAME
     *      newt
     * FUNCTION
     *      core class of newt OOP library
     * COPYRIGHT
     *      copyright (c) 2010 by Harald Lapp
     * AUTHOR
     *      Harald Lapp <harald@octris.org>
     ****
     */

    class newt {
        /****v* newt/$instance
         * SYNOPSIS
         */
        private static $instance = null;
        /*
         * FUNCTION
         *      Instance of newt class to implement singleton
         ****
         */
        
        /****v* newt/$help
         * SYNOPSIS
         */
        protected static $helplines = 0;
        /*
         * FUNCTION
         *      This variable holds the number of messages pushed to the helpline and it's purpose is to cleanup the helpline
         *      stack, when application exits.
         ****
         */
        
        /****m* newt/__construct
         * SYNOPSIS
         */
        protected function __construct()
        /*
         * FUNCTION
         *      constructor -- initialize newt interface
         ****
         */
        {
            newt_init();
        }
        
        /****m* newt/__clone
         * SYNOPSIS
         */
        private function __clone() {}
        /*
         * FUNCTION
         *      cloning of instances of this class is not allowed!
         ****
         */
        
        /****m* newt/__destruct
         * SYNOPSIS
         */
        public function __destruct()
        /*
         * FUNCTION
         *      destructor -- uninitialize newt interface
         ****
         */
        {
            newt_cls();
            newt_finished();
        }
        
        /****m* newt/getInstance
         * SYNOPSIS
         */
        final public static function getInstance()
        /*
         * FUNCTION
         *      Create instance of newt class or return the instance, if it already was created.
         * OUTPUTS
         *      (newt) -- newt instance
         ****
         */
        {
            if (is_null(self::$instance)) {
                self::$instance = new static();
            }
            
            return self::$instance;
        }
        
        /****m* newt/bell
         * SYNOPSIS
         */
        public function bell()
        /*
         * FUNCTION
         *      Sends a beep to the terminal.
         ****
         */
        {
            newt_bell();
        }
        
        /****m* newt/cls
         * SYNOPSIS
         */
        public function cls()
        /*
         * FUNCTION
         *      clears the screen
         ****
         */
        {
            newt_cls();
        }
        
        /****m* newt/refresh
         * SYNOPSIS
         */
        public function refresh()
        /*
         * FUNCTION
         *      Refresh the screen
         ****
         */
        {
            newt_refresh();
        }
        
        /****m* newt/getScreenSize
         * SYNOPSIS
         */
        public function getScreenSize()
        /*
         * FUNCTION
         *      Returns screen size
         * OUTPUTS
         *      
         ****
         */
        {
            $width  = null;
            $height = null;
            
            newt_get_screen_size(&$width, &$height);
            
            $return = new \stdClass;
            $return->width  = $width;
            $return->height = $height;
            
            return $return;
        }
        
        /****m* newt/drawRootText
         * SYNOPSIS
         */
        public function drawRootText($x, $y, $text)
        /*
         * FUNCTION
         *      Display text in the root window at the specified position.
         * INPUTS
         *      * $x (int) -- column to place text at
         *      * $y (int) -- row to place text in
         *      * $text (string) -- text to display
         ****
         */
        {
            newt_draw_root_text($x, $y, $text);
        }

        /****m* newt/pushHelpLine
         * SYNOPSIS
         */
        public function pushHelpLine($text)
        /*
         * FUNCTION
         *      Saves the current help line on a stack and displays the new line. If the text is null, 
         *      Newt's default help line is displayed. If text is a string of length 0, the help line is cleared.
         * INPUTS
         *      * $text (string) -- string to display in help line
         ****
         */
        {
            ++self::$helplines;
            
            newt_push_help_line($text);
        }

        /****m* newt/popHelpLine
         * SYNOPSIS
         */
        public function popHelpLine()
        /*
         * FUNCTION
         *      Remove current help line text and replace it with last entry on the help line stack
         ****
         */
        {
            if (self::$helplines > 0) {
                --self::$helplines;

                newt_pop_help_line();
            }
        }
    }

    spl_autoload_register(function($classpath) {
        $pkg = preg_replace('|\\\\|', '/', preg_replace('|\\\\|', '.', ltrim($classpath, '\\\\'), 2)) . '.class.php';
    
        require_once($pkg);
    });
}
