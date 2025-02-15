const sliderTabs=document.querySelectorAll(".navigations");
const swiper=new Swiper(".slider",{
    effect:"slide",
    speed:1000,
    /*autoplay:{delay:2000}*/
});
let searchForm=document.querySelector('.search-form');
document.querySelector('#fa-search').onclick=() =>
{
    searchForm.classList.toggle('active');
}
      document.addEventListener('DOMContentLoaded', () => {
        let currentIndex = 0;
        const slides = document.querySelectorAll('.container');
        const totalSlides = slides.length;
      
        if (!totalSlides) {
          console.error('No slides found! Check your selectors or HTML.');
          return;
        }
      
        // Hide all slides and show the current one
        function updateSlide(index) {
          slides.forEach((slide, i) => {
            slide.style.display = i === index ? 'block' : 'none';
          });
        }
      
        // Initialize first slide
        updateSlide(currentIndex);
      
        // Navigation Buttons
        document.getElementById('slide-prev').addEventListener('click', () => {
          currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
          updateSlide(currentIndex);
        });
      
        document.getElementById('slide-next').addEventListener('click', () => {
          currentIndex = (currentIndex + 1) % totalSlides;
          updateSlide(currentIndex);
        });
      });