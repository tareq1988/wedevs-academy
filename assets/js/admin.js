;(function($) {

    $('table.wp-list-table.contacts').on('click', 'a.submitdelete', function(e) {
        e.preventDefault();

        if (!confirm(weDevsAcademy.confirm)) {
            return;
        }

        var self = $(this),
            id = self.data('id');

        // wp.ajax.send('wd-academy-delete-contact', {
        //     data: {
        //         id: id,
        //         _wpnonce: weDevsAcademy.nonce
        //     }
        // })
        wp.ajax.post('wd-academy-delete-contact', {
            id: id,
            _wpnonce: weDevsAcademy.nonce
        })
        .done(function(response) {

            self.closest('tr')
                .css('background-color', 'red')
                .hide(400, function() {
                    $(this).remove();
                });

        })
        .fail(function() {
            alert(weDevsAcademy.error);
        });
    });

})(jQuery);
