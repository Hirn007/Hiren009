document.addEventListener('DOMContentLoaded', () => {
    
    const ticketForm = document.getElementById('ticketForm');
    const formMessage = document.getElementById('formMessage');
    const filterBtns = document.querySelectorAll('.filter-btn');
    let currentFilter = 'All';

    // Initial fetch of tickets
    if(ticketForm) {
        fetchTickets();
    }

    // Form Submission Event
    if(ticketForm) {
        ticketForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic JS Validation
            const title = document.getElementById('title').value.trim();
            const assignedTo = document.getElementById('assignedTo').value.trim();

            if (!title || !assignedTo) {
                showMessage('Title and Assigned To are required.', 'error');
                return;
            }

            const formData = new FormData(this);

            // AJAX Submission
            fetch('api/submit_ticket.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                    ticketForm.reset();
                    // Refresh tickets using the current filter
                    fetchTickets(currentFilter);
                } else {
                    showMessage(data.message || 'An error occurred.', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                showMessage('Failed to communicate with the server.', 'error');
            });
        });
    }

    // Filter Buttons Event
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update UI
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Set filter state and fetch
            currentFilter = this.getAttribute('data-filter');
            fetchTickets(currentFilter);
        });
    });

    // Helper: Show Message
    function showMessage(msg, type) {
        formMessage.textContent = msg;
        formMessage.className = 'alert alert-' + type;
        formMessage.classList.remove('hidden');
        
        setTimeout(() => {
            formMessage.classList.add('hidden');
        }, 3000);
    }

    // Helper: Fetch Tickets via AJAX
    function fetchTickets(status = 'All') {
        const tbody = document.getElementById('ticketTableBody');
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Loading...</td></tr>';

        fetch(`api/fetch_tickets.php?status=${status}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderTable(data.data);
            } else {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color: red;">Failed to load tickets.</td></tr>';
            }
        })
        .catch(err => {
            console.error(err);
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color: red;">Error communicating with server.</td></tr>';
        });
    }

    // Helper: Render Table Rows
    function renderTable(tickets) {
        const tbody = document.getElementById('ticketTableBody');
        tbody.innerHTML = '';

        if (tickets.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color: #6B7280;">No tickets found.</td></tr>';
            return;
        }

        tickets.forEach(ticket => {
            const tr = document.createElement('tr');
            
            const badgeClass = ticket.status.toLowerCase() === 'open' ? 'badge-open' : 'badge-closed';
            
            // Format date slightly
            const d = new Date(ticket.date);
            const dateStr = `${d.toLocaleDateString()} ${d.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}`;

            tr.innerHTML = `
                <td><small style="color:#6B7280;">#${ticket.id.substring(0, 6)}</small></td>
                <td style="font-weight: 500;">${ticket.title}</td>
                <td><span class="badge ${badgeClass}">${ticket.status}</span></td>
                <td>${ticket.assignedTo}</td>
                <td><small>${dateStr}</small></td>
            `;
            tbody.appendChild(tr);
        });
    }

});
