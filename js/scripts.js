
(function() {
    var $nav = $('.nav');
    var $ul = $nav.find('ul');
        $ul.find('li a').on('click touch', function() {
            var $this = $(this);
            if ($ul.data('lastmenuitem')) $ul.data('lastmenuitem').removeClass('active');
            $this.addClass('active');
            $ul.data('lastmenuitem', $this);
			if (!$nav.data('backfaded')) {
				$nav.data('backfaded', true);
				$nav.addClass('backfaded');
			}
        });
    
})();