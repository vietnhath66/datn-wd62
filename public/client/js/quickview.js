$(document).ready(function() {
    $('.js-show-modal1').on('click', function(e) {
        e.preventDefault();
        var productId = $(this).data('id');

        $.ajax({
            url: '/product/' + productId + '/quick-view',
            type: 'GET',
            success: function(response) {
                $('#quickViewModal .modal-body').html(response);
                $('#quickViewModal').modal('show');
            },
            error: function() {
                alert('Failed to load product details.');
            }
        });
    });
});