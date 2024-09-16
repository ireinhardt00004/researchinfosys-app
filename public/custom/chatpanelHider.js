
const chatPanelBtn = document.querySelectorAll('#chatPanelBtn')
const chatPanel = document.getElementById('chatPanel')
console.log(chatPanelBtn)

chatPanelBtn.forEach((t)=>{
    t.addEventListener('click', ()=>{
        console.log('fire')
        chatPanel.classList.toggle('hidden')
    })
})


