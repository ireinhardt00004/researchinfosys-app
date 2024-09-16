const profilebtn = document.querySelectorAll('#profile')
const messBTN = document.querySelectorAll('#mess')
const notifBTN = document.querySelectorAll('#notif')
const drawerProf = document.getElementById('drawerProf')
const drawerMess = document.getElementById('drawerMess')
const drawerNotif = document.getElementById('drawerNotif')

messBTN.forEach((e)=>{
    e.addEventListener('click', ()=>{
        drawerMess.classList.toggle('hidden')
    })
})
notifBTN.forEach((e)=>{
    e.addEventListener('click', ()=>{
        drawerNotif.classList.toggle('hidden')
    })
})



profilebtn.forEach((e)=>{
    e.addEventListener('click', ()=>{
        drawerProf.classList.toggle('hidden')
    })
})
