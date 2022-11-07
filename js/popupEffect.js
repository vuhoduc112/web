function toggle(i) {
    var productContainer = document.getElementById('product-container');
    productContainer.classList.toggle('active');
    
    var popup = document.getElementById('popup-'+i); 
    popup.classList.toggle("active");
};