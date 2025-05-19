document.addEventListener('DOMContentLoaded', function() {
    // LRT Egypt stations (ordered)
    const lrtStations = [
        { id: 'adly-mansour', name: 'Adly Mansour' },
        { id: 'el-obour', name: 'El Obour' },
        { id: 'future', name: 'Future' },
        { id: 'el-mostakbal1', name: 'El Mostakbal 1' },
        { id: 'el-mostakbal2', name: 'El Mostakbal 2' },
        { id: 'el-shorouk', name: 'El Shorouk' },
        { id: 'new-hisham-barakat', name: 'New Hisham Barakat' },
        { id: 'el-badr', name: 'El Badr' },
        { id: 'el-rubiki', name: 'El Rubiki' },
        { id: 'capital-gardens', name: 'Capital Gardens' },
        { id: 'new-administrative-capital', name: 'New Administrative Capital' },
        { id: 'arts-culture-city', name: 'Arts & Culture City' }
    ];

    // Elements
    const startingStationSelect = document.getElementById('starting-station');
    const finalStationSelect = document.getElementById('final-station');
    // Sidebar trip details
    const tripDetailsSidebar = document.querySelector('.bg-gray-50.rounded-xl.p-6.space-y-6 .space-y-4');
    // Visual route display
    const visualFrom = document.querySelector('.relative.z-10.flex.items-center.justify-between.px-8 .flex.flex-col.items-center span.text-sm.font-medium');
    const visualTo = document.querySelectorAll('.relative.z-10.flex.items-center.justify-between.px-8 .flex.flex-col.items-center span.text-sm.font-medium')[1];
    const priceDisplay = document.querySelector('.text-2xl.font-bold.text-red-600');
    const totalPriceDetail = document.querySelector('.border-t .flex .text-red-600');

    function updateTripDetails() {
        const startId = startingStationSelect.value;
        const endId = finalStationSelect.value;

        const startIdx = lrtStations.findIndex(s => s.id === startId);
        const endIdx = lrtStations.findIndex(s => s.id === endId);

        // Names for display
        const startName = lrtStations[startIdx]?.name || 'N/A';
        const endName = lrtStations[endIdx]?.name || 'N/A';

        // Update visual route
        if (visualFrom) visualFrom.textContent = startName;
        if (visualTo) visualTo.textContent = endName;

        // Calculate distance
        let stationCount = 0;
        if (startIdx !== -1 && endIdx !== -1) {
            stationCount = Math.abs(startIdx - endIdx);
        }
        const distanceText = stationCount > 0 ? `${stationCount} Stations` : 'N/A';

        // Price logic (example: 15 LE for 1-3 stations, 25 LE for 4-7, 35 LE for 8+)
        let price = 0;
        if (stationCount > 0 && stationCount <= 3) price = 15;
        else if (stationCount > 3 && stationCount <= 7) price = 25;
        else if (stationCount > 7) price = 35;
        else price = 0;

        priceDisplay.textContent = price;
        totalPriceDetail.textContent = price > 0 ? `${price} LE` : 'N/A';

        // Update sidebar trip details by ID
        document.getElementById('sidebar-transport').textContent = 'LRT';
        document.getElementById('sidebar-line').textContent = 'LRT Line';
        document.getElementById('sidebar-from').textContent = startName;
        document.getElementById('sidebar-to').textContent = endName;
        document.getElementById('sidebar-distance').textContent = distanceText;
        document.getElementById('sidebar-total-price').textContent = price > 0 ? `${price} LE` : 'N/A';
    }

    startingStationSelect.addEventListener('change', updateTripDetails);
    finalStationSelect.addEventListener('change', updateTripDetails);

    // Confirm Booking Handler
    document.getElementById('confirm-booking').addEventListener('click', function() {
        const startId = startingStationSelect.value;
        const endId = finalStationSelect.value;
        if (!startId || !endId) {
            alert('Please select both starting and final stations');
            return;
        }
        window.location.href = `/HTML/Payment.html?from=${encodeURIComponent(startId)}&to=${encodeURIComponent(endId)}`;
    });

    // Initialize on load
    updateTripDetails();
});