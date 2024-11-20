
  
<style>
/* Overlay styles */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7); /* Dark transparent background */
  display: none; 
  justify-content: center;
  align-items: center;
}

.overlay-content {
  background-color: #fff;
  margin: 0;
  margin-top: var(--topbar-height);
  margin-left: var(--sidebar-width); /* Dynamically set in JavaScript */
  padding: 15px 15px;
  height: calc(80dvh - var(--topbar-height));
  width: 70vw;
  border-radius: 5px;
  text-align: center;
  z-index: 1000;
  transition: margin-left 0.3s ease; /* Smooth transition when the margin changes */
  overflow-x: hidden;
  overflow-y: auto;
  white-space: hidden;

}

#closeOverlay {
    display: grid;
    position: sticky;
    top: 0;
    left: 97%;
    margin: 0;
    padding: 5px;
    background-color: var(--secondary-color);
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

#closeOverlay:hover {
  background-color: rgba(0, 0, 0, 0.2);
}

.product-container {
    padding: 20px;
    /* overflow: auto; */
    margin: 0;
    margin-top: -30px;
}

.product-grid-container {
    display: grid;
    /* grid-template-columns: max-content(2, 1fr); */
    grid-template-columns: 35% auto;
    grid-gap: 30px;
}
.product-title {
    font-size: 24px;
    margin: 0;
    margin-bottom: 15px;
    padding: 15px 0 15px;
    border-bottom: 3px solid #eee;
}
.first-product-grid-container {
    margin: 0;
    padding: 0;
    align-content: start;
    justify-content: center;
}
.second-product-grid-container {
    margin: 0;
    padding: 0;
    /* align-content: start; */
    text-align: justify;
    align-content: space-between;

}
.product-grid-container-selection {
    margin: 0;
    padding: 0;
}
.product-con-price-ratings {
    margin: 40px 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
}.product-con-price-ratings .product-rating {
    margin: 15px auto;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: start;
}
.rating:not(:checked) > label {
    font-size: 1.2em;
}
.product-con-price-ratings .product-rating p, .num-rate {
    margin: 0;
    padding: 20px 0;
    font-size: .8em;
}.product-con-price-ratings .price-container {
    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
    width: max-content;
    margin: 0;
    justify-content: end;
}.product-con-price-ratings .price-container table {
    table-layout: fixed;
    width: auto;
    border: none;
    text-align: start;
}.product-con-price-ratings .price-container table .addedPrice {
    font-size: 14px;
}.product-con-price-ratings .price-container table .priceRange {
    height: 40px;
}
.carousel {
    position: relative;
    width: 100%;
    height: auto;
    overflow: hidden;
}
.carousel-images {
    display: flex;
    transition: transform 0.5s ease;
    width: 100%;
    min-height: auto;
    max-height: 500px;
}
.carousel-images img {
    width: 100%;
    display: block;
    object-fit: fill;
    object-position: center;
}
.carousel-button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;

    display: none; /* remove nalang this */
}
.carousel-button.left {
    left: 10px;
}
.carousel-button.right {
    right: 10px;
}
.thumbnail-container {
    display: flex;
    justify-content: center;
    margin-top: 10px;
}
.thumbnail {
    width: 60px;
    height: 60px;
    margin: 0 5px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: border-color 0.3s;
    
    display: none; /* remove nalang this */
}
.thumbnail:hover {
    border-color: #e74c3c;
}
.active-thumbnail {
    border-color: #e74c3c;
}
.product-rating, .price, .shop-vouchers, .return-info, .bundle-deals, .shipping-info {
    margin-top: 10px;
}
.color-options {
    margin-top: 10px;
}
.color-option {
    display: inline-block;
    width: 20px;
    height: 20px;
    margin-right: 5px;
    border: 1px solid #000;
}
.shipping-info {
    text-align: center;
}
.product-buttons-container {
    margin: 15px 0 0;
    padding: 0;
    max-width: 100%;
    display: flex;
    /* justify-content: space-between; */
    justify-content: center;
    gap: 10px;
}
.product-buttons-container .button {
    background-color: var(--quinary-color);
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
    margin: 0;
    width: 50%;
}
.product-buttons-container button:hover {
    background-color: var(--senary-color);
}
.product-grid-container-selection .pgc-description {
    margin: 0;
    font-size: .9em;
    /* font-style: italic; */
    font-weight: 600;

}
.cust-sel-opt-con {
    margin: 40px 0;
}.info-tooltip-icon .tooltiptext {
    top: -115%;
    left: 0;
    margin-left: -200px;
}

@media screen and (max-width: 800px) {
    .product-grid-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 10px;
        flex: 1;
    }
}

</style>
