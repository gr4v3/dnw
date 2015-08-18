
var site = {
    root:function(root) {
        return $(root || document.body);
    },
    requests:function(root) {
        var that = this;
        this.root(root).find('*[data-type=ajax]').each(function() {
            var $this = $(this);
            var target = $this.attr('data-target');
            var singlehref = $this.attr('data-href');
            var doublehref = $this.attr('data-double-href');
            var triggermenu = $this.attr('data-trigger-menu');
            if (singlehref) $this.click(function() {
                if ($this.attr('data-confirm') && !confirm($this.attr('data-confirm'))) return false;
                that.load(target, singlehref);
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
        $('body').animate({
            scrollTop: $(target).offset().top + offset
        }, 750, function() {if (callback) callback(this);});  
    },
    load:function(target, href) {
        var that = this;
        var $target = $(target);
        href+= '?ajax=true';
        if ($target.length) $target.load(href, function() {
            that.requests($target);
            that.scrollTop($target);
            $(window).trigger('resize');  
        });
    }
};

$(document).ready(function() {
    site.requests();
});