<?php
include_once '../utilities.php';
$gallery = folder('../../gallery');
?>
<div class="content">
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

