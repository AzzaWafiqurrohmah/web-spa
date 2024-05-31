function fillFormdata(data) {
    for(const [key, value] of Object.entries(data)) {
        const inputElement = document.getElementById(key);


        if (inputElement !== null) {
            if(inputElement.tagName !== 'INPUT'){
                inputElement.textContent = value;
            }

            if(inputElement.getAttribute('type') === 'file') {
                inputElement.parentElement.style.backgroundImage = `url(/storage/${value})`;
            }

            if(inputElement.getAttribute('type') === 'password') {
                inputElement.value = null;
            }

            if(inputElement.tagName === 'INPUT' &&
                inputElement.getAttribute('type') !== 'file' &&
                inputElement.tagName !== 'SELECT' &&
                inputElement.getAttribute('type') !== 'password'){

                inputElement.value = value;
            }
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
