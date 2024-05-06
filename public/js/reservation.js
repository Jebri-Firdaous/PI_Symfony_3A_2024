/**
* Template Name: Mentor
* Template URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
* Updated: Mar 19 2024 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

// Définir les constantes de prix pour chaque type de chambre
const PRIX_NORMAL = 100.0;
const PRIX_STANDARD = 150.0;
const PRIX_LUXE = 200.0;

document.addEventListener('DOMContentLoaded', function() {
    var typeChambreField = document.getElementById('reservation_typeChambre');
    var prixReservationField = document.getElementById('reservation_prixReservation');
    var reservationContainer = document.getElementById('reservation-container');
    var hotelPrices = {};

    if (reservationContainer && reservationContainer.getAttribute('data-hotel-prices')) {
        try {
            hotelPrices = JSON.parse(reservationContainer.getAttribute('data+-hotel-prices'));
        } catch (error) {
            console.error('Erreur lors de la conversion des données JSON :', error);
        }
    }

    var selectedHotelElement = document.getElementById('reservation_idHotel');
    var selectedHotel = selectedHotelElement ? selectedHotelElement.value : '';

    if (typeChambreField && prixReservationField) {
        typeChambreField.addEventListener('change', function() {
            var selectedType = typeChambreField.value;
            var prix = getPrixByType(selectedType, selectedHotel);

            if (prixReservationField) {
                prixReservationField.value = prix;
            }
        });
    }

    function getPrixByType(type, hotel) {
        switch (type) {
            case 'normal':
                return PRIX_NORMAL; // Utilisez la constante PRIX_STANDARD
            case 'standard':
                return PRIX_STANDARD; // Utilisez la constante PRIX_STANDARD
            case 'luxe':
                return PRIX_LUXE; // Utilisez la constante PRIX_LUXE
            default:
                return '';
        }
    }
});
