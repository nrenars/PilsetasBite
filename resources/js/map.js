window.initMap = function () {

    const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 56.91, lng: 24.13 },
        zoom: 7,
    });

    const carCard = document.getElementById('car-card');

    (window.masinas || []).forEach(masina => {

        if (!masina.lokacija) return;
        if (masina.statuss !== 'pieejama') return;

        const marker = new google.maps.Marker({
            position: {
                lat: parseFloat(masina.lokacija.platuma_gradi),
                lng: parseFloat(masina.lokacija.garuma_gradi)
            },
            map,
            title: masina.registracijas_nr
        });

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

            const actionHtml = masina.statuss === 'pieejama'
                ? `<form id="reservation-form-${masina.id}" action="${reservationUrl}" method="POST">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <button type="submit">Make a Reservation</button>
                   </form>`
                : `<p style="color: red;">Reserved</p>`;

            carCard.innerHTML = `
                <h2>${masina.modelis.marka} ${masina.modelis.modelis} | ${masina.statuss}</h2>
                ${energyHtml}
                <p>Gads: ${masina.gads}</p>
                <p>Vietu skaits: ${masina.modelis.vietu_skaits}</p>
                ${actionHtml}
            `;

            if (masina.statuss === 'pieejama') {
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
                        form.innerHTML = `<p style="color: green;">Reservation successful!</p>`;
                    } else {
                        form.innerHTML = `<p style="color: red;">Error!</p>`;
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
});