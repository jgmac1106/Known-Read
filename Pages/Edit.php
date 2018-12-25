<?php

    namespace IdnoPlugins\Read\Pages {

        use Idno\Core\Autosave;

        class Edit extends \Idno\Common\Page {

            function getContent() {

                $this->createGatekeeper();    // This functionality is for logged-in users only

                // Are we loading an entity?
                if (!empty($this->arguments)) {
                    $object = \IdnoPlugins\Read\Read::getByID($this->arguments[0]);
                } else {
                    $object = new \IdnoPlugins\Read\Read();
                }

                $t = \Idno\Core\site()->template();
                $body = $t->__(array(
                    'object' => $object
                ))->draw('entity/Read/edit');

                if (empty($vars['object']->_id)) {
                    $title = 'What is ticklign your literary fancy?';
                } else {
                    $title = 'Edit what you read';
                }

                if (!empty($this->xhr)) {
                    echo $body;
                } else {
                    $t->__(array('body' => $body, 'title' => $title))->drawPage();
                }
            }

            function postContent() {
                $this->createGatekeeper();

                $new = false;
                if (!empty($this->arguments)) {
                    $object = \IdnoPlugins\Read\Read::getByID($this->arguments[0]);
                }
                if (empty($object)) {
                    $object = new \IdnoPlugins\Read\Read();
                }

                if ($object->saveDataFromInput($this)) {
                    (new \Idno\Core\Autosave())->clearContext('Read');
                    $forward = $this->getInput('forward-to', $object->getDisplayURL());
                    $this->forward($forward);
                }

            }

        }

    }
