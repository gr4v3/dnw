<?php
include_once '../utilities.php';
$gallery = folder('../../gallery');
?>
<div class="container">
    <div class="col-md-8">
        <form action="/admin/pages/media.php" method="post" enctype="multipart/form-data">
                <div class="col-md-8">
                    <label class="col-md-4" for="album">Novo album</label>
                    <input class="col-md-8" type="file" id="album" name="album[]" multiple/>
                </div>
                <div class="col-md-4">
                    <input class="pull-left" type="submit" value="upload"/>
                    <input class="pull-left" type="reset" value="cancelar" data-type="ajax" data-target="article" data-href="pages/media.php">
                </div>
        </form>
    </div>
    <div class="col-md-12">
    <?php 
        foreach($gallery->folders as $name => $album) {
            if (isset($album->files)) {
                
                ?>
    <div class="album">
        <?php
            $src = current($album->files);
        ?>
        <div class="big" style="background-image: url(../../img-auto-150/gallery/<?php echo $name; ?>/<?php echo $src; ?>);"></div>
        <?php
            if (next($album->files) !== false) {
                $src = current($album->files); 
                ?>
                <div class="small" style="background-image: url(../../img-auto-50/gallery/<?php echo $name; ?>/<?php echo $src; ?>);"></div>
                <?php
            }
        ?>
        <?php
            if (next($album->files) !== false) {
                $src = current($album->files); 
                ?>
                <div class="small" style="background-image: url(../../img-auto-50/gallery/<?php echo $name; ?>/<?php echo $src; ?>);"></div>
                <?php
            }
        ?>
        <?php
            if (next($album->files) !== false) {
                $src = current($album->files);
                ?>
                <div class="small" style="background-image: url(../../img-auto-50/gallery/<?php echo $name; ?>/<?php echo $src; ?>);"></div>
                <?php
            }
        ?>
                <div class="description"><?php echo $album->info->description; ?></div>
                <div class="fa fa-pencil" data-type="ajax" data-target="article" data-href="/admin/pages/album.php?index=<?php echo $name; ?>&mode=edit"></div>
                <div class="fa fa-trash-o" data-type="ajax" data-target="article" data-href="/admin/pages/album.php?index=<?php echo $name; ?>&mode=erase"></div>
    </div>
                <?php
            }
        }
    
    ?>
    </div>
</div>

