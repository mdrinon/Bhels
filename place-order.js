// Description: This file contains the JavaScript code for the Place Order page.

var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('delivery-details-form');
    const placeOrderBtn = document.getElementById('place-order-btn');
    const deliveryDateInput = document.getElementById('delivery_date');
    const cityMunicipalitySelect = document.getElementById('city_municipality');
    const barangaySelect = document.getElementById('barangay');

    function showErrorMessage(input, message) {
        const errorSpan = document.getElementById(`${input.id}_error`);
        if (errorSpan) {
            errorSpan.textContent = message;
            errorSpan.style.display = 'block';
        }
    }

    function hideErrorMessage(input) {
        const errorSpan = document.getElementById(`${input.id}_error`);
        if (errorSpan) {
            errorSpan.textContent = '';
            errorSpan.style.display = 'none';
        }
    }

    function validateInput(input) {
        if (!input.checkValidity()) {
            showErrorMessage(input, input.validationMessage);
        } else {
            hideErrorMessage(input);
        }
    }

    function togglePlaceOrderButton() {
        console.log('Checking form validity...');
        console.log('Form valid:', form.checkValidity());
        console.log('City Municipality:', cityMunicipalitySelect.value);
        console.log('Barangay:', barangaySelect.value);
        console.log('Delivery Date:', deliveryDateInput.value);
        if (form.checkValidity() && deliveryDateInput.value) {
            placeOrderBtn.style.display = 'block';
            console.log('Button displayed');
        } else {
            placeOrderBtn.style.display = 'none';
            console.log('Button hidden');
        }
    }

    form.addEventListener('input', function (event) {
        validateInput(event.target);
        togglePlaceOrderButton();
    });

    form.addEventListener('change', function (event) {
        validateInput(event.target);
        togglePlaceOrderButton();
    });

    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            Array.from(form.elements).forEach(validateInput);
        }
    });

    // Check form validity on page load
    togglePlaceOrderButton();

    const barangays = {
        Guinobatan: ['Banao', 'Binanowan', 'Poblacion', 'Ilawod', 'Travesia'],
        'Ligao City': ['Bagumbayan', 'Basag', 'Binatagan', 'Calzada', 'Dunao', 'Guilid', 'Mahaba', 'Nasisi', 'Paulog', 'Tinago'],
        Oas: ['Badbad', 'Badian', 'Bagsa', 'Bagumbayan', 'Balogo', 'Banao', 'Bangiawon', 'Bogtong', 'Bongoran', 'Busac', 'Cadawag', 'Cagmanaba', 'Calaguimit', 'Calpi', 'Calzada', 'Camagong', 'Casinagan', 'Centro Poblacion', 'Coliat', 'Del Rosario', 'Gumabao', 'Ilaor Norte', 'Ilaor Sur', 'Iraya Norte', 'Iraya Sur', 'Manga', 'Maporong', 'Maramba', 'Matambo', 'Mayag', 'Mayao', 'Moroponros', 'Nagas', 'Obaliw-Rinas', 'Pistola', 'Ramay', 'Rizal', 'Saban', 'San Agustin', 'San Antonio', 'San Isidro', 'San Jose', 'San Juan', 'San Miguel', 'San Pascual', 'San Ramon', 'San Vicente', 'Tablon', 'Talisay', 'Talongog', 'Tapel', 'Tobog'],
        Polangui: ['Centro occidental', 'Centro orriental', 'Magurang', 'Basud', 'Sugcad', 'Alomon', 'Kinale', 'Ubaliw', 'Ponso']
    };

    cityMunicipalitySelect.addEventListener('change', function () {
        const selectedCity = cityMunicipalitySelect.value;
        const options = barangays[selectedCity] || [];
        barangaySelect.innerHTML = options.map(barangay => `<option value="${barangay}">${barangay}</option>`).join('');
        console.log('Barangay options updated for:', selectedCity);
        togglePlaceOrderButton(); // Check validity after updating options
    });

    // Trigger change event to populate barangays on page load
    cityMunicipalitySelect.dispatchEvent(new Event('change'));

    // Set minimum delivery date to 10 days from today
    const today = new Date();
    const minDeliveryDate = new Date(today.setDate(today.getDate() + 10));
    const minDeliveryDateString = minDeliveryDate.toISOString().split('T')[0];
    deliveryDateInput.setAttribute('min', minDeliveryDateString);
    console.log('Minimum delivery date set to:', minDeliveryDateString);

    placeOrderBtn.addEventListener('click', function () {
        const designId = document.querySelector('#design_id').textContent.trim();
        const productName = document.querySelector('#product-name').textContent.trim();
        const isCustomizedOrder = productName === 'Customized Cake';
        const filePath = isCustomizedOrder ? 'ADMIN/uploads/uploadedDesignReferences/' : 'ADMIN/uploads/';

        const orderData = {
            quantity: parseInt(document.querySelector('#quantity').textContent.replace(/[^\d]/g, ''), 10),
            subTotal: parseInt(document.querySelector('#subTotal').textContent.replace(/[^\d]/g, ''), 10),
            shippingFee: parseInt(document.querySelector('#shippingFee').textContent.replace(/[^\d]/g, ''), 10),
            orderTotal: parseInt(document.querySelector('#orderTotal').textContent.replace(/[^\d]/g, ''), 10),
            delivery_date: document.querySelector('#delivery_date').value,
            delivery_time: document.querySelector('#delivery_time').value,
            delivery_address: `${document.querySelector('#zone_purok').value.trim()}, ${document.querySelector('#barangay').value.trim()}, ${document.querySelector('#city_municipality').value.trim()}, ${document.querySelector('#province').value.trim()}`,
            recipient_name: document.querySelector('#recipient_name').value.trim(),
            recipient_phone: document.querySelector('#recipient_phone').value.trim(),
            customer_id: document.querySelector('#customer_id').value,
            customer_name: document.querySelector('#fullname').value.trim(),
            customer_username: document.querySelector('#username').value.trim(),
            customer_phone: document.querySelector('#phone').value.trim(),
            customer_email: document.querySelector('#email').value.trim(),
            PlacedOrderDetails: {
                product_name: productName,
                price_range: '₱6000 Above',
                cake_size: document.querySelector('#product-size').textContent.split(': ')[1].trim(),
                flavors: document.querySelector('#flavor').textContent.split(': ')[1].trim(),
                dedication: document.querySelector('#dedication').textContent.trim(),
                money_cake: document.querySelector('#money-cake').textContent.trim(),
                note: document.querySelector('#note').textContent.trim(),
                selected_files: Array.from(document.querySelectorAll('.carousel .product-image')).map((img, index) => ({
                    [`cake_design${index + 1}`]: {
                        file_name: img.src.split('/').pop().trim(),
                        file_type: img.src.split('.').pop().trim(),
                        file_path: filePath
                    }
                }))
            }
        };

        if (!isCustomizedOrder) {
            orderData.PlacedOrderDetails.design_id = designId;
        }

        fetch('insert_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(orderData)
        })
        .then(response => response.text()) // Change to text to log the raw response
        .then(text => {
            try {
                const data = JSON.parse(text); // Parse the JSON manually
                if (data.success) {
                    alert('Order placed successfully!');
                    const orderId = data.order_id.$oid || data.order_id; // Extract the ObjectId or fallback to order_id
                    window.location.href = 'payment.php?order_id=' + encodeURIComponent(orderId);
                } else {
                    console.error('Failed to place order:', data.message);
                    alert('Failed to place order: ' + data.message);
                }
            } catch (error) {
                console.error('Failed to parse JSON:', text);
                alert('An error occurred while placing the order.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while placing the order.');
        });
    });

});

// Carousel functionality
let currentSlide = 0;
let slides = [];
let previews = [];

function initializeCarousel() {
    slides = document.querySelectorAll('.carousel img');
    previews = document.querySelectorAll('.image-previews img');
}

function changeSlide(n) {
    if (slides.length === 0) return;
    slides[currentSlide].classList.remove('active');
    previews[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + n + slides.length) % slides.length;
    slides[currentSlide].classList.add('active');
    previews[currentSlide].classList.add('active');
}

function showSlide(n) {
    if (slides.length === 0) return;
    slides[currentSlide].classList.remove('active');
    previews[currentSlide].classList.remove('active');
    currentSlide = n;
    slides[currentSlide].classList.add('active');
    previews[currentSlide].classList.add('active');
}

function startAutoSlide() {
    setInterval(() => {
        changeSlide(1);
    }, 3000); // Change slide every 3 seconds
}

function adjustImagePreviewSizes() {
    const previewImages = document.querySelectorAll('.image-previews img');
    const previewCount = previewImages.length;
    const previewWidth = 100 / previewCount; // Calculate width percentage based on the number of images

    previewImages.forEach(img => {
        img.style.width = `${previewWidth}%`;
    });
}

function hideCarouselButtons() {
    const prevButton = document.querySelector('.carousel .prev');
    const nextButton = document.querySelector('.carousel .next');
    if (slides.length <= 1) {
        prevButton.style.display = 'none';
        nextButton.style.display = 'none';
    }
}

// Initialize carousel after DOM content is loaded
document.addEventListener('DOMContentLoaded', initializeCarousel);

