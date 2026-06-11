window.initMap = function () {

    const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 56.91, lng: 24.13 },
        zoom: 12,
    });

    const carCard = document.getElementById('car-card');

    (window.masinas || []).forEach(masina => {

        if (!masina.lokacija) return;

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

            const reservationUrl = "{{ route('reservations.store') }}";
            const csrfToken = "{{ csrf_token() }}";

            carCard.innerHTML = `
                <h2>${masina.modelis.marka} ${masina.modelis.modelis} | ${masina.statuss} </h2>
                ${energyHtml}
                <p>Gads: ${masina.gads}</p>
                <p>Vietu skaits: ${masina.modelis.vietu_skaits}</p>
                <form action="${reservationUrl}" method="POST">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="masina_id" value="${masina.id}">
                        <button type="submit">Make a Reservation</button>
                    </form>
                <a href="/">Begin Ride</a>
            `;
        });

    });
};
window.addEventListener('load', () => {
    if (typeof google !== 'undefined') {
        window.initMap();
    }
});