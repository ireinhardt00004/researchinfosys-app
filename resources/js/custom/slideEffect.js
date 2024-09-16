window.addEventListener("DOMContentLoaded", () => {
    const secs = document.querySelectorAll('.tago')

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('labas')
            } else {
                entry.target.classList.remove('labas')
            }
        })
    }
        , {
            threshold: .5,

        }
    )

    secs.forEach((sec) => {
        observer.observe(sec)
    })
})