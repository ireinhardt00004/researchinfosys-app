window.addEventListener('DOMContentLoaded', ()=>{
    const offcanvas = document.getElementById('offcanvas')
    const offcanvasClose = document.querySelectorAll('#offcanvasClose')
    const buttonOffvcanvas = document.getElementById('buttonOffvcanvas')



buttonOffvcanvas.addEventListener('click', ()=>{
    console.log("fire")
    offcanvas.classList.add('w-full')
})


offcanvasClose.forEach((t)=>{
   t.addEventListener('click', ()=>{
    offcanvas.classList.remove('w-full')
   })
})
})


