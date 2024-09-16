const hideSideElem = document.querySelectorAll('#hideSideElem')
const hideSidebar = document.getElementById('hideSidebar')
const sidebar = document.getElementById('sidebar')


const hidetext = ()=>{
    sidebar.classList.toggle('sm:w-[25%]')
     hideSideElem.forEach((t)=>{
    t.classList.toggle('sm:hidden')
     if(sidebar.classList.contains('sm:w-[25%]')){
        console.log('bla')
        hideSidebar.innerHTML = "&#11207;"
    }else{
        console.log('bla2')
        hideSidebar.innerHTML ="&#11208;"
    }
    
})
}
hideSidebar.addEventListener('click', ()=>{

   
    
   hidetext()
})
