<?php

/**
 * Copyright (c) 2016 IZUS/TIK, Universität Stuttgart
 * GPLv3, see gpl-3.0.txt.
 */

include_once './Services/COPage/classes/class.ilPageComponentPlugin.php';

/**
 * JSXGraph user interface plugin.
 *
 * @author Per Pascal Grube <pascal.grube@tik.uni-stuttgart.de>
 *
 * @version $Id$
 */
class ilJSXGraphPlugin extends ilPageComponentPlugin
{
        /**
         * Get plugin name.
         *
         * @return string
         */
        public function getPluginName()
        {
            return 'JSXGraph';
        }

        /**
         * Get plugin name.
         *
         * @return string
         */
        public function isValidParentType($a_parent_type)
        {
            if (in_array($a_parent_type, array('lm', 'wpg', 'qpl', 'qfbg', 'qfbs', 'qht'))) {
                return true;
            }

            return false;
        }

        /**
         * Get Javascript files.
         */
        public function getJavascriptFiles($a_mode)
        {
            return array('js/jsxgraphcore.js');
        }

        /**
         * Get css files.
         */
        public function getCssFiles($a_mode)
        {
            return array('css/jsxgraph.css');
        }
}
