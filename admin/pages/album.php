<?php
include_once '../utilities.php';
$album = filter_input(INPUT_GET, 'index');
$mode = filter_input(INPUT_GET, 'mode'); 
$file = filter_input(INPUT_GET, 'file');
if ($mode === 'erase') {
    if (empty($file)) {
        rrmdir('../../gallery/' . $album);
        header('location: /admin/pages/media.php');
    } else {
        unlink('../../gallery/' . $album . '/' . $file);
    }
    
}
$gallery = folder('../../gallery/' . $album);
?>
<div class="container-fluid">
    <form method="post" enctype="multipart/form-data" data-target="article" data-href="/admin/pages/album.php?index=<?php echo $album; ?>&mode=edit">
        <h1><?php echo $album; ?></h1>
        <input type="hidden" name="album[name]" value="<?php echo $album; ?>"/>
        <div class="col-md-12">
            <label class="col-md-4" for="description">Descrição</label>
            <input class="col-md-8" id="description" type="text" name="album[description]" value="<?php echo $gallery->info->description; ?>" />
        </div>
        <div class="col-md-12">
            <label class="col-md-4" for="files">Mais fotos</label>
            <input class="col-md-8" type="file" id="files" name="files[]" multiple/>
        </div>
        <div class="col-md-12">
            <label class="col-md-4" for="album">Conteúdo</label>
            <div class="col-md-8 gallery">
                <?php 
                    foreach($gallery->files as $item) {
                        ?>
                        <div class="col-md-4 col-lg-3 item">
                            <div class="image" style="background-image: url(../../img-320-200/gallery/<?php echo $album; ?>/<?php echo $item; ?>);"></div>
                            <div class="fa fa-trash-o" data-type="ajax" data-target="article" data-href="/admin/pages/album.php?index=<?php echo $album; ?>&file=<?php echo $item; ?>&mode=erase"></div>
                            <textarea name="album[file][<?php echo $item; ?>]"><?php echo $gallery->info->file->{$item}; ?></textarea>
                        </div>
                        <?php
                    }
                ?>
            </div>  
        </div>
        <div class="col-md-12">
            <input type="reset" value="cancelar" data-type="ajax" data-target="article" data-href="pages/media.php" />
            <input type="submit" value="guardar" />
        </div>  
    </form>
</div>