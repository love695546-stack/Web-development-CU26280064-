/**
 * Question 19: Write clean, well-commented HTML, CSS, and JavaScript code following industry coding standards.
 * 
 * Client Project: Green Leaf Café Web Application
 * Module: Table Reservation Handler
 * Author: Developer Team
 * Standard: ES6+ Syntax, JSDoc Commenting
 */

/**
 * Handles reservation submission with input sanitization and verification.
 * @param {Event} event - HTML Form Submission Event
 * @returns {boolean} - Returns true if validation succeeds
 */
function handleTableReservation(event) {
    // Prevent default form submission reload
    event.preventDefault();

    // Acquire DOM Input Elements
    const customerName = document.getElementById('custName')?.value.trim();
    const guestCount = parseInt(document.getElementById('guestCount')?.value, 10);

    // Guard Clause for Null Check
    if (!customerName || isNaN(guestCount)) {
        console.warn('Reservation Failed: Invalid form inputs detected.');
        return false;
    }

    console.log(`Reservation confirmed for ${customerName} (${guestCount} Guests).`);
    return true;
}
