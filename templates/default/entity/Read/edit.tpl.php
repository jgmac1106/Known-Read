<?= $this->draw('entity/edit/header'); ?>
<?php

    $autosave = new \Idno\Core\Autosave();
    if (!empty($vars['object']->body)) {
        $body = $vars['object']->body;
    } else {
        $body = $autosave->getValue('read', 'bodyautosave');
    }
    if (!empty($vars['object']->title)) {
        $title = $vars['object']->title;
    } else {
        $title = $autosave->getValue('read', 'title');
    }
    if (!empty($vars['object']->readauthor)) {
        $listenauthor = $vars['object']->readauthor;
    } else {
        $listenauthor = $autosave->getValue('read', 'readauthor');
    }
    if (!empty($vars['object']->readType)) {
        $listenType = $vars['object']->readType;
    } else {
        $listenType = $autosave->getValue('read', 'readType');
    }
    if (!empty($vars['object']->mediaURL)) {
        $mediaURL = $vars['object']->mediaURL;
    } else {
        $mediaURL = $autosave->getValue('read', 'mediaURL');
    }
    if (!empty($vars['object'])) {
        $object = $vars['object'];
    } else {
        $object = false;
    }

    /* @var \Idno\Core\Template $this */

?>
    <form action="<?= $vars['object']->getURL() ?>" method="post" enctype="multipart/form-data">

        <div class="row">

            <div class="col-md-8 col-md-offset-2 edit-pane">


                <?php

                    if (empty($vars['object']->_id)) {

                        ?>
                        <h4>What is tickling your literary fancy?</h4>
                    <?php

                    } else {

                        ?>
                        <h4>Edit what you read</h4>
                    <?php

                    }

                ?>

                <?php

                    if (empty($vars['object']->_id) || empty($vars['object']->getAttachments())) {

                        ?>
                        <div id="photo-preview"></div>
                        <p>
                                <span class="btn btn-primary btn-file">
                                        <i class="fa fa-camera"></i> <span
                                        id="photo-filename">Select a photo</span> <input type="file" name="photo"
                                                                                         id="photo"
                                                                                         class="col-md-9 form-control"
                                                                                         accept="image/*;capture=camera"
                                                                                         onchange="photoPreview(this)"/>

                                    </span>
                        </p>

                    <?php

                    }

                ?>
                <div class="content-form">

                    <style>
                        .readType-block {
                            margin-bottom: 1em;
                        }
                    </style>
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" placeholder="The title of what your read, reading, or want to read" value="<?= htmlspecialchars($title) ?>" class="form-control"/>                    
                    
                    <label for="title">Media Link</label>
                    <input type="text" name="mediaURL" id="mediaURL" placeholder="Link to book, website, or audiobook" value="<?= htmlspecialchars($mediaURL) ?>" class="form-control"/>                    
                    
                    <!-- styled read type -->
                    <label for="readType">What's the medium?</label>
                    <div class="readType-block">
                        <input type="hidden" name="readType" id="readType-id" value="<?= $readType ?>">
                        <div id="readType" class="readType">
                            <div class="btn-group">
                                <a class="btn dropdown-toggle readType" data-toggle="dropdown" href="#" id="readType-button" aria-expanded="false">
                                    <i class="fa fa-book"></i> Book <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" data-readType="Website" class="readType-option"><i class="fa fa-rss"></i>website</a></li>
                    <li><a href="#" data-listenType="audiobook" class="readType-option"><i class="fa fa-volume-up"></i>audiobook</a></li>
                                    <li><a href="#" data-listenType="journal" class="readType-option"><i class="fa fa-file-text-o"></i>Article or Journal</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <style>
                        a.readType {
                            background-color: #fff;
                            background-image: none;
                            border: 1px solid #cccccc;
                            box-shadow: none;
                            text-shadow: none;
                            color: #555555;
                        }

                        .readType .caret {
                                border-top: 4px solid #555;
                        }
                    </style>
                    <script>
                        $(document).ready(function () {
                            $('.readType-option').each(function () {
                                if ($(this).data('readType') == $('#readType-id').val()) {
                                    $('#readType-button').html($(this).html() + ' <span class="caret"></span>');
                                }
                            })
                        });
                        $('.readType-option').on('click', function () {
                            $('#readType-id').val($(this).data('readType'));
                            $('#readType-button').html($(this).html() + ' <span class="caret"></span>');
                            $('#readType-button').click();
                            return false;
                        });
                       
                        $('#readType-id').on('change', function () {
                        });
                    </script>
                    <!-- end styled watch type -->
                     
                    <label for="readauthor">Author</label>
                    <input type="text" name="readauthor" id="readauthor" placeholder="Who is the author?" value="<?= htmlspecialchars($readauthor) ?>" class="form-control"/>                    
                </div>
                
                <label for="body">Summary</label>
                <?= $this->__([
                    'name' => 'body',
                    'value' => $body,
                    'object' => $object,
                    'wordcount' => true
                ])->draw('forms/input/richtext')?>
                <?= $this->draw('entity/tags/input'); ?>

                <?php if (empty($vars['object']->_id)) echo $this->drawSyndication('article'); ?>
                <?php if (empty($vars['object']->_id)) { ?><input type="hidden" name="forward-to" value="<?= \Idno\Core\site()->config()->getDisplayURL() . 'content/all/'; ?>" /><?php } ?>
                
                <?= $this->draw('content/access'); ?>

                <p class="button-bar ">
                    
                    <?= \Idno\Core\site()->actions()->signForm('/read/edit') ?>
                    <input type="button" class="btn btn-cancel" value="Cancel" onclick="tinymce.EditorManager.execCommand('mceRemoveEditor',false, 'body'); hideContentCreateForm();"/>
                    <input type="submit" class="btn btn-primary" value="Publish"/>

                </p>

            </div>

        </div>
    </form>

    <script>
        //if (typeof photoPreview !== function) {
        function photoPreview(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#photo-preview').html('<img src="" id="photopreview" style="display:none; width: 400px">');
                    $('#photo-filename').html('Choose different photo');
                    $('#photopreview').attr('src', e.target.result);
                    $('#photopreview').show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        //}
    </script>

    <div id="bodyautosave" style="display:none"></div>
<?= $this->draw('entity/edit/footer'); ?>

