function addReservationsToDropdown() {
    const menu = document.getElementById('auth-dropdown-menu');

    if (!menu) return;

    const alreadyExists = document.getElementById('reservations-menu-item');

    if (alreadyExists) return;

    const li = document.createElement('li');
    li.id = 'reservations-menu-item';

    const a = document.createElement('a');
    a.href = window.reservationsUrl;
    a.textContent = window.reservationsText || 'Reservations';

    li.appendChild(a);

    const logoutItem = document.getElementById('logout-menu-item');

    if (logoutItem) {
        menu.insertBefore(li, logoutItem);
    } else {
        menu.appendChild(li);
    }
}

let map;
let markers = [];
let fuels = [];
let models = [];
let transmissions = [];

window.masinas.forEach(masina => {
    if (!fuels.includes(masina.modelis.degvielas_tips)) {
        fuels.push(masina.modelis.degvielas_tips);
    }
})

window.masinas.forEach(masina => {
    let model = masina.modelis.modelis + " " + masina.modelis.marka
    if (!models.includes(model)) {
        models.push(model);
    }
})

window.masinas.forEach(masina => {
    if (!transmissions.includes(masina.modelis.transmisija)) {
        transmissions.push(masina.modelis.transmisija);
    }
})

const fuelDropdown = document.getElementById('fuel-dropdown');
const modelDropdown = document.getElementById('model-dropdown');
const transmissionDropdown = document.getElementById('transmission-dropdown');

fuels.sort()
models.sort()
transmissions.sort()

fuels.forEach(fuel => {
    const option = document.createElement('option')
    option.setAttribute('value', fuel)
    option.textContent = fuel
    fuelDropdown.appendChild(option)
})

models.forEach(model => {
    const option = document.createElement('option')
    option.setAttribute('value', model)
    option.textContent = model
    modelDropdown.appendChild(option)
})

transmissions.forEach(transmission => {
    const option = document.createElement('option')
    option.setAttribute('value', transmission)
    option.textContent = transmission
    transmissionDropdown.appendChild(option)
})

function clearMarkers() {
    markers.forEach(m => m.setMap(null));
    markers = [];
}

window.initMap = function () {

    if (!map) {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 56.91, lng: 24.13 },
            zoom: 7,
        });
    }

    const currentYear = new Date().getFullYear();
    const carCard = document.getElementById('car-card');
    const yearFrom = document.getElementById("year-from");
    const yearTo = document.getElementById('year-to');
    const errorDiv = document.getElementById('filter-error');

    errorDiv.textContent = '';

    let oldest = currentYear;
    window.masinas.forEach(masina => {
        if (masina.gads < oldest) oldest = masina.gads;
    });

    let yearFromValue = yearFrom.value !== "" ? parseInt(yearFrom.value) : oldest;
    let yearToValue = yearTo.value !== "" ? parseInt(yearTo.value) : currentYear;

    if (yearFromValue < 0 || yearToValue < 0) {
        errorDiv.textContent = "Years must be a positive value!";
        yearFrom.value = "";
        yearTo.value = "";
        return;
    } else if (yearToValue < yearFromValue) {
        errorDiv.textContent = 'Year "from" must not be greater than year "to"';
        yearFrom.value = "";
        yearTo.value = "";
        return;
    } else if (yearFromValue > currentYear || yearToValue > currentYear) {
        errorDiv.textContent = "Invalid Year Range";
        yearFrom.value = "";
        yearTo.value = "";
        return;
    } else if (yearFromValue < oldest || yearToValue < oldest) {
        errorDiv.textContent = `There are no cars from ${oldest} available`;
        yearFrom.value = "";
        yearTo.value = "";
        return;
    }

    
    clearMarkers();
    
    
    let masinas = window.masinas.filter(masina =>
        masina.statuss === 'pieejama' &&
        masina.lokacija &&
        parseInt(masina.gads) >= yearFromValue &&
        parseInt(masina.gads) <= yearToValue
    );
    
    if(fuelDropdown.value !== ""){
        masinas = masinas.filter(masina => masina.modelis.degvielas_tips === fuelDropdown.value);
    }
    if(modelDropdown.value !== ""){
        masinas = masinas.filter(masina => masina.modelis.modelis + " " + masina.modelis.marka === modelDropdown.value);
    }
    if(transmissionDropdown.value !== ""){
        masinas = masinas.filter(masina => masina.modelis.transmisija === transmissionDropdown.value);
    }

    masinas.forEach(masina => {
        const marker = new google.maps.Marker({
            position: {
                lat: parseFloat(masina.lokacija.platuma_gradi),
                lng: parseFloat(masina.lokacija.garuma_gradi)
            },
            map,
            title: masina.modelis.marka + " " + masina.modelis.modelis
        });

        markers.push(marker);

        marker.addListener('click', () => {
            let fuel = masina.degvielas_limenis;
            let battery = masina.baterijas_limenis;
            let energyHtml = '';
            if (fuel !== null && fuel !== undefined) {
                energyHtml = `<p>Degvielas līmenis: ${fuel}%</p>`;
            } else if (battery !== null && battery !== undefined) {
                energyHtml = `<p>Baterija: ${battery}%</p>`;
            } else {
                energyHtml = `<p>Nav datu</p>`;
            }

            const reservationUrl = `/reservation/${masina.id}`;
            const csrfToken = window.csrfToken;
            const rideUrl = `/ride/${masina.id}`;

            const actionHtml = `
                <div class="car-card-actions">
                    <form id="reservation-form-${masina.id}" action="${reservationUrl}" method="POST">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <button class="btn btn-reservation" type="submit">Make a Reservation</button>
                    </form>

                    <form id="ride-form-${masina.id}" action="${rideUrl}" method="POST">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <button class="btn btn-ride" type="submit">Begin Ride</button>
                    </form>
                </div>`;

            carCard.innerHTML = `
                <div class="car-card-header">
                    <div>
                        <h2>${masina.modelis.marka} ${masina.modelis.modelis}</h2>
                        <span class="car-status">${masina.statuss}</span>
                    </div>
                </div>

                <div class="car-card-body">
                    <div class="car-info-row">
                        <span>Gads</span>
                        <strong>${masina.gads}</strong>
                    </div>

                    <div class="car-info-row">
                        <span>Vietu skaits</span>
                        <strong>${masina.modelis.vietu_skaits}</strong>
                    </div>

                    <div class="car-info-row">
                        <span>Degviela / Baterija</span>
                        <strong>${energyHtml.replace('<p>', '').replace('</p>', '')}</strong>
                    </div>
                </div>

                ${actionHtml}
            `;

            const form = document.getElementById(`reservation-form-${masina.id}`);
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                });
                if (response.ok) {
                    masina.statuss = 'rezervēta';
                    marker.setMap(null);

                    addReservationsToDropdown();

                    form.innerHTML = `<p class="success-message">Reservation successful!</p>`;
                } else {
                    form.innerHTML = `<p class="error-message">Error!</p>`;
                }
            });
        });
    });
};

window.addEventListener('load', () => {
    if (typeof google !== 'undefined') {
        window.initMap();
    }
    // const modelDropdown = document.getElementById('model-dropdown');
    // const fuelDropdown = document.getElementById('fuel-dropdown');
    // const transmissionDropdown = document.getElementById('transmission-dropdown');


    document.getElementById('filter-btn').addEventListener('click', (e) => {
        e.preventDefault();
        window.initMap();
    });
});