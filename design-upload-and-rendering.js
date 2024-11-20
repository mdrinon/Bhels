// Function to reset selections for both single and tiered cake options
function resetCakeSelections() {
    // Reset single cake dropdown to default selection
    const singleCakeSelect = document.getElementById('product-size-pricing');
    if (singleCakeSelect) {
        singleCakeSelect.selectedIndex = 0; // Reset to "Select size based on the amount"
    }

    // Remove active state from all tiered cake options
    document.querySelectorAll('.cake-option').forEach(option => {
        option.classList.remove('active');
    });

    // Hide continue buttons for both single and tiered options
    document.getElementById("continue-budget-btn").style.display = "none";
}

// Event listener to reset selections and toggle continue button on budget change
document.getElementById('budget-select').addEventListener('change', function() {
    resetCakeSelections(); // Clear previous selections when budget changes
    toggleContinueButton(); // Update continue button visibility based on new selection
});

// Function to reset tiered cake selection
function resetTieredCakeSelection() {
    // Remove the 'selected' class from all .cake-option elements within #tiered__cake
    document.querySelectorAll('#tiered__cake .cake-option').forEach(option => {
        option.classList.remove('selected');
    });
}

// Event listener to reset selections and toggle containers on desired cake type change
document.getElementById('tiered-cake-select').addEventListener('change', function() {
    if (this.value === 'single') {
        // If the user selects the single cake type, reset the tiered cake selection
        resetTieredCakeSelection();
    }
    
    resetCakeSelections(); // Clear previous selections when cake type changes

    // Show the appropriate container based on selected cake type
    const selectedValue = this.value;
    const tieredCakeContainer = document.getElementById('tiered__cake');
    const singleCakeContainer = document.getElementById('single__cake');

    if (selectedValue === 'tiered') {
        tieredCakeContainer.style.display = 'flex';
        singleCakeContainer.style.display = 'none';
    } else if (selectedValue === 'single') {
        tieredCakeContainer.style.display = 'none';
        singleCakeContainer.style.display = 'block';
    }
});

// Updated function to toggle the continue button based on selections
function toggleContinueButton() {
    const continueButton = document.getElementById("continue-budget-btn");
    const selectedSingleCake = document.querySelector(".single__cake .cake-option.active");
    const selectedTieredCake = document.querySelector(".qpp__cake__selection__table .cake-option.active");

    // Show continue button only if either single or tiered cake option is selected
    if (selectedSingleCake || selectedTieredCake) {
        continueButton.style.display = "block";
    } else {
        continueButton.style.display = "none";
    }
}

// Function to clear tiered cake selection
function clearTieredCakeSelection() {
    document.querySelectorAll(".qpp__cake__selection__table .cake-option").forEach(option => {
        option.classList.remove("active"); // Remove active class from all tiered options
    });
}

// Event listener for tiered cake selection
document.querySelectorAll(".qpp__cake__selection__table .cake-option").forEach(cakeOption => {
    cakeOption.addEventListener("click", function () {
        // Remove 'active' class from other cake options in tiered selection
        document.querySelectorAll(".qpp__cake__selection__table .cake-option").forEach(option => option.classList.remove("active"));
        
        // Add 'active' class to the clicked option
        this.classList.add("active");
        
        // Toggle the continue button after selection
        toggleContinueButton();
    });
});

// Show/hide cake selection containers based on the desired cake type selected
document.getElementById("tiered-cake-select").addEventListener("change", function() {
    const selectedValue = this.value;
    const tieredCakeContainer = document.querySelector("#tiered__cake"); // Use class instead of id
    const singleCakeContainer = document.querySelector(".single__cake");
    
    // Hide both containers initially
    tieredCakeContainer.style.display = "none";
    singleCakeContainer.style.display = "none";
    
    // Show the correct container and reset selections based on the selected option
    if (selectedValue === "tiered") {
        tieredCakeContainer.style.display = "flex";
        clearSingleCakeSelection(); // Clear any single cake selection if switching to tiered
    } else if (selectedValue === "single") {
        singleCakeContainer.style.display = "block";
        clearTieredCakeSelection(); // Clear any tiered cake selection if switching to single
    }

    // Hide the continue button initially until a selection is made
    document.getElementById("continue-budget-btn").style.display = "none";
});

// third pop up question starts here

document.getElementById('design-upload').addEventListener('change', function(event) {
    const fileInput = event.target;
    const filePreview = document.getElementById('file-preview');
    const fileNameDisplay = document.getElementById('file-name');
    const files = fileInput.files;

    // Clear previous previews and filenames
    filePreview.innerHTML = '';
    fileNameDisplay.textContent = '';

    if (files.length > 0) {
        const file = files[0];
        const fileName = file.name;

        // Truncate the filename if too long
        const truncatedFileName = fileName.length > 20 ? fileName.slice(0, 17) + '...' : fileName;
        fileNameDisplay.textContent = truncatedFileName;

        // Create a preview for images or videos
        const fileType = file.type;

        if (fileType.startsWith('image/')) {
            // Create image preview
            const imgPreview = document.createElement('img');
            imgPreview.classList.add('qpp__image-preview');
            imgPreview.src = URL.createObjectURL(file);
            imgPreview.onload = function() {
                URL.revokeObjectURL(imgPreview.src); // Free memory after loading
            };
            filePreview.appendChild(imgPreview);
        // } else if (fileType.startsWith('video/')) {
        //     // Create video preview
        //     const videoPreview = document.createElement('video');
        //     videoPreview.classList.add('qpp__video-preview');
        //     videoPreview.controls = true;
        //     videoPreview.src = URL.createObjectURL(file);
        //     videoPreview.onload = function() {
        //         URL.revokeObjectURL(videoPreview.src); // Free memory after loading
        //     };
        //     filePreview.appendChild(videoPreview);
        } else {
            // Non-previewable file types (e.g., other file formats)
            filePreview.textContent = 'Preview not available for this file type.';
        }
    }
});

const fileInput = document.getElementById('design-upload');
const filePreviewContainer = document.getElementById('file-preview-container');

let selectedFiles = [];

const maxSizeInMB = 10;
const maxSizeInBytes = maxSizeInMB * 1024 * 1024; // Convert MB to bytes

fileInput.addEventListener('change', function(event) {
    const newFiles = Array.from(fileInput.files); // Convert to an array to handle new files
    const validFiles = []; // Array to store files within the size limit

    // Check if new selection would exceed the 5-file limit
    if (selectedFiles.length + newFiles.length > 5) {
        alert("You can upload a maximum of 5 files.");
        return;
    }

    // Filter files by size and only add those within the limit to validFiles
    newFiles.forEach((file) => {
        if (file.size > maxSizeInBytes) {
            alert(`The file "${file.name}" exceeds the 10MB limit and won't be uploaded.`);
        } else {
            validFiles.push(file);
        }
    });

    // Update the selectedFiles array with only valid files
    selectedFiles = [...selectedFiles, ...validFiles];

    // Clear the preview container before rendering
    filePreviewContainer.innerHTML = '';

    // Loop through the selected files and render the filenames
    selectedFiles.forEach((file, index) => {
        const fileExtension = file.type === 'image/png' ? 'png' : 'jpg';
        const date = new Date();
        const dateString = `${date.getFullYear()}${(date.getMonth() + 1).toString().padStart(2, '0')}${date.getDate().toString().padStart(2, '0')}`;
        const uniqueNumber = Date.now() + Math.floor(Math.random() * 1000); // Add random number to ensure uniqueness
        const uniqueFileName = `${dateString}_${uniqueNumber}_${(index + 1).toString().padStart(4, '0')}.${fileExtension}`;

        // Store the unique filename in the file object for later use
        file.uniqueFileName = uniqueFileName;

        // Create a container for each file preview
        const fileContainer = document.createElement('div');
        fileContainer.classList.add('qpp__file-preview-item');

        // Create an element for an SVG icon
        const svgIcon = document.createElement('img');
        svgIcon.src = 'ADMIN/images/svg/clip.png'; // Ensure this path is correct
        svgIcon.classList.add('qpp__file-icon');
        fileContainer.appendChild(svgIcon);

        // Display the generated filename
        const fileNameElement = document.createElement('p');
        fileNameElement.classList.add('qpp__file-name');
        fileNameElement.textContent = uniqueFileName;
        fileContainer.appendChild(fileNameElement);

        // Create and add the remove button
        const removeButton = document.createElement('button');
        removeButton.classList.add('qpp__remove-btn');
        removeButton.textContent = 'x';
        removeButton.onclick = function() {
            // Remove the file from the selectedFiles array
            selectedFiles.splice(index, 1);
            // Re-render the previews
            renderFilePreviews();
        };
        fileContainer.appendChild(removeButton);

        // Append the file container to the preview grid
        filePreviewContainer.appendChild(fileContainer);
    });
});

// Function to render file previews
function renderFilePreviews() {
    // Clear the preview container before rendering
    filePreviewContainer.innerHTML = '';

    // Loop through the selected files and render the filenames
    selectedFiles.forEach((file, index) => {
        const fileExtension = file.type === 'image/png' ? 'png' : 'jpg';
        const date = new Date();
        const dateString = `${date.getFullYear()}${(date.getMonth() + 1).toString().padStart(2, '0')}${date.getDate().toString().padStart(2, '0')}`;
        const uniqueFileName = `${dateString}_${(index + 1).toString().padStart(4, '0')}.${fileExtension}`;

        // Create a container for each file preview
        const fileContainer = document.createElement('div');
        fileContainer.classList.add('qpp__file-preview-item');

        // Create an element for an SVG icon
        const svgIcon = document.createElement('img');
        svgIcon.src = 'ADMIN/images/svg/clip.png'; // Ensure this path is correct
        svgIcon.classList.add('qpp__file-icon');
        fileContainer.appendChild(svgIcon);

        // Display the generated filename
        const fileNameElement = document.createElement('p');
        fileNameElement.classList.add('qpp__file-name');
        fileNameElement.textContent = uniqueFileName;
        fileContainer.appendChild(fileNameElement);

        // Create and add the remove button
        const removeButton = document.createElement('button');
        removeButton.classList.add('qpp__remove-btn');
        removeButton.textContent = 'x';
        removeButton.onclick = function() {
            // Remove the file from the selectedFiles array
            selectedFiles.splice(index, 1);
            // Re-render the previews
            renderFilePreviews();
        };
        fileContainer.appendChild(removeButton);

        // Append the file container to the preview grid
        filePreviewContainer.appendChild(fileContainer);
    });
}

function submitDesign(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    const fileInput = document.getElementById('design-upload');
    const designNotes = document.getElementById('design-notes').value;
    const designContainer = document.querySelector('.qpp__order__design__container');
    const designNotesInfo = document.getElementById('design-notes-info');

    // Check if a file is uploaded
    if (fileInput.files.length === 0) {
        alert("Please upload your design file.");
        return;
    }

    const files = fileInput.files;

    // Validate file type (image)
    const allowedFileTypes = ['image/jpeg', 'image/png'];
    for (let file of files) {
        if (!allowedFileTypes.includes(file.type)) {
            alert("Invalid file type. Please upload an image.");
            return;
        }

        // Validate file size (should not exceed 10MB)
        const maxSizeInMB = 10;
        const maxSizeInBytes = maxSizeInMB * 1024 * 1024; // Convert MB to bytes
        if (file.size > maxSizeInBytes) {
            alert("File size exceeds 10MB. Please upload a smaller file.");
            return;
        }
    }

    // Ensure there's at least one file uploaded
    if (selectedFiles.length === 0) {
        alert("Please upload your design files.");
        return;
    }

    // Clear previous previews in the order details
    designContainer.innerHTML = '';

    // Display design notes in the order details
    designNotesInfo.textContent = designNotes || ''; // Only populate if notes are provided

    // Upload files to the server
    const formData = new FormData();
    const uploadedFiles = [];
    const date = new Date();
    const dateString = `${date.getFullYear()}${(date.getMonth() + 1).toString().padStart(2, '0')}${date.getDate().toString().padStart(2, '0')}`;
    let fileCounter = 1;

    for (let file of selectedFiles) {
        const uniqueFileName = file.uniqueFileName; // Use the stored unique filename
        formData.append('designFiles[]', file, uniqueFileName);
        uploadedFiles.push(uniqueFileName);
        fileCounter++;
    }

    fetch('uploadDesignReferences.php', {
        method: 'POST',
        body: formData
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              console.log('Files uploaded successfully');
              alert("Your design has been submitted successfully!");

              // Store the uploaded file names and paths in local storage
              const orderDetails = JSON.parse(localStorage.getItem('orderDetails')) || {};
              orderDetails.designNotes = designNotes;
              orderDetails.uploadedFiles = uploadedFiles.map(fileName => `ADMIN/uploads/uploadedDesignReferences/${fileName}`);
              localStorage.setItem('orderDetails', JSON.stringify(orderDetails));

              // Display the filenames along with the images in the order details container
              uploadedFiles.forEach(fileName => {
                  const fileElement = document.createElement('div');
                  fileElement.classList.add('qpp__file-preview-item');
                  fileElement.innerHTML = `
                      <p class="qpp__file-name">${fileName}</p>
                      <img class="qpp__image-preview" src="ADMIN/uploads/uploadedDesignReferences/${fileName}">
                  `;
                  designContainer.appendChild(fileElement);
              });

              // Redirect to question 4
              nextQuestion(4);
          } else {
              console.error('File upload failed', data.errors);
              alert("File upload failed: " + data.errors.join(', '));
          }
      }).catch(error => {
          console.error('Error:', error);
          alert("An error occurred during file upload.");
      });
}

