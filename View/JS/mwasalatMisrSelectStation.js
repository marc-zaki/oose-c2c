document.addEventListener('DOMContentLoaded', function() {
    // Real Mwasalat Misr lines and main stations (translated to English)
    const busLines = {
        NC2: [
            { id: 'al-lotus', name: 'Al Lotus' },
            { id: 'katameya', name: 'Katameya' },
            { id: 'el-nasr', name: 'El Nasr Street' },
            { id: 'el-moshir', name: 'El Moshir' },
            { id: 'el-tayaran', name: 'El Tayaran Street' }
        ],
        NC3: [
            { id: 'al-lotus', name: 'Al Lotus' },
            { id: '3rd-settlement', name: '3rd Settlement' },
            { id: 'el-nasr', name: 'El Nasr Street' },
            { id: 'el-moshir', name: 'El Moshir' }
        ],
        NC4: [
            { id: '1st-settlement', name: '1st Settlement' },
            { id: 'factory', name: 'Factory' }
        ],
        NC5: [
            { id: '5th-settlement', name: '5th Settlement' },
            { id: 'technological', name: 'Technological' }
        ],
        NC6: [
            { id: 'gas', name: 'Gas' },
            { id: 'factory', name: 'Factory' }
        ],
        M5: [
            { id: 'al-lotus', name: 'Al Lotus' },
            { id: 'madinat-nasr-riyadh', name: 'Nasr City Riyadh' }
        ],
        M6: [
            { id: 'al-lotus', name: 'Al Lotus' },
            { id: 'saray-el-qobba', name: 'Saray El Qobba' }
        ],
        M8: [
            { id: 'al-lotus', name: 'Al Lotus' },
            { id: 'giza', name: 'Giza' }
        ],
        M9: [
            { id: 'al-lotus', name: 'Al Lotus' },
            { id: 'maadi', name: 'Maadi' }
        ],
        NS9: [
            { id: 'al-lotus', name: 'Al Lotus' },
            { id: 'madinat-el-shorouk', name: 'Madinat El Shorouk' }
        ],
        NC7: [
            { id: '1st-settlement', name: '1st Settlement' },
            { id: 'adly-mansour', name: 'Adly Mansour Station' }
        ],
        NC8: [
            { id: '3rd-settlement', name: '3rd Settlement' },
            { id: 'muqattam', name: 'Muqattam' }
        ]
    };

    const busLineSelect = document.getElementById('bus-line');
    const destinationLineSelect = document.getElementById('destination-line');
    const startingStopSelect = document.getElementById('starting-stop');
    const finalStopSelect = document.getElementById('final-stop');

    // Sidebar elements
    const sidebarLine = document.getElementById('sidebar-line');
    const sidebarFrom = document.getElementById('sidebar-from');
    const sidebarTo = document.getElementById('sidebar-to');
    const sidebarDistance = document.getElementById('sidebar-distance');
    const sidebarTotalPrice = document.getElementById('sidebar-total-price');

    function updateStops(selectElement, line) {
        selectElement.innerHTML = '<option value="">Select stop</option>';
        if (busLines[line]) {
            busLines[line].forEach(stop => {
                const option = document.createElement('option');
                option.value = stop.id;
                option.textContent = stop.name;
                selectElement.appendChild(option);
            });
        }
    }

    function updateTripDetails() {
        const line = busLineSelect.value;
        const destLine = destinationLineSelect.value;
        const startId = startingStopSelect.value;
        const endId = finalStopSelect.value;

        // Update sidebar line
        sidebarLine.textContent = line ? busLineSelect.options[busLineSelect.selectedIndex].text : 'N/A';

        // Find stop names
        const stops = busLines[line] || [];
        const destStops = busLines[destLine] || [];
        const startIdx = stops.findIndex(s => s.id === startId);
        const endIdx = destStops.findIndex(s => s.id === endId);
        const startName = stops[startIdx]?.name || 'N/A';
        const endName = destStops[endIdx]?.name || 'N/A';

        sidebarFrom.textContent = startName;
        sidebarTo.textContent = endName;

        // Calculate distance (only if same line)
        let stopCount = 0;
        if (line && destLine && line === destLine && startIdx !== -1 && endIdx !== -1) {
            stopCount = Math.abs(startIdx - endIdx);
        }
        sidebarDistance.textContent = stopCount > 0 ? `${stopCount} Stops` : 'N/A';

        // Example price logic: 10 LE for 1-2 stops, 15 LE for 3+, 0 if invalid
        let price = 0;
        if (stopCount > 0 && stopCount <= 2) price = 10;
        else if (stopCount > 2) price = 15;
        sidebarTotalPrice.textContent = price > 0 ? `${price} LE` : 'N/A';
    }

    busLineSelect.addEventListener('change', function() {
        updateStops(startingStopSelect, busLineSelect.value);
        destinationLineSelect.value = busLineSelect.value;
        updateStops(finalStopSelect, destinationLineSelect.value);
        updateTripDetails();
    });

    destinationLineSelect.addEventListener('change', function() {
        updateStops(finalStopSelect, destinationLineSelect.value);
        updateTripDetails();
    });

    startingStopSelect.addEventListener('change', updateTripDetails);
    finalStopSelect.addEventListener('change', updateTripDetails);

    // Initialize
    updateTripDetails();
});