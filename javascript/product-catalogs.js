document.addEventListener('DOMContentLoaded', function() {

//THIS SCRIPTS WILL BE EXECUTED BEFORE THE CATALOGS ARE LOADED
// SCRIPT 1 FOR PRODUCT CATALOGS PREV. AND NEXT BUTTON

var current_page = 1;
var records_per_page = 12;

function prevPage()
{
    if (current_page > 1) {
        current_page--;
        changePage(current_page);
    }
}

function nextPage()
{
    if (current_page < numPages()) {
        current_page++;
        changePage(current_page);
    } 
}

function changePage(page)
{
    var btn_next = document.getElementById("next-btn");
    var btn_prev = document.getElementById("prev-btn");
    var listing_table = document.getElementsByClassName("product");
   
    // Validate page
    if (page < 1) page = 1;
    if (page > numPages()) page = numPages();

    for (var i = 0; i < listing_table.length; i++) {
        listing_table[i].style.display = "none";
    }

    for (var i = (page-1) * records_per_page; i < (page * records_per_page) && i < listing_table.length; i++) {
        listing_table[i].style.display = "";

    
        generatePageNumbers();
    }

    btn_prev.disabled = (page == 1) ? true : false;
    btn_next.disabled = (page == numPages()) ? true : false;
}

function numPages()
{
    var listing_table = document.getElementsByClassName("product");
    return Math.ceil(listing_table.length / records_per_page);
}

window.onload = function() {
    changePage(1);
};


document.getElementById('next-btn').addEventListener('click', nextPage);
document.getElementById('prev-btn').addEventListener('click', prevPage);

// generates pages number for the product catalog display
function generatePageNumbers() {
    var page_numbers = document.getElementById("page-numbers");
    page_numbers.innerHTML = ""; // Clear the current page numbers

    for (var i = 1; i <= numPages(); i++) {
        var btn = document.createElement("button");
        btn.innerHTML = i;

        if (i == current_page) {
            btn.disabled = true; // Disable the button for the current page
        }

        btn.addEventListener("click", (function(i) {
            return function() {
                current_page = i;
                changePage(current_page);
            };
        })(i));

        page_numbers.appendChild(btn);
    }
}

});