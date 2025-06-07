document.addEventListener('DOMContentLoaded', function () {
    const aadharInput = document.getElementById('aadhar');
    const panInput = document.getElementById('pan_num');
    const aadharPhotoInput = document.getElementById('aadhar_photo');
    const panPhotoInput = document.getElementById('pan_photo');
    const aadharPreview = document.getElementById('aadhar_preview');
    const panPreview = document.getElementById('pan_preview');
    const aadharError = document.getElementById('aadharError');
    const panError = document.getElementById('panError');

if (aadharInput) {
    // Aadhar number validation
    aadharInput.addEventListener('input', function () {
        const aadharNumber = aadharInput.value;
        const isValidAadhar = /^[2-9]{1}[0-9]{11}$/.test(aadharNumber);
        if (isValidAadhar) {
            aadharError.textContent = '';
        } else {
            aadharError.textContent = 'Invalid Aadhar number';
        }
    });
}else{}

    // PAN number validation
    panInput.addEventListener('input', function () {
        const panNumber = panInput.value.toUpperCase();
        panInput.value = panNumber; // Automatically capitalize input
        const isValidPan = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(panNumber);
        if (isValidPan) {
            panError.textContent = '';
        } else {
            panError.textContent = 'Invalid PAN number';
        }
    });

    // Aadhar photo preview
    if (aadharPhotoInput) {
    aadharPhotoInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                aadharPreview.src = e.target.result;
                aadharPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
}else{}

    // PAN photo preview
    panPhotoInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                panPreview.src = e.target.result;
                panPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
});
