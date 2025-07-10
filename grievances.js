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
    const resolvedListDiv = document.getElementById('resolved-list');

    // --- The `renderPendingGrievances()` Function ---
    // Fetches and displays the main list of PENDING grievances.
    async function renderPendingGrievances() {
        try {
            const response = await fetch('get_grievances.php');
            const grievances = await response.json();

            grievanceListDiv.innerHTML = ''; // Clear the list

            if (grievances.length === 0) {
                grievanceListDiv.innerHTML = '<p class="empty-state">No active grievances. Report one now!</p>';
            } else {
                grievances.forEach(grievance => {
                    const card = createGrievanceCard(grievance);
                    grievanceListDiv.appendChild(card);
                });
            }
        } catch (error) {
            console.error("Error fetching pending grievances:", error);
            grievanceListDiv.innerHTML = '<p class="empty-state">Could not load grievances.</p>';
        }
    }

    // --- NEW: `renderResolvedGrievances()` Function ---
    // Fetches and displays the list of RECENTLY RESOLVED grievances.
    async function renderResolvedGrievances() {
        try {
            const response = await fetch('get_resolved.php');
            const grievances = await response.json();

            resolvedListDiv.innerHTML = ''; // Clear the list

            if (grievances.length === 0) {
                resolvedListDiv.innerHTML = '<p class="empty-state-small">No issues resolved yet.</p>';
            } else {
                grievances.forEach(grievance => {
                    const resolvedItem = document.createElement('div');
                    resolvedItem.className = 'resolved-item';
                    resolvedItem.innerHTML = `<p>${escapeHTML(grievance.title)}</p><span>${escapeHTML(grievance.location)}</span>`;
                    resolvedListDiv.appendChild(resolvedItem);
                });
            }
        } catch (error) {
            console.error("Error fetching resolved grievances:", error);
            resolvedListDiv.innerHTML = '<p class="empty-state-small">Could not load resolved items.</p>';
        }
    }

    // --- Combined Render Function ---
    // This function calls both render functions to update the whole page.
    function renderAll() {
        console.log("Fetching latest data...");
        renderPendingGrievances();
        renderResolvedGrievances();
    }

    // Helper function to create an HTML element for a grievance card.
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
    function escapeHTML(str) {
        // A simple function to prevent basic XSS attacks.
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
        e.preventDefault(); 

        const formData = new FormData(grievanceForm);
        const submitButton = grievanceForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...';

        try {
            const response = await fetch('add_grievance.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.status === 'success') {
                grievanceForm.reset();
                renderAll(); // Immediately refresh both lists
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

    // --- 2. Click Handler for Upvote/Resolve buttons ---
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
                const response = await fetch('update_grievance.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.status === 'success') {
                    renderAll(); // Refresh both lists to show the change
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

    // Fetch and display all data when the page first loads.
    renderAll();

    // Set up a polling mechanism to fetch data every 5 seconds.
    setInterval(renderAll, 5000); 

});
