/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var $menu = $('menu');
$document.ready(function() {
    alert('width:'+window.innerWidth+' height:'+window.innerHeight+ ' client'+ isMobile.any());
    $menu.on('click touch', function() {
        $document.trigger('page-unload');
    });
});

$document.on('page-load', function() {
    console.log('page loaded');
    $body.removeClass('slide-right');
    $body.addClass('slide-left');
});
$document.on('page-unload', function() {
    $body.removeClass('slide-left');
    $body.addClass('slide-right');
    $(document).trigger('page-'+site.page+'-leave');
    $(document.body).removeClass(site.page);
});
$document.on('page-media-enter', function() {
    console.log('page media enter');
    /*
    var gallery = document.getElementById('gallery');
    var path = site.gallery.lowres;
    var width = window.outerWidth;
    var height = window.outerHeight - 150;

    switch(true) {

        case window.outerHeight<1000:
            height = 800;
        case window.outerHeight<800:
            height = 700;  
        case window.outerHeight<700:    
            height = 600; 
        case window.outerHeight<600:
            height = 500;
        case window.outerHeight<500:
            height = 400;    
    }
    path = 'img-'+width+'-'+height+'/gallery/';
    site.gallery.items.forEach(function(item, index) {
        var img = document.createElement('img');
            img.className = 'img-'+index;
            img.dataset.high = path + item.src;
            img.src = 'img-370-auto/gallery/' + item.src;
            img.onclick = function() {
                $body.addClass('blur');
                site.float(img);
            };
            gallery.appendChild(img);
    });*/
});
$document.on('page-media-leave', function() {
    console.log('page media leave');
    $body.removeClass('blur');
});


$document.on('page-gallery-enter', function() {
    console.log('page gallery enter');
    window.location.hash = 'gallery';
    $document.off('keyup');
    $document.off('hashchange');
    $document.on('keyup',function(e) {
        if (e.keyCode === 27) {
            $document.trigger('page-gallery-leave');
            if (window.location.hash === '#gallery') window.location.hash = 'media';
        }
    });
    $(window).on('hashchange', function(e) {
        if (window.location.hash !== '#gallery') $document.trigger('page-gallery-leave');
    });
});
$document.on('page-gallery-leave', function() {
    console.log('page gallery leave');
    $document.off('keyup');
    $document.off('hashchange');
    $body.removeClass('blur');
});

