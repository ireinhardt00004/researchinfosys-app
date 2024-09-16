const navMobBtn = document.getElementById('navMobBtn')
const navMob = document.getElementById('navMob')

console.log(navMobBtn, navMob)


navMobBtn.addEventListener('click', ()=>{
    navMob.classList.toggle('hidden')
    if (navMob.classList.contains('hidden')) {
        navMobBtn.innerHTML = "&#11206;"
    }else{
         navMobBtn.innerHTML = " &#11205;"
    }
    
})



