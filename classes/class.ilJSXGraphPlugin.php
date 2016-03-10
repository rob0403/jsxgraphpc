<?php
/**
 * Copyright (c) 2016 IZUS/TIK, Universität Stuttgart
 * GPLv3, see gpl-3.0.txt
 */
 
include_once("./Services/COPage/classes/class.ilPageComponentPlugin.php");
 
/**
 * JSXGraph user interface plugin
 *
 * @author Per Pascal Grube <pascal.grube@tik.uni-stuttgart.de>
 * @version $Id$
 *
 */
class ilJSXGraphPlugin extends ilPageComponentPlugin
{
        /**
         * Get plugin name 
         *
         * @return string
         */
        function getPluginName()
        {
                return "JSXGraph";
        }
        
        
        /**
         * Get plugin name 
         *
         * @return string
         */
        function isValidParentType($a_parent_type)
        {
                if (in_array($a_parent_type, array("lm", "wpg")))
                {
                        return true;
                }
                return false;
        }
        
        /**
         * Get Javascript files
         */
        function getJavascriptFiles()
        {
                return array("js/jsxgraphcore.js");
        }
        
        /**
         * Get css files
         */
        function getCssFiles()
        {
                return array("css/jsxgraph.css");
        }
 
}
 
?>
