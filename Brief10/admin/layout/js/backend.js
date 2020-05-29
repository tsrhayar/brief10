$(function () {
    //  Hide placeholder on focus
    $('[placeholder]').focus(function () {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'))
    });

    $('input').each(function () {
        if ($(this).attr('required')) {
            $(this).after('<span class="requiredEtoile">*</span>');
        }
    });

    $('.confirm').click(function () {
        return confirm('vous voulez vraiment supprimez??');
    });
});
