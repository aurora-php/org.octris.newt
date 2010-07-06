<?php

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

    class window {
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
        
        /****v* window/$form
         * SYNOPSIS
         */
        protected $form;
        /*
         * FUNCTION
         *      window form handler
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
            
            $this->form = new \org\octris\newt\component\form();
        }
        
        /****m* window/__destruct
         * SYNOPSIS
         */
        public function __destruct()
        /*
         * FUNCTION
         *      destructor
         ****
         */
        {
            unset($this->form);
        }

        /****m* window/__callStatic
         * SYNOPSIS
         */
        public static function __callStatic($name, $args)
        /*
         * FUNCTION
         *      This method is a helper for statically calling the hide method.
         * INPUTS
         *      * $name (string) -- name of method to call statically
         *      * $args (mixed) -- (optional) arguments
         ****
         */
        {
            if ($name != 'hide') {
                throw new \Excaption('Call to undefined method ' . __CLASS__ . '::' . $name . '()!');
            } else {
                self::hide();
            }
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
                $exit_struct = array();
                
                $this->form->run($exit_struct);
                
                print_r($exit_struct);
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
        
        /****m* window/addComponent
         * SYNOPSIS
         */
        public function addComponent(\org\octris\newt\component $component)
        /*
         * FUNCTION
         *      add component to the form of the window
         * INPUTS
         *      * $component (component) -- component to add to the window form
         * OUTPUTS
         *      (component) -- returns instance of specified component
         ****
         */
        {
            return $this->form->addComponent($component);
        }
    }
}