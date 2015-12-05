//1360x588 mac
//1280x687
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
    },
    any: function() {
        if (window.location.origin === 'http://dnw-dev.com') return false;
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};
var site = {
    gallery:{},
    page:false,
    root:function(root) {
        return $(root || document.body);
    },
    requests:function(root) {
        var that = this;
        this.root(root).find('*[data-type=ajax]').each(function() {
            var $this = $(this);
            var singlehref = $this.attr('data-href');
            var doublehref = $this.attr('data-double-href');
            var triggermenu = $this.attr('data-trigger-menu');
            if (singlehref) $this.on('click touch', function() { 
                if ($this.attr('data-confirm') && !confirm($this.attr('data-confirm'))) return false;
                that.load($this, singlehref);
            });
            if (doublehref) {
                $this.on('click touch', function() {
                    var that = this;
                    this.timer = setTimeout(function() {
                        if (that.control) that.control.click();
                    }, 220);
                    return false;
                });
                $this.dblclick(function() {
                    window.clearInterval(this.timer);
                    if ($this.attr('data-confirm') && !confirm($this.attr('data-confirm'))) return false;
                    that.load($this, doublehref);
                });
            }
            if (triggermenu) {
                $this.on('click touch', function() {
                    $('.nav ' + triggermenu).trigger('click');
                }); 
            }
        });  
    },
    scrollTop:function(target, offset) {
        if (!offset) offset = 0;
        $('body').animate({
            scrollTop: $(target).offset().top + offset
        }, 750, function() {
            console.log('scrolled to target!');
        });  
    },
    load:function($trigger, href) {
        var that = this;
        var $target = $($trigger.attr('data-target'));
        if (href.indexOf('?')>-1) href+= '&ajax=true'; else href+= '?ajax=true';
        if (this.page) $document.trigger('page-unload');
        if ($target.length) $target.load(href, function() {
            $(document).trigger('page-load', [$target]);
            that.page = $trigger.attr('id');
            $(document.body).addClass(that.page);
            $(document).trigger('page-' + that.page + '-enter', [$target]);
            if (isMobile.any()) {} else that.scrollTop($target);
            that.requests($target);
        });
    },
    center:function(hightlight, gallery_container) {
        var float = document.getElementById('float');
        var left = gallery_container.offsetWidth - float.offsetWidth;
        var selected = float.getElementsByClassName(hightlight);
        if (selected.length) var current = 0 - ((selected[0].parentNode.offsetLeft) - (float.offsetWidth / 2) + (selected[0].parentNode.offsetWidth/2)) - 5;
        else var current = 0;
        if (Math.abs(current)>left) current = 0 - left;
        if (current>0) current = 0;
        float.dataset.offset = current;
        gallery_container.style.left = current + 'px';
        gallery_container.dataset.current = hightlight;
    },
    float:function(element) {
        $document.trigger('page-gallery-enter');
        var float = document.getElementById('float');
        if (!float) {
            float = document.createElement('div');
            float.id = 'float';
            document.body.appendChild(float);
        }
        if (float.dataset.rendered) {
            this.center(element.className, float.table);
            return false;
        };
        console.log('gallery rendering for the first time!');
        var gallery = element.parentNode;
        var img = gallery.firstChild;
        var table = document.createElement('table');
            table.draggable = false;
        var tr = document.createElement('tr');
        while(img) {
            var td = document.createElement('td');
            var clone = img.cloneNode();
                clone.src = img.dataset.high;
                img.dataset.high = null;
                clone.draggable = false;
                td.appendChild(clone);
                tr.appendChild(td);
            img = img.nextSibling;
        }
        table.appendChild(tr);
        float.appendChild(table);
        float.dataset.rendered = true;
        float.table = table;
        var that = this;
        this.center(element.className, float.table); 
        var $float = $(float); 
            $float.bind('dragstart', function(event) {event.preventDefault(); });
        $float.swipe({
            //Generic swipe handler for all directions
            swipeRight:function() {
                var selected = float.getElementsByClassName(float.table.dataset.current);
                if (selected.length && selected[0].parentNode.previousSibling) {
                    var prev = selected[0].parentNode.previousSibling.firstChild;
                    that.center(prev.className, float.table);
                }
            },
            swipeLeft:function() {
                var selected = float.getElementsByClassName(float.table.dataset.current);
                if (selected.length && selected[0].parentNode.nextSibling) {
                    var next = selected[0].parentNode.nextSibling.firstChild;
                    that.center(next.className, float.table);
                }
            },
            swipeUp:function() {
                window.location.hash = 'media';
            },
            swipeDown:function() {
                window.location.hash = 'media';
            },
            //Default is 75px, set to 0 for demo so any distance triggers swipe
            threshold:5
        });
    }
};
var $document = $(document);
var $body = $document.find('body');
$document.ready(function() {
    site.requests(document.body);
    var $target = $(window.location.hash);
    if ($target.length) $target.trigger('click');
});