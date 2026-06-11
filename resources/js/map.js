window.initMap = function () {
    const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 56.91, lng: 24.13 },
        zoom: 12,
    });

    (window.masinas || []).forEach(masina => {
        if (!masina.lokacija) return;

        new google.maps.Marker({
            position: {
                lat: parseFloat(masina.lokacija.platuma_gradi),
                lng: parseFloat(masina.lokacija.garuma_gradi)
            },
            map,
        });
    });
};

window.addEventListener('load', () => {
    if (typeof google !== 'undefined') {
        window.initMap();
    }
});