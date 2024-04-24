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
