let slideIndex2 = 1;
showSlides2(slideIndex2);

function plusSlides(n) {
    showSlides2(slideIndex2 += n);
}

function currentSlide(n){
    showSlides2(slideIndex2 = n);
}

function showSlides2(n){
    let i;
    let slides2 = document.getElementsByClassName("slide");
    let dots2 = document.getElementsByClassName("dot");
    if(n > slides2.length) {slideIndex2 = 1}
    if(n < 1) {slideIndex2 = slides2.length}
    for(i =0 ; i < slides2.length; i++){
        slides2[i].style.display = "none";
    }
    for(i = 0; i < dots2.length; i++){
        dots2[i].className = dots2[i].className.replace(" active","");
    }
    slides2[slideIndex2-1].style.display = "block";
    dots2[slideIndex2-1].className += " active";
}

//---------auto
let slideIndex = 0;
showSlides();

function showSlides(){
    let i;
    let slides = document.getElementsByClassName("slide");
    let dots = document.getElementsByClassName("dot");
    for(i =0 ; i < slides.length; i++){
        slides[i].style.display = "none";
    }
    slideIndex++;
    if(slideIndex > slides.length) {slideIndex =1}

    for(i=0 ;i < dots.length; i++){
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 3000);
}