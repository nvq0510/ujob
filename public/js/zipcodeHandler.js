document.addEventListener('DOMContentLoaded', function () {
    const zipcodeInput = document.getElementById('zipcode');
    const addressInput = document.getElementById('address');

    if (zipcodeInput && addressInput) {
        zipcodeInput.addEventListener('input', function() {
            let zipcode = this.value.replace(/\D/g, '');
            this.value = zipcode;

            if (zipcode.length === 7) { 
                fetch(`/api/addresses/${zipcode}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.region_kanji && data.city_kanji && data.area_kanji) {
                            addressInput.value = `${data.region_kanji} ${data.city_kanji} ${data.area_kanji}`;
                        } else {
                            addressInput.value = '住所が見つかりません';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        addressInput.value = '住所が見つかりません';
                    });
            }
        });
    }
});
