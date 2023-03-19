const button = document.querySelector('.resign-button')

button.addEventListener('click', (e) => {
    if(!confirm("Are you sure?"))
    {
        e.preventDefault()
    }
})

