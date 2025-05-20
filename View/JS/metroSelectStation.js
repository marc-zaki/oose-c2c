// Dynamic trip details and transfer functionality
document.addEventListener('DOMContentLoaded', function() {
    const startingLineSelect = document.getElementById('starting-line');
    const destinationLineSelect = document.getElementById('destination-line');
    const startingStationSelect = document.getElementById('starting-station');
    const finalStationSelect = document.getElementById('final-station');
    
    const transferNotice = document.querySelector('.bg-white.rounded-lg.px-4.py-2.inline-block');
    const priceDisplay = document.querySelector('.text-2xl.font-bold.text-green-600');
    const routeVisualization = document.querySelector('.relative.z-10.flex.items-center.justify-between.px-8');
    
    // Trip details elements
    const transportDetail = document.querySelector('.space-y-4 .flex:nth-child(1) .font-medium');
    const startingLineDetail = document.querySelector('.space-y-4 .flex:nth-child(2) .font-medium');
    const destinationLineDetail = document.querySelector('.space-y-4 .flex:nth-child(3) .font-medium');
    const fromStationDetail = document.querySelector('.space-y-4 .flex:nth-child(4) .font-medium');
    const toStationDetail = document.querySelector('.space-y-4 .flex:nth-child(5) .font-medium');
    const transferDetail = document.querySelector('.space-y-4 .flex:nth-child(6) .font-medium');
    const distanceDetail = document.querySelector('.space-y-4 .flex:nth-child(7) .font-medium');
    const totalPriceDetail = document.querySelector('.border-t .flex .text-green-600');

    // Metro stations by line
    const metroStations = {
        'line1': [
            {id: 'line1-helwan', name: 'Helwan'},
            {id: 'line1-ain-helwan', name: 'Ain Helwan'},
            {id: 'line1-helwan-university', name: 'Helwan University'},
            {id: 'line1-wadi-hof', name: 'Wadi Hof'},
            {id: 'line1-hadayek-helwan', name: 'Hadayek Helwan'},
            {id: 'line1-el-maasara', name: 'El-Maasara'},
            {id: 'line1-tura-el-asmant', name: 'Tura El-Asmant'},
            {id: 'line1-kozzika', name: 'Kozzika'},
            {id: 'line1-tura-el-balad', name: 'Tura El-Balad'},
            {id: 'line1-sakanat-el-maadi', name: 'Sakanat El-Maadi'},
            {id: 'line1-maadi', name: 'Maadi'},
            {id: 'line1-hadayek-el-maadi', name: 'Hadayek El-Maadi'},
            {id: 'line1-dar-el-salam', name: 'Dar El-Salam'},
            {id: 'line1-el-zahraa', name: 'El-Zahraa'},
            {id: 'line1-mar-girgis', name: 'Mar Girgis'},
            {id: 'line1-el-malek-el-saleh', name: 'El-Malek El-Saleh'},
            {id: 'line1-sayeda-zeinab', name: 'Sayeda Zeinab'},
            {id: 'line1-saad-zaghloul', name: 'Saad Zaghloul'},
            {id: 'line1-sadat', name: 'Sadat (Transfer to Line 2)'},
            {id: 'line1-nasser', name: 'Nasser (Transfer to Line 3)'},
            {id: 'line1-orabi', name: 'Orabi'},
            {id: 'line1-al-shohadaa', name: 'Al-Shohadaa (Transfer to Line 2)'},
            {id: 'line1-ghamra', name: 'Ghamra'},
            {id: 'line1-demerdash', name: 'Demerdash'},
            {id: 'line1-manshiet-el-sadr', name: 'Manshiet El-Sadr'},
            {id: 'line1-kobri-el-qobba', name: 'Kobri El-Qobba'},
            {id: 'line1-hammamat-el-qobba', name: 'Hammamat El-Qobba'},
            {id: 'line1-saray-el-qobba', name: 'Saray El-Qobba'},
            {id: 'line1-hadayeq-el-zeitoun', name: 'Hadayeq El-Zeitoun'},
            {id: 'line1-helmeyet-el-zeitoun', name: 'Helmeyet El-Zeitoun'},
            {id: 'line1-el-matareyya', name: 'El-Matareyya'},
            {id: 'line1-ain-shams', name: 'Ain Shams'},
            {id: 'line1-ezbet-el-nakhl', name: 'Ezbet El-Nakhl'},
            {id: 'line1-el-marg', name: 'El-Marg'},
            {id: 'line1-new-el-marg', name: 'New El-Marg'}
        ],
        'line2': [
            {id: 'line2-shobra', name: 'Shobra El Kheima'},
            {id: 'line2-koleyet-zeraa', name: 'Koleyet El Zeraa'},
            {id: 'line2-mezallat', name: 'Mezallat'},
            {id: 'line2-khalafawy', name: 'Khalafawy'},
            {id: 'line2-st-teresa', name: 'St. Teresa'},
            {id: 'line2-rod-el-farag', name: 'Rod El-Farag'},
            {id: 'line2-massara', name: 'Massara'},
            {id: 'line2-al-shohadaa', name: 'Al-Shohadaa (Transfer to Line 1)'},
            {id: 'line2-attaba', name: 'Attaba'},
            {id: 'line2-mohamed-naguib', name: 'Mohamed Naguib'},
            {id: 'line2-sadat', name: 'Sadat (Transfer to Line 1)'},
            {id: 'line2-opera', name: 'Opera'},
            {id: 'line2-dokki', name: 'Dokki'},
            {id: 'line2-cairo-university', name: 'Cairo University'},
            {id: 'line2-faisal', name: 'Faisal'},
            {id: 'line2-giza', name: 'Giza'}
        ],
        'line3': [
            {id: 'line3-adly-mansour', name: 'Adly Mansour'},
            {id: 'line3-el-haykestep', name: 'El Haykestep'},
            {id: 'line3-omar-ibn-el-khattab', name: 'Omar Ibn El-Khattab'},
            {id: 'line3-qobaa', name: 'Qoba\'a'},
            {id: 'line3-hesham-barakat', name: 'Hesham Barakat'},
            {id: 'line3-el-nozha', name: 'El-Nozha'},
            {id: 'line3-airport', name: 'Cairo Airport'},
            {id: 'line3-ahmed-galal', name: 'Ahmed Galal'},
            {id: 'line3-haroun', name: 'Haroun'},
            {id: 'line3-heliopolis', name: 'Heliopolis Square'},
            {id: 'line3-alf-maskan', name: 'Alf Maskan'},
            {id: 'line3-cairo-stadium', name: 'Cairo Stadium'},
            {id: 'line3-kolleyet-el-banat', name: 'Kolleyet El Banat'},
            {id: 'line3-cairo-fair', name: 'Cairo Fair'},
            {id: 'line3-abbassia', name: 'Abbassia'},
            {id: 'line3-abdou-pasha', name: 'Abdou Pasha'},
            {id: 'line3-bab-el-shaaria', name: 'Bab El-Shaaria'},
            {id: 'line3-attaba-line3', name: 'Attaba (Transfer to Line 2)'},
            {id: 'line3-nasser', name: 'Nasser (Transfer to Line 1)'},
            {id: 'line3-maspero', name: 'Maspero'},
            {id: 'line3-zamalek', name: 'Zamalek'},
            {id: 'line3-kit-kat', name: 'Kit Kat'},
            {id: 'line3-sudan', name: 'Sudan Street'},
            {id: 'line3-imbaba', name: 'Imbaba'}
        ]
    };

    function updateStations(selectElement, line) {
        selectElement.innerHTML = '<option value="">Select station</option>';
        metroStations[line].forEach(station => {
            const option = document.createElement('option');
            option.value = station.id;
            option.textContent = station.name;
            selectElement.appendChild(option);
        });
    }

    function getPriceByStations(stationCount) {
        if (stationCount === null || isNaN(stationCount)) return 'N/A';
        if (stationCount <= 9) return 5;
        else if (stationCount <= 16) return 7;
        else return 10;
    }

    function updateTripDetails() {
        const startingLine = startingLineSelect.value;
        const destinationLine = destinationLineSelect.value;
        const startingStation = startingStationSelect.value;
        const finalStation = finalStationSelect.value;

        // Update transfer visibility
        const needsTransfer = startingLine !== destinationLine && startingLine && destinationLine;
        transferNotice.style.display = needsTransfer ? 'block' : 'none';

        // Update trip details
        startingLineDetail.textContent = startingLine ? `Line ${startingLine.slice(-1)}` : 'N/A';
        destinationLineDetail.textContent = destinationLine ? `Line ${destinationLine.slice(-1)}` : 'N/A';
        fromStationDetail.textContent = startingStationSelect.selectedOptions[0]?.text || 'N/A';
        toStationDetail.textContent = finalStationSelect.selectedOptions[0]?.text || 'N/A';
        transferDetail.textContent = needsTransfer ? 'Required' : 'Not Required';
        transferDetail.className = needsTransfer ? 'font-medium text-yellow-600' : 'font-medium';

        // Calculate station count
        let stationCount = null;
        if (startingLine && destinationLine && startingStation && finalStation) {
            if (!needsTransfer) {
                const startIdx = metroStations[startingLine].findIndex(s => s.id === startingStation);
                const destIdx = metroStations[startingLine].findIndex(s => s.id === finalStation);
                if (startIdx !== -1 && destIdx !== -1) {
                    stationCount = Math.abs(destIdx - startIdx) + 1;
                }
            } else {
                // Transfer logic: use main transfer stations
                let transferStationIdStart, transferStationIdDest;
                if ((startingLine === 'line1' && destinationLine === 'line2') || (startingLine === 'line2' && destinationLine === 'line1')) {
                    transferStationIdStart = 'line1-sadat';
                    transferStationIdDest = 'line2-sadat';
                } else if ((startingLine === 'line1' && destinationLine === 'line3') || (startingLine === 'line3' && destinationLine === 'line1')) {
                    transferStationIdStart = 'line1-nasser';
                    transferStationIdDest = 'line3-nasser';
                } else if ((startingLine === 'line2' && destinationLine === 'line3') || (startingLine === 'line3' && destinationLine === 'line2')) {
                    transferStationIdStart = 'line2-attaba';
                    transferStationIdDest = 'line3-attaba-line3';
                }
                const startIdx = metroStations[startingLine].findIndex(s => s.id === startingStation);
                const transferIdxStart = metroStations[startingLine].findIndex(s => s.id === transferStationIdStart);
                const transferIdxDest = metroStations[destinationLine].findIndex(s => s.id === transferStationIdDest);
                const destIdx = metroStations[destinationLine].findIndex(s => s.id === finalStation);
                if (startIdx !== -1 && transferIdxStart !== -1 && transferIdxDest !== -1 && destIdx !== -1) {
                    stationCount = Math.abs(transferIdxStart - startIdx) + Math.abs(destIdx - transferIdxDest) + 1;
                }
            }
        }
        distanceDetail.textContent = stationCount !== null ? `${stationCount} Stations` : 'N/A';
        // Update price
        const price = getPriceByStations(stationCount);
        priceDisplay.textContent = price;
        totalPriceDetail.textContent = `${price} LE`;
    }

    function updateMetroLabels() {
        const startLabel = document.getElementById('metro-start-label');
        const endLabel = document.getElementById('metro-end-label');
        const startSelect = document.getElementById('starting-station');
        const endSelect = document.getElementById('final-station');
        startLabel.textContent = startSelect.selectedOptions[0]?.text || 'Start';
        endLabel.textContent = endSelect.selectedOptions[0]?.text || 'End';
    }

    // Event Listeners
    startingLineSelect.addEventListener('change', () => {
        updateStations(startingStationSelect, startingLineSelect.value);
        updateTripDetails();
    });

    destinationLineSelect.addEventListener('change', () => {
        updateStations(finalStationSelect, destinationLineSelect.value);
        updateTripDetails();
    });

    startingStationSelect.addEventListener('change', updateTripDetails);
    finalStationSelect.addEventListener('change', updateTripDetails);

    // Update labels on station change
    document.getElementById('starting-station').addEventListener('change', updateMetroLabels);
    document.getElementById('final-station').addEventListener('change', updateMetroLabels);

    // Initialize default stations
    updateStations(startingStationSelect, 'line2');
    updateStations(finalStationSelect, 'line3');
    updateTripDetails();

    // Also call once on page load and after station dropdowns are updated
    updateMetroLabels();

    // Confirm Booking Handler
    document.getElementById('confirm-booking').addEventListener('click', function() {
        const startingStation = startingStationSelect.value;
        const finalStation = finalStationSelect.value;
        
        if (!startingStation || !finalStation) {
            alert('Please select both starting and final stations');
            return;
        }

        // Redirect to payment page with booking details
        window.location.href = `/HTML/Payment.html?from=${encodeURIComponent(startingStation)}&to=${encodeURIComponent(finalStation)}`;
    });
});