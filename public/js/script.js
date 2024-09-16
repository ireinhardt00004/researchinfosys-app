const main = document.getElementById('main')
function topFunction() {
    main.scrollTo({
        top: 0,
        behavior: 'smooth'
        
    });
    console.log('Back to Top button clicked');
}
