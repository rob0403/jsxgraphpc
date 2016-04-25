<?php

/**
 * Copyright (c) 2016 IZUS/TIK, Universität Stuttgart
 * GPLv3, see gpl-3.0.txt.
 */
include_once './Services/COPage/classes/class.ilPageComponentPluginGUI.php';

/**
 * JSXGraph user interface plugin.
 *
 *
 * @author Per Pascal Grube <pascal.grube@tik.uni-stuttgart.de>
 *
 * @version $Id$
 * @ilCtrl_isCalledBy ilJSXGraphPluginGUI: ilPCPluggedGUI
 */
class ilJSXGraphPluginGUI extends ilPageComponentPluginGUI
{
        /**
         * Execute command.
         *
         * @param
         *
         * @return
         */
        public function executeCommand()
        {
            global $ilCtrl;

            $next_class = $ilCtrl->getNextClass();

            switch ($next_class) {
                        default:
                                // perform valid commands
                                $cmd = $ilCtrl->getCmd();
                                if (in_array($cmd, array('create', 'save', 'edit', 'update', 'cancel'))) {
                                    $this->$cmd();
                                }
                                break;
                }
        }

        /**
         * Form for new elements.
         */
        public function insert()
        {
            global $tpl;

            $form = $this->initForm(true);
            $tpl->setContent($form->getHTML());
        }

        /**
         * Save new jsxgraph element.
         */
        public function create()
        {
            global $tpl, $lng, $ilCtrl;

            $form = $this->initForm(true);
            if ($form->checkInput()) {
                $properties = array(
                                'jsxcode' => $form->getInput('jsxcode'),
                                'graphbox' => $form->getInput('graphbox'),
                                'width' => $form->getInput('width'),
                                'height' => $form->getInput('height'),
                                );
                if ($this->createElement($properties)) {
                    ilUtil::sendSuccess($lng->txt('msg_obj_modified'), true);
                    $this->returnToParent();
                }
            }

            $form->setValuesByPost();
            $tpl->setContent($form->getHtml());
        }

        /**
         * Edit.
         *
         * @param
         *
         * @return
         */
        public function edit()
        {
            global $tpl;

            $this->setTabs('edit');

            $form = $this->initForm();
            $tpl->setContent($form->getHTML());
        }

        /**
         * Update.
         *
         * @param
         *
         * @return
         */
        public function update()
        {
            global $tpl, $lng, $ilCtrl;

            $form = $this->initForm(true);
            if ($form->checkInput()) {
                $properties = array(
                                'jsxcode' => $form->getInput('jsxcode'),
                                'graphbox' => $form->getInput('graphbox'),
                                'width' => $form->getInput('width'),
                                'height' => $form->getInput('height'),
                );
                if ($this->updateElement($properties)) {
                    ilUtil::sendSuccess($lng->txt('msg_obj_modified'), true);
                    $this->returnToParent();
                }
            }

            $form->setValuesByPost();
            $tpl->setContent($form->getHtml());
        }

        /**
         * Init editing form.
         *
         * @param        int        $a_mode        Edit Mode
         */
        public function initForm($a_create = false)
        {
            global $lng, $ilCtrl,  $tpl;

            include_once 'Services/Form/classes/class.ilPropertyFormGUI.php';
            $form = new ilPropertyFormGUI();

                // value two
                $v2 = new ilTextInputGUI($this->getPlugin()->txt('width'), 'width');
            $v2->setMaxLength(40);
            $v2->setSize(40);
            $form->addItem($v2);

            $v3 = new ilTextInputGUI($this->getPlugin()->txt('height'), 'height');
            $v3->setMaxLength(40);
            $v3->setSize(40);
            $form->addItem($v3);

            $pl = $this->getPlugin();
            $edittpl = $pl->getTemplate('tpl.editor.html');
            $edittpl->setVariable('BASEDIR', $pl->getDirectory());
            $edittpl->setVariable('TXT_RUN_CODE', $pl->txt('runcode'));

            if (!$a_create) {
                $prop = $this->getProperties();
                $edittpl->setVariable('GRAPHBOX', $prop['graphbox']);
                $edittpl->setVariable('JSXCODE', $prop['jsxcode']);
                $edittpl->setVariable('HEIGHT', $prop['height']);
                $edittpl->setVariable('WIDTH', $prop['width']);
                $uniqid = $prop ['graphbox'];
            } else {
                $uniqid = uniqid('jsxgraphbox');
                $edittpl->setVariable('GRAPHBOX', $uniqid);
                $edittpl->setVariable('JSXCODE', "var brd = JXG.JSXGraph.initBoard('".$uniqid."', {boundingbox: [-2, 2, 2, -2]});");
                $edittpl->setVariable('HEIGHT', '500');
                $edittpl->setVariable('WIDTH', '500');
            }

            $jsxID = new ilNonEditableValueGUI($this->getPlugin()->txt('jsxID'), 'jsxID');
            $jsxID->setValue($uniqid);
            $jsxID->setInfo($this->getPlugin()->txt('jsxID_info'), 'jsxID_info');
            $form->addItem($jsxID);

            $acehtml = $edittpl->get();
            $v1 = new ilCustomInputGUI($this->getPlugin()->txt('jsxpreview'));
            $v1->setHTML($acehtml);
            $v1->setInfo($this->getPlugin()->txt('jsxcode_info'), 'jsxcode_info');
            $form->addItem($v1);

            if (!$a_create) {
                $prop = $this->getProperties();
                $v2->setValue($prop['width']);
                $v3->setValue($prop['height']);
            } else {
                $v2->setValue(500);
                $v3->setValue(500);
            }
                // save and cancel commands
                if ($a_create) {
                    $this->addCreationButton($form);
                    $form->addCommandButton('cancel', $lng->txt('cancel'));
                    $form->setTitle($this->getPlugin()->txt('cmd_insert'));
                } else {
                    $form->addCommandButton('update', $lng->txt('save'));
                    $form->addCommandButton('cancel', $lng->txt('cancel'));
                    $form->setTitle($this->getPlugin()->txt('edit_ex_el'));
                }

            $form->setFormAction($ilCtrl->getFormAction($this));

            return $form;
        }

        /**
         * Cancel.
         */
        public function cancel()
        {
            $this->returnToParent();
        }

        /**
         * Get HTML for element.
         *
         * @param string $a_mode (edit, presentation, preview, offline)s
         *
         * @return string $html
         */
        public function getElementHTML($a_mode, array $a_properties, $a_plugin_version)
        {
            $pl = $this->getPlugin();
            $tpl = $pl->getTemplate('tpl.content.html');
#                $tpl->setVariable("JSXCODE", str_replace("&#13;","",$a_properties["jsxcode"]));
                $tpl->setVariable('JSXCODE', html_entity_decode($a_properties['jsxcode']));
            $tpl->setVariable('HEIGHT', $a_properties['height']);
            $tpl->setVariable('WIDTH', $a_properties['width']);
            $tpl->setVariable('GRAPHBOX', $a_properties['graphbox']);

            return $tpl->get();
        }

        /**
         * Set tabs.
         *
         * @param
         *
         * @return
         */
        public function setTabs($a_active)
        {
            global $ilTabs, $ilCtrl;

            $pl = $this->getPlugin();

            $ilTabs->addTab('edit', $pl->txt('settings_1'),
                        $ilCtrl->getLinkTarget($this, 'edit'));

            $ilTabs->activateTab($a_active);
        }
}
