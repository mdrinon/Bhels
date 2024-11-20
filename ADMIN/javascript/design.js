document.addEventListener('DOMContentLoaded', function() {
        
    $(function() {
        // Slider functionality
        $("#slider-range").slider({
            range: true,
            min: 1,
            max: 15000,
            values: [1, 15000],
            slide: function(event, ui) {
                $("#amount").html(ui.values[0] + " - ₱" + ui.values[1]);
            }
        });
        $("#amount").html($("#slider-range").slider("values", 0) + " - ₱" + $("#slider-range").slider("values", 1));
    });






    // Product hover functionality
    document.querySelectorAll('.product').forEach(function(product) {
        var dlbtn = product.querySelector('#dlbtn');

        product.addEventListener('mouseover', function() {
            dlbtn.style.display = 'block';
        });

        product.addEventListener('mouseout', function() {
            dlbtn.style.display = 'none';
        });
    });

    // Heading visibility on card hover
    function showHeading(card) {
        card.querySelector('.heading').style.display = 'block';
    }

    function hideHeading(card) {
        card.querySelector('.heading').style.display = 'none';
    }


    // Image download with watermark functionality
    function downloadImage(imageFileName, designer) {
        const imagePath = `${imageFileName}`;
        const watermarkText = `Designed by ${designer}`;

        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.src = imagePath;

        img.onload = () => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            canvas.width = img.width;
            canvas.height = img.height;

            ctx.drawImage(img, 0, 0);

            ctx.font = '20px Arial';
            ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
            ctx.fillText(watermarkText, 10, canvas.height - 10);

            const link = document.createElement('a');
            link.download = `cake_design_${designer}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
        };

        img.onerror = () => {
            console.error('Failed to load image for watermarking.');
            alert('Failed to load image for watermarking.');
        };
    }
});
