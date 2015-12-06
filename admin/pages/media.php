<?php
include_once '../utilities.php';
$gallery = folder('../../gallery');
?>
<div class="container-fluid">
    <div class="col-md-6">
        <form data-target="article" data-href="/admin/pages/media.php" method="post" enctype="multipart/form-data">
                <div class="col-md-5">
                    <label class="col-md-4" for="album">Novo album</label>
                    <input class="col-md-8" type="file" id="album" name="files[]" multiple/>
                </div>
                <div class="col-md-7">
                    <input class="col-md-4 pull-left" type="submit" value="upload"/>
                </div>
        </form>
    </div>
    <div class="col-md-12">
    <?php 
        foreach($gallery->folders as $name => $album) {
            if (isset($album->files)) {
                
                ?>
        <div class="col-md-3 album">
            <?php
                $src = current($album->files);
            ?>
            <div class="col-md-8 big" style="background-image: url(../../img-auto-150/gallery/<?php echo $name; ?>/<?php echo $src; ?>);"></div>
            <?php
                if (next($album->files) !== false) {
                    $src = current($album->files); 
                    ?>
                    <div class="col-md-4 small" style="background-image: url(../../img-auto-50/gallery/<?php echo $name; ?>/<?php echo $src; ?>);"></div>
                    <?php
                }
            ?>
            <?php
                if (next($album->files) !== false) {
                    $src = current($album->files); 
                    ?>
                    <div class="col-md-4 small" style="background-image: url(../../img-auto-50/gallery/<?php echo $name; ?>/<?php echo $src; ?>);"></div>
                    <?php
                }
            ?>
            <?php
                if (next($album->files) !== false) {
                    $src = current($album->files);
                    ?>
                    <div class="col-md-4 small" style="background-image: url(../../img-auto-50/gallery/<?php echo $name; ?>/<?php echo $src; ?>);"></div>
                    <?php
                }
            ?>
                    <div class="col-md-8 description"><?php echo $album->info->description; ?></div>
                    <div class="fa fa-pencil" data-type="ajax" data-target="article" data-href="/admin/pages/album.php?index=<?php echo $name; ?>&mode=edit"></div>
                    <div class="fa fa-trash-o" data-type="ajax" data-target="article" data-href="/admin/pages/album.php?index=<?php echo $name; ?>&mode=erase"></div>
        </div>
                <?php
            }
        }
    
    ?>
    </div>
</div>

