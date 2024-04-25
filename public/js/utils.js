function fillFormdata(data) {
    for(const [key, value] of Object.entries(data)) {
        const inputElement = $(`#${key}`);

        if(inputElement.attr('type') == 'file') {
            inputElement.parent().css('background-image', `url(/storage/${value})`);
        } else {
            inputElement.val(value);
        }
    }
}

function removeFormErrors() {
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').html('');
}

function displayFormErrors(errors) {
    for(const [key, value] of Object.entries(errors)) {
        const input = $(`#${key}`);

        input.addClass('is-invalid');
        input.next().html(value[0]);
    }
}
