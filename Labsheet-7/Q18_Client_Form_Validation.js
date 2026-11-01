// Question 18: Add client-side form validation in JavaScript for registration, login, and checkout forms.

document.addEventListener('DOMContentLoaded', () => {
    const regForm = document.getElementById('registrationForm');
    if (regForm) {
        regForm.addEventListener('submit', (e) => {
            const pass = document.getElementById('password').value;
            if (pass.length < 6) {
                alert("Password must be at least 6 characters long.");
                e.preventDefault();
            }
        });
    }
});
