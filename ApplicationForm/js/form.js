// Get elements
const pensionCheckbox = document.getElementById('pensionCheckbox');
const pensionOptions = document.getElementById('pensionOptions');
const sssRadio = document.getElementById('sssRadio');
const sssOptions = document.getElementById('sssOptions');

// Show/hide pensionOptions when the pension checkbox is checked/unchecked
pensionCheckbox.addEventListener('change', function () {
    if (this.checked) {
        pensionOptions.style.display = 'block';
    } else {
        pensionOptions.style.display = 'none';
        // Reset the SSS options visibility when unchecking
        sssOptions.style.display = 'none';
    }
});

// Show/hide SSS options when the SSS radio button is selected
document.querySelectorAll('input[name="pension_type"]').forEach(radio => {
    radio.addEventListener('change', function () {
        if (this.value === 'sss' && pensionCheckbox.checked) {
            sssOptions.style.display = 'block';
        } else {
            sssOptions.style.display = 'none';
        }
    });
});