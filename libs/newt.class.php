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
        public static function bell()
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
        public static function cls()
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
        public static function getScreenSize()
        /*
         * FUNCTION
         *      Returns screen size
         * OUTPUTS
         *      
         ****
         */
        {
            newt_get_screen_size(&$width = null, &$height = null);
            
            $return = new stdClass;
            $return->width  = $width;
            $return->height = $height;
            
            return $return;
        }
        
        /****m* newt/drawRootText
         * SYNOPSIS
         */
        public static function drawRootText($x, $y, $text)
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
            newt_draw_root_window($x, $y, $text);
        }

        /****m* newt/pushHelpLine
         * SYNOPSIS
         */
        public static function pushHelpLine($text)
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
