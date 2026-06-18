function t(key, replacements = {}) {
    let text = window.i18n?.[key] ?? key;

    Object.entries(replacements).forEach(([placeholder, value]) => {
        text = text.replace(`:${placeholder}`, value);
    });

    return text;
}

function translateStatus(status) {
    return window.i18n?.statuses?.[status] ?? status;
}

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
        errorDiv.textContent = t('years_positive');
        yearFrom.value = "";
        yearTo.value = "";
        return;
    } else if (yearToValue < yearFromValue) {
        errorDiv.textContent = t('year_from_greater');
        yearFrom.value = "";
        yearTo.value = "";
        return;
    } else if (yearFromValue > currentYear || yearToValue > currentYear) {
        errorDiv.textContent = t('invalid_year_range');
        yearFrom.value = "";
        yearTo.value = "";
        return;
    } else if (yearFromValue < oldest || yearToValue < oldest) {
        errorDiv.textContent = t('no_cars_from', { year: oldest });
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
            let energyText = '';

            if (fuel !== null && fuel !== undefined) {
                energyText = `${t('fuel_level')}: ${fuel}%`;
            } else if (battery !== null && battery !== undefined) {
                energyText = `${t('battery')}: ${battery}%`;
            } else {
                energyText = t('no_data');
            }

            const reservationUrl = `/reservation/${masina.id}`;
            const csrfToken = window.csrfToken;
            const rideUrl = `/ride/${masina.id}`;

            let actionHtml = '';

            if (!window.hasVerifiedDriverLicense) {
                actionHtml = `
                    <div class="car-card-actions">
                        <p class="error-message">
                            ${t('license_required')}
                        </p>
                    </div>`;
            } else if (window.hasActiveReservation) {
                actionHtml = `
                    <div class="car-card-actions">
                        <p class="error-message">
                            ${t('already_active_reservation')}
                        </p>
                    </div>`;
            } else {
                actionHtml = `
                    <div class="car-card-actions">
                        <form id="reservation-form-${masina.id}" action="${reservationUrl}" method="POST">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button class="btn btn-reservation" type="submit">${t('make_reservation')}</button>
                        </form>

                        <form id="ride-form-${masina.id}" action="${rideUrl}" method="POST">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button class="btn btn-ride" type="submit">${t('begin_ride')}</button>
                        </form>
                    </div>`;
            }

            carCard.innerHTML = `
                <div class="car-card-header">
                    <div>
                        <h2>${masina.modelis.marka} ${masina.modelis.modelis}</h2>
                        <span class="car-status">${translateStatus(masina.statuss)}</span>
                    </div>
                </div>

                <div class="car-card-body">
                    <div class="car-info-row">
                        <span>${t('year')}</span>
                        <strong>${masina.gads}</strong>
                    </div>

                    <div class="car-info-row">
                        <span>${t('seat_count')}</span>
                        <strong>${masina.modelis.vietu_skaits}</strong>
                    </div>

                    <div class="car-info-row">
                        <span>${t('fuel_battery')}</span>
                        <strong>${energyText}</strong>
                    </div>
                </div>

                ${actionHtml}
            `;

            const form = document.getElementById(`reservation-form-${masina.id}`);
            if (form) {
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
                        window.hasActiveReservation = true;

                        marker.setMap(null);

                        addReservationsToDropdown();

                        form.innerHTML = `<p class="success-message">${t('reservation_successful')}</p>`;
                    } else if (response.status === 403) {
                        form.innerHTML = `<p class="error-message">${t('license_not_valid')}</p>`;
                    } else if (response.status === 409) {
                        const data = await response.json().catch(() => null);
                        form.innerHTML = `<p class="error-message">${data?.message || t('already_active_reservation')}</p>`;
                    } else {
                        form.innerHTML = `<p class="error-message">${t('error')}</p>`;
                    }
                });
            }   
        });
    });
};

window.addEventListener('load', () => {
    if (typeof google !== 'undefined') {
        window.initMap();
    }
    document.getElementById('filter-btn').addEventListener('click', (e) => {
        e.preventDefault();
        window.initMap();
    });
});