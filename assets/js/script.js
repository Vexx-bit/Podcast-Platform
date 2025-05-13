const menuToggle = document.querySelector('.menu-toggle');
const navbar = document.querySelector('.navbar');

menuToggle.addEventListener('click', () => {
  navbar.classList.toggle('open'); 
  menuToggle.classList.toggle('open');
});

//testimonial functionality

 document.addEventListener('DOMContentLoaded', function () {
        const testimonials = document.querySelectorAll('.testimonial-item');
        let currentTestimonial = 0;
        const totalTestimonials = testimonials.length;
        const intervalTime = 3000; // Change this to 400 for faster switching

        // Show the first testimonial
        testimonials[currentTestimonial].classList.add('active');

        // Function to switch testimonials
        function switchTestimonial() {
            // Hide the current testimonial
            testimonials[currentTestimonial].classList.remove('active');
            
            // Move to the next testimonial
            currentTestimonial = (currentTestimonial + 1) % totalTestimonials;

            // Show the next testimonial
            testimonials[currentTestimonial].classList.add('active');
        }

        // Run switchTestimonial function every intervalTime
        setInterval(switchTestimonial, intervalTime);
    });


