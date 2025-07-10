// =================================================================
// contact.js - The Connector for the Contact Us Page
// =================================================================
// This script handles the submission of the contact form using Fetch API.
// =================================================================

document.addEventListener('DOMContentLoaded', () => {

    // --- Element References ---
    const contactForm = document.querySelector('.contact-form');
    // We need to add a notification element to the contact.php page as well.
    // Let's assume one exists with the id 'notification' for now.
    
    // --- Custom Notification Function ---
    // This function will display our success/error messages.
    function showNotification(message, type = 'success') {
        const notification = document.getElementById('notification');
        if (!notification) {
            // Fallback to alert if the notification element doesn't exist
            alert(message);
            return;
        }
        notification.textContent = message;
        notification.className = `notification show ${type}`;
        setTimeout(() => {
            notification.classList.remove('show');
        }, 4000); // Hide after 4 seconds
    }

    // --- Event Listener for Contact Form Submission ---
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault(); // Prevent the default browser form submission

            const formData = new FormData(contactForm);
            const submitButton = contactForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';

            try {
                // Send the form data to our PHP script
                const response = await fetch('send_contact_email.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.status === 'success') {
                    showNotification(result.message, 'success');
                    contactForm.reset(); // Clear the form fields
                } else {
                    showNotification(result.message, 'error');
                }

            } catch (error) {
                console.error('Contact Form Error:', error);
                showNotification('An error occurred. Please try again later.', 'error');
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Send Message';
            }
        });
    }

    // --- Scroll Animations for the page ---
    // This is the same animation logic from home.js to make elements appear on scroll
    const scrollElements = document.querySelectorAll('.animate-on-scroll');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            }
        });
    }, { 
        threshold: 0.1 
    });

    scrollElements.forEach(el => {
        observer.observe(el);
    });

});
