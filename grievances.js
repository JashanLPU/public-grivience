// =================================================================
// grievances.js - The Live Connector for the Grievance Tool Page
// =================================================================
// This script connects the frontend (HTML) to our PHP backend.
// It uses the Fetch API to send and receive data, creating a live,
// real-time experience for the user without needing to refresh the page.
// =================================================================

document.addEventListener('DOMContentLoaded', () => {

    // --- DOM Element References ---
    const grievanceForm = document.getElementById('grievance-form');
    const grievanceListDiv = document.getElementById('grievance-list');
    const resolvedListDiv = document.getElementById('resolved-list'); // We'll add logic for this later if needed

    // --- The `renderGrievances()` Function ---
    // This is the master function that fetches data from the backend and displays it.
    async function renderGrievances() {
        console.log("Fetching latest grievances...");
        try {
            // Use the Fetch API to call our PHP script.
            const response = await fetch('get_grievances.php');
            const grievances = await response.json();

            // Clear the current list to prevent duplicates.
            grievanceListDiv.innerHTML = '';

            if (grievances.length === 0) {
                grievanceListDiv.innerHTML = '<p class="empty-state">No active grievances. Be the first to report one!</p>';
            } else {
                grievances.forEach(grievance => {
                    const card = createGrievanceCard(grievance);
                    grievanceListDiv.appendChild(card);
                });
            }
        } catch (error) {
            console.error("Error fetching grievances:", error);
            grievanceListDiv.innerHTML = '<p class="empty-state">Could not load grievances. Please check the connection.</p>';
        }
    }

    // --- Helper function to create an HTML element for a grievance card ---
    function createGrievanceCard(grievance) {
        const card = document.createElement('div');
        const severityMap = { 4: 'critical', 3: 'high', 2: 'medium', 1: 'low' };
        card.className = `grievance-card severity-${severityMap[grievance.severity]}`;
        card.dataset.id = grievance.id; // Store the database ID on the element

        card.innerHTML = `
            <div class="card-header">
                <h4>${escapeHTML(grievance.title)}</h4>
                <span class="card-location"><i class="fa-solid fa-location-dot"></i> ${escapeHTML(grievance.location)}</span>
            </div>
            <p class="card-description">${escapeHTML(grievance.description)}</p>
            <div class="card-footer">
                <div class="upvote-section">
                    <button class="upvote-btn"><i class="fa-solid fa-arrow-up"></i></button>
                    <span class="upvote-count">${grievance.upvotes}</span>
                </div>
                <button class="resolve-btn">Mark as Resolved</button>
            </div>
        `;
        return card;
    }
    
    // --- Security Helper Function ---
    // This prevents Cross-Site Scripting (XSS) attacks by converting special characters to HTML entities.
    function escapeHTML(str) {
        return str.replace(/[&<>'"]/g, 
          tag => ({
              '&': '&amp;',
              '<': '&lt;',
              '>': '&gt;',
              "'": '&#39;',
              '"': '&quot;'
            }[tag] || tag)
        );
      }


    // =================================
    //  EVENT LISTENERS
    // =================================

    // --- 1. Form Submission ---
    grievanceForm.addEventListener('submit', async (e) => {
        e.preventDefault(); // Prevent the default browser form submission

        const formData = new FormData(grievanceForm);
        const submitButton = grievanceForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...';

        try {
            // Send the form data to our 'add_grievance.php' script.
            const response = await fetch('add_grievance.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.status === 'success') {
                grievanceForm.reset();
                renderGrievances(); // Immediately refresh the list to show the new grievance
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error("Error submitting form:", error);
            alert('A network error occurred. Please try again.');
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Submit Grievance';
        }
    });

    // --- 2. Click Handler for Upvote/Resolve buttons (using event delegation) ---
    grievanceListDiv.addEventListener('click', async (e) => {
        const grievanceCard = e.target.closest('.grievance-card');
        if (!grievanceCard) return;

        const grievanceId = grievanceCard.dataset.id;
        let action = null;

        if (e.target.closest('.upvote-btn')) {
            action = 'upvote';
        } else if (e.target.closest('.resolve-btn')) {
            action = 'resolve';
        }

        if (action) {
            const formData = new FormData();
            formData.append('id', grievanceId);
            formData.append('action', action);

            try {
                // Send the action to our 'update_grievance.php' script.
                const response = await fetch('update_grievance.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.status === 'success') {
                    renderGrievances(); // Refresh the list to show the change
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error("Error updating grievance:", error);
                alert('A network error occurred.');
            }
        }
    });

    // =================================
    //  LIVE POLLING & INITIAL RENDER
    // =================================

    // Fetch and display the grievances when the page first loads.
    renderGrievances();

    // Set up a polling mechanism to fetch data every 5 seconds.
    // This makes the page feel "live" as it will update automatically.
    setInterval(renderGrievances, 5000); // 5000 milliseconds = 5 seconds

});
