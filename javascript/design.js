// const express = require('express');
// const { MongoClient } = require('mongodb');
// const cors = require('cors');
// const app = express();

// // Enable CORS for cross-origin requests
// app.use(cors());

// // MongoDB connection string (update with your actual URI)
// const uri = 'mongodb://localhost:27017';
// const client = new MongoClient(uri);

// // Function to get the price range from the MongoDB collection
// async function getPriceRange() {
//     try {
//         await client.connect();
//         const database = client.db('bheldb');
//         const collection = database.collection('cake_designs');

//         // Get the minimum and maximum price
//         const minPrice = await collection.find().sort({ price: 1 }).limit(1).toArray();
//         const maxPrice = await collection.find().sort({ price: -1 }).limit(1).toArray();

//         return {
//             min: minPrice[0].price,
//             max: maxPrice[0].price
//         };
//     } finally {
//         await client.close();
//     }
// }

// // API endpoint to serve the price range to the frontend
// app.get('/get-price-range', async (req, res) => {
//     try {
//         const priceRange = await getPriceRange();
//         res.json(priceRange);
//     } catch (error) {
//         console.error('Failed to fetch price range:', error);
//         res.status(500).json({ error: 'Failed to fetch price range' });
//     }
// });

// // Start the Express server
// app.listen(3000, () => {
//     console.log('Server is running on port 3000');
// });


// $(function() {
//     // Fetch the price range from the backend
//     fetch('http://localhost:3000/get-price-range') // Adjust to your actual server URL
//         .then(response => response.json())
//         .then(data => {
//             const minPrice = data.min;
//             const maxPrice = data.max;

//             // Slider functionality with dynamic min and max
//             $("#slider-range").slider({
//                 range: true,
//                 min: minPrice,  // Dynamically set min price
//                 max: maxPrice,  // Dynamically set max price
//                 values: [minPrice, maxPrice],  // Dynamically set initial values
//                 slide: function(event, ui) {
//                     $("#amount").html("₱" + ui.values[0] + " - ₱" + ui.values[1]);
//                 }
//             });

//             // Set the displayed price range on load
//             $("#amount").html("₱" + $("#slider-range").slider("values", 0) + " - ₱" + $("#slider-range").slider("values", 1));
//         })
//         .catch(error => {
//             console.error('Error fetching price range:', error);
//         });
// });



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
    const imagePath = `ADMIN/${imageFileName}`;
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


    // Get the overlay and button elements
    const overlay = document.getElementById('overlay');
    const overlayButton = document.getElementById('overlayButton');
    const closeOverlay = document.getElementById('closeOverlay');
    
        // Show the overlay when the button is clicked
        overlayButton.addEventListener('click', function() {
        overlay.style.display = 'flex';
        });
    
        // Hide the overlay when the close button is clicked
        closeOverlay.addEventListener('click', function() {
        overlay.style.display = 'none';
        });
    


}
