// Question 7: Design and integrate an interactive booking or reservation form with client-side JavaScript validation.

function validateReservationForm(event) {
    event.preventDefault();

    const name = document.getElementById('resName').value.trim();
    const email = document.getElementById('resEmail').value.trim();
    const guests = document.getElementById('resGuests').value;
    const date = document.getElementById('resDate').value;
    const errorBox = document.getElementById('resErrorMsg');

    errorBox.textContent = '';

    if (!name) {
        errorBox.textContent = 'Please enter your full name.';
        return false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || !emailPattern.test(email)) {
        errorBox.textContent = 'Please enter a valid email address.';
        return false;
    }

    if (guests <= 0 || guests > 20) {
        errorBox.textContent = 'Please enter a guest count between 1 and 20.';
        return false;
    }

    if (!date) {
        errorBox.textContent = 'Please select a reservation date.';
        return false;
    }

    alert('Table Reserved Successfully! Confirmation sent to ' + email);
    document.getElementById('reservationForm').reset();
    return true;
}
