function validateForm(form) {
    if (!form.checkValidity()) {
        if (form.reportValidity) {
            form.reportValidity();
            notify('All fields with asteriks (*) are required!', 'warning');
        } else {
            //warn IE users somehow
            notify('Form validation failed! Kindly fill form fields appropriately and try again.', 'warning');
        }
        return false;
    }
    return true;
}