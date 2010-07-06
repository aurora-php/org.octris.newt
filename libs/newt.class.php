<?php

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
        
        /****m* newt/autoload
         * SYNOPSIS
         */
        public static function autoload($classpath)
        /*
         * FUNCTION
         *      class autoloader
         * INPUTS
         *      * $classpath (string) -- path of class to load
         ****
         */
        {
            $pkg = preg_replace('|\\\\|', '/', preg_replace('|\\\\|', '.', ltrim($classpath, '\\\\'), 2)) . '.class.php';

            require_once($pkg);
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

    spl_autoload_register(array('\org\octris\newt\newt', 'autoload'));
}
