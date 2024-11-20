window.onload = function() {
    var card = document.querySelector('.recent-order-card');
    var description = document.querySelector('.show_hide-pd');

    card.addEventListener('mouseover', function() {
        description.style.display = 'block';
    });

    card.addEventListener('mouseout', function() {
        description.style.display = 'none';
    });
};