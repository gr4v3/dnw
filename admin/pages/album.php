<?php
include_once '../utilities.php';
$album = filter_input(INPUT_GET, 'index');
$mode = filter_input(INPUT_GET, 'mode'); 
if ($mode === 'erase') {
    rrmdir('../../gallery/' . $album);
    header('location: /admin/pages/media.php');
}
$gallery = folder('../../gallery/' . $album);
?>
<form>
    <h1><?php echo $album; ?></h1>
    <input type="hidden" name="album[name]" value="<?php echo $album; ?>"/>
    <div>
        <label for="description">Descrição</label>
        <input id="description" type="text" name="album[description]" value="<?php echo $gallery->info->description; ?>" />
    </div>
    <div>
        <label for="album">Conteúdo</label>
        <div class="gallery">
            <?php 
                foreach($gallery->files as $item) {
                    ?>
                    <div class="item" style="background-image: url(../../img-320-200/gallery/<?php echo $album; ?>/<?php echo $item; ?>);">
                        <textarea name="album[file][<?php echo $item; ?>]"><?php echo $gallery->info->file->{$item}; ?></textarea>
                    </div>
                    <?php
                }
            ?>
        </div>  
    </div>
    <div>
        <input type="reset" value="cancelar" data-type="ajax" data-target="article" data-href="pages/media.php" />
        <input type="submit" value="guardar" />
    </div>  
</form>