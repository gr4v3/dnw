/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$document.on('ready', function() {
    console.log('ready');
    
});
$document.on('page-load', function(event, $origin) {
    console.log('page loaded');
    $origin.find('form').each(function(index) {
        var page = window.location.hash.replace("#", "");
        var name = 'form-' + page + '-' + index;
        var reset = false;
        this.target = name;
        this.method = 'post';
        this.action = '?page='+page+'&form=true';
        for(var index = 0;index<this.elements.length;index++) {
            if (this.elements[index].type === 'reset') reset = this.elements[index];
        }
        if (!$('iframe[name='+name+']').length) {
            var iframe = document.createElement('iframe');
                iframe.name = name;
                iframe.className = 'hide';
                iframe.onload = function() {
                    this.onload = function() {
                        if (reset) reset.click();
                    };
                };
                $origin[0].appendChild(iframe);
        }  
    });
});
$document.on('page-unload', function() {
    console.log('page unloaded');
    //$(document).trigger('page-'+site.page+'-leave');
});
$document.on('page-history-enter', function() {
    console.log('page history enter');
    var editor = new wysihtml5.Editor("textarea", {
            toolbar:"toolbar",
            stylesheets:  "css/stylesheet.css",
            parserRules:  wysihtml5ParserRules
        });
        editor.on("change", function() {
            this.textarea.element.form.submit();
        });
});
$document.on('page-contacts-enter', function() {
    console.log('page contacts enter');
    var editor = new wysihtml5.Editor("textarea", {
            toolbar:"toolbar",
            stylesheets:  "css/stylesheet.css",
            parserRules:  wysihtml5ParserRules
        });
        editor.on("change", function() {
            this.textarea.element.form.submit();
        });
});