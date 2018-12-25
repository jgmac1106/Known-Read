<?php

    namespace IdnoPlugins\Read {

        class Main extends \Idno\Common\Plugin {

            function registerPages() {
                \Idno\Core\site()->addPageHandler('/read/edit/?', '\IdnoPlugins\Read\Pages\Edit');
                \Idno\Core\site()->addPageHandler('/read/edit/([A-Za-z0-9]+)/?', '\IdnoPlugins\Read\Pages\Edit');
                \Idno\Core\site()->addPageHandler('/read/delete/([A-Za-z0-9]+)/?', '\IdnoPlugins\Read\Pages\Delete');
                \Idno\Core\site()->addPageHandler('/read/([A-Za-z0-9]+)/.*', '\Idno\Pages\Entity\View');
                
                \Idno\Core\site()->addPageHandler('/read/webhook/', '\IdnoPlugins\Read\Pages\Endpoint', false);
            }

            /**
             * Get the total file usage
             * @param bool $user
             * @return int
             */
            function getFileUsage($user = false) {

                $total = 0;

                if (!empty($user)) {
                    $search = ['user' => $user];
                } else {
                    $search = [];
                }

                if ($reads = read::get($search,[],9999,0)) {
                    foreach($reads as $read) {
                        if ($read instanceof read) {
                            if ($attachments = $read->getAttachments()) {
                                foreach($attachments as $attachment) {
                                    $total += $attachment['length'];
                                }
                            }
                        }
                    }
                }

                return $total;
            }

        }

    }
