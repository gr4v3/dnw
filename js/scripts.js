
var site = {
    root:function(root) {
        return $(root || document.body);
    },
    requests:function(root, callback) {
        var that = this;
        this.root(root).find('*[data-type=ajax]').each(function() {
            var $this = $(this);
            var target = $this.attr('data-target');
            var singlehref = $this.attr('data-href');
            var doublehref = $this.attr('data-double-href');
            var triggermenu = $this.attr('data-trigger-menu');
            if (singlehref) $this.on('click touch', function() { 
                if ($this.attr('data-confirm') && !confirm($this.attr('data-confirm'))) return false;
                that.load(target, singlehref, callback);
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
                    that.load(target, doublehref);
                });
            }
            if (triggermenu) {
                $this.on('click touch', function() {
                    $('.nav ' + triggermenu).trigger('click');
                });
                
            }
        });  
    },
    scrollTop:function(target, offset, callback) {
        if (!offset) offset = 0;
        if (!callback) callback = function(){};
        $('body').animate({
            scrollTop: $(target).offset().top + offset
        }, 750, callback);  
        
    },
    load:function(target, href, callback) {
        var that = this;
        var $target = $(target);
        href+= '?ajax=true';
        if ($target.length) $target.load(href, function() {
            if (callback) callback($target);
            that.requests($target, callback);
            //that.scrollTop($target, 0, callback);
            $(window).trigger('resize');  
        });
    }
};

$(document).ready(function() {
    var $body = $('body');
    var $header = $('header');
    var $section = $('section');
    var $menu = $('menu');
    site.requests(document.body, function() {
        console.log('page loaded');
        $body.removeClass('slide-right');
        $body.addClass('slide-left');
    });
    $menu.on('click touch', function() {
        $body.removeClass('slide-left');
        $body.addClass('slide-right');
    });
});