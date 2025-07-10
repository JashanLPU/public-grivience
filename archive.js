// =================================================================
// archive.js - The Connector for the Resolved Archive Page
// =================================================================

document.addEventListener('DOMContentLoaded', () => {

    const archiveListDiv = document.getElementById('archive-list');

    // --- Fetches and displays ALL resolved grievances ---
    async function renderArchive() {
        try {
            const response = await fetch(`get_archive.php?t=${new Date().getTime()}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const grievances = await response.json();

            archiveListDiv.innerHTML = ''; // Clear the list

            if (grievances.length === 0) {
                archiveListDiv.innerHTML = '<p class="empty-state">The archive is currently empty. No grievances have been resolved yet.</p>';
            } else {
                grievances.forEach(grievance => {
                    const card = createArchiveCard(grievance);
                    archiveListDiv.appendChild(card);
                });
            }
        } catch (error) {
            console.error("Error fetching archive:", error);
            archiveListDiv.innerHTML = '<p class="empty-state">Could not load the archive. Please check the server connection.</p>';
        }
    }

    // --- Helper function to create an HTML element for an archive card ---
    function createArchiveCard(grievance) {
        const card = document.createElement('div');
        card.className = 'archive-card';

        // Format the dates for better readability
        const createdDate = new Date(grievance.created_at).toLocaleDateString();
        const resolvedDate = grievance.resolved_at ? new Date(grievance.resolved_at).toLocaleDateString() : 'N/A';

        card.innerHTML = `
            <h4>${escapeHTML(grievance.title)}</h4>
            <p class="location"><i class="fa-solid fa-location-dot"></i> ${escapeHTML(grievance.location)}</p>
            <p class="description">${escapeHTML(grievance.description)}</p>
            <div class="meta-info">
                <span><strong>Reported:</strong> ${createdDate}</span>
                <span><strong>Resolved:</strong> ${resolvedDate}</span>
            </div>
        `;
        return card;
    }

    // --- Security Helper Function ---
    function escapeHTML(str) {
        if (str === null || str === undefined) {
            return '';
        }
        return str.toString().replace(/[&<>'"]/g, 
          tag => ({
              '&': '&amp;',
              '<': '&lt;',
              '>': '&gt;',
              "'": '&#39;',
              '"': '&quot;'
            }[tag] || tag)
        );
    }

    // --- Initial Render ---
    renderArchive();

});
