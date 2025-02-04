document.addEventListener('DOMContentLoaded', function () {
    /*
Published by Mizegerd.agency
*/
    const form = document.getElementById('contact-form');
    const formSteps = document.querySelectorAll('.form-step');
    const nextButtons = document.querySelectorAll('.btn-next');
    const prevButtons = document.querySelectorAll('.btn-prev');
    const fileInput = document.getElementById('file-upload');
    const fileError = document.getElementById('file-error');

    const persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    const englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    function convertToEnglish(input) {
        let output = input;
        persianNumbers.forEach((pn, index) => {
            const regex = new RegExp(pn, 'g');
            output = output.replace(regex, englishNumbers[index]);
        });
        return output;
    }

    function handleInput(event) {
        const target = event.target;
        if (target.tagName === 'INPUT' || target.tagName === 'TEXTAREA') {
            target.value = convertToEnglish(target.value);
        }
    }

    form.addEventListener('input', handleInput);

    let formStepIndex = 0;

    nextButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (formStepIndex === 1) {
                const file = fileInput.files[0];
                if (file) {
                    const allowedTypes = ['image/jpeg', 'image/png', 'video/mp4'];
                    if (!allowedTypes.includes(file.type)) {
                        fileError.textContent = 'فرمت فایل نامعتبر است. فرمت‌های مجاز: JPEG, PNG, MP4';
                        return;
                    }
                    if (file.size > 5242880) {
                        fileError.textContent = 'حجم فایل بیشتر از حد مجاز 5MB است.';
                        return;
                    }
                }
                fileError.textContent = '';
            }
            formStepIndex++;
            updateFormSteps();
        });
    });

    prevButtons.forEach(button => {
        button.addEventListener('click', () => {
            formStepIndex--;
            updateFormSteps();
        });
    });

    function updateFormSteps() {
        formSteps.forEach((step, index) => {
            step.classList.toggle('form-step-active', index === formStepIndex);
        });
    }

    form.addEventListener('submit', (e) => {
    });
});
