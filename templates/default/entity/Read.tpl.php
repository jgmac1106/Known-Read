<article class="p-read-of">
            <h2 style="display: none" >
               Read <?= htmlentities(strip_tags($vars['object']->getTitle()), ENT_QUOTES, 'UTF-8'); ?>
            </h2>
            
            <div class="h-cite">                    
                <?php
                    if ($attachments = $vars['object']->getAttachments()) {
                        foreach ($attachments as $attachment) {
                            $mainsrc = $attachment['url'];
                            if (!empty($vars['object']->thumbnail_large)) {
                                $src = $vars['object']->thumbnail_large;
                            } else if (!empty($vars['object']->thumbnail)) { // Backwards compatibility
                                $src = $vars['object']->thumbnail;
                            } else {
                                $src = $mainsrc;
                            }
                            
                            // Patch to correct certain broken URLs caused by https://github.com/idno/known/issues/526
                            $src = preg_replace('/^(https?:\/\/\/)/', \Idno\Core\site()->config()->getDisplayURL(), $src);
                            $mainsrc = preg_replace('/^(https?:\/\/\/)/', \Idno\Core\site()->config()->getDisplayURL(), $mainsrc);
                            
                            ?>
                            <a href="<?= $this->makeDisplayURL($mainsrc) ?>"><img src="<?= $this->makeDisplayURL($src) ?>" style="float: left; margin: 0 2em 1em 0; max-width: 150px" class="u-photo"/></a>
                        <?php
                        }
                    }
                ?>
                <h2>
                    <?php
                    if ($vars['object']->readType == 'book') {
                    ?>
                    <i class="fa fa-book"></i>
                    <?php
                    } else if ($vars['object']->readType == 'website') {
                    ?>
                    <i class="fa fa-rss"></i>
                    <?php
                    } else if ($vars['object']->readType == 'audiobook') {
                    ?>
                    <i class="fa fa-volume-up"></i>
                    <?php         
                    } else if ($vars['object']->readType == 'journal') {
                    ?>
                    <i class="fa fa-newspaper-o"></i>
                    <?php
                    }
                    if (empty($vars['object']->getMediaURL())) {
                    ?>
                    Read <span class="p-name"><?= htmlentities(strip_tags($vars['object']->getTitle()), ENT_QUOTES, 'UTF-8'); ?></span>
                    <?php
                    } else {
                    ?>
                   Read <a href="<?= $vars['object']->getMediaURL() ?>" class="p-name"><?= htmlentities(strip_tags($vars['object']->getTitle()), ENT_QUOTES, 'UTF-8'); ?></a>
                    <?php
                    }
                    ?>
                </h2>
            </div>
            <div class="e-content">
                <?= $this->__(['value' => $vars['object']->body, 'object' => $vars['object']])->draw('forms/output/richtext'); ?>

                <?php
                if (!empty($vars['object']->getreadauthor())) {
                ?>
                <p style="font-style: italic; text-align: right;">By  <?= $vars['object']->getreadauthor() ?></p>
                <?php
                }
                ?>                

            </div>
            
            <div style="display: none;">
                <p class="h-card vcard p-author">
                    <a href="<?= $vars['object']->getOwner()->getURL(); ?>" class="icon-container">
                        <img class="u-logo logo u-photo photo" src="<?= $vars['object']->getOwner()->getIcon(); ?>"/>
                    </a>
                    <a class="p-name fn u-url url" href="<?= $vars['object']->getOwner()->getURL(); ?>"><?= $vars['object']->getOwner()->getName(); ?></a>
                    <a class="u-url" href="<?= $vars['object']->getOwner()->getURL(); ?>">
                        <!-- This is here to force the hand of your MF2 parser --></a>
                </p>
            </div>
</article>
