let profile = document.querySelector('.header .flex .profile-detail');

document.querySelector('#user-btn').onclick = () =>{
    profile.classList.toggle('active');
    searchForm.classList.remove('active');
}

let searchForm = document.querySelector('.header .flex .search-form');
document.querySelector('#search-btn').onclick = () =>{
    searchForm.classList.toggle('active');
    profile.classList.remove('active');
}

let navbar = document.querySelector('.navbar');

document.querySelector('#menu-btn').onclick = () =>{
    navbar.classList.toggle('active');
}
const imgBox = document.querySelector('.slider-container');
const slides = document.getElementsByClassName('slideBox');
var i = 0;

function nextSlide(){
    slides[i].classList.remove('active');
    i = (i + 1) % slides.length;
    slides[i].classList.add('active');
}

function prevSlide(){
    slides[i].classList.remove('active');
    i = (i - 1 + slides.length) % slides.length;
    slides[i].classList.add('active');
}

const btn = document.getElementsByClassName('btn1');
const slide = document.getElementById('slide');

btn[0].onclick = function () {
    slide.style.transform = "translateX(0px)";
    for (var i = 0; i < 4; i++) {
        btn[i].classList.remove("active");
    }
    this.classList.add("active");
}
btn[1].onclick = function () {
    slide.style.transform = "translateX(-800px)";
    for (var i = 0; i < 4; i++) {
        btn[i].classList.remove("active");
    }
    this.classList.add("active");
}
btn[2].onclick = function () {
    slide.style.transform = "translateX(-1600px)";
    for (var i = 0; i < 4; i++) {
        btn[i].classList.remove("active");
    }
    this.classList.add("active");
}
btn[3].onclick = function () {
    slide.style.transform = "translateX(-2400px)";
    for (var i = 0; i < 4; i++) {
        btn[i].classList.remove("active");
    }
    this.classList.add("active");
}
$(document).ready(function() {
    fetchRatingCount(); // Fetch rating count when the page loads

    $('.rating .star').click(function() {
        var cakeId = $('#product_id').val();
        var rating = $(this).attr('data-value');

        // Highlight selected stars
        $(this).siblings().removeClass('selected');
        $(this).addClass('selected');
        $(this).prevAll().addClass('selected');

        // Submit rating via AJAX
        $.ajax({
            type: 'POST',
            url: 'submit_rating.php',
            data: { cake_id: cakeId, rating: rating },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.success) {
                    alert('Rating submitted successfully!');
                    fetchRatingCount(); // Update rating count after submitting
                }
            },
            error: function(xhr, status, error) {
                console.error("Error: " + xhr.responseText);
                alert('Failed to submit rating.');
            }
        });
    });
});

$(document).ready(function() {
    // Function to fetch and update the rating count
    function fetchRatingCount() {
        var cakeId = $('#product_id').val();

        $.ajax({
            type: 'POST',
            url: 'get_rating_count.php', // URL to fetch rating count from the server
            data: { cake_id: cakeId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update the rating count on the page
                    updateRatingCount(response.rating_count);
                } else {
                    console.error("Error: " + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error: " + xhr.responseText);
            }
        });
    }

    // Function to update the rating count on the page
    function updateRatingCount(count) {
        $('#rating_count').text(count);
    }

    // Event listener for clicking on a star to rate the product
    $('.rating .star').click(function() {
        var cakeId = $('#product_id').val();
        var rating = $(this).attr('data-value');

        $.ajax({
            type: 'POST',
            url: 'submit_rating.php', // URL to submit rating
            data: { cake_id: cakeId, rating: rating },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Fetch and update the rating count after successful rating submission
                    fetchRatingCount();
                    // Optionally, you can provide feedback to the user about the successful rating submission
                } else {
                    console.error("Error: " + response.error);
                    // Optionally, you can provide feedback to the user about the error
                }
            },
            error: function(xhr, status, error) {
                console.error("Error: " + xhr.responseText);
                // Optionally, you can provide feedback to the user about the error
            }
        });
    });

    // Fetch and update the rating count when the page loads
    fetchRatingCount();
});

