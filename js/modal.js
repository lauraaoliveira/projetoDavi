const btnsOpenModal = document.querySelectorAll(".btn-open-modal");

btnsOpenModal.forEach(button =>{
  button.addEventListener('click', ()=>{
    
    const modalId = button.getAttribute("data-modal");
    const modal = document.getElementById(modalId);
    console.log("TESTE")
    modal.showModal();
  });
});

const btnsCloseModal = document.querySelectorAll(".btn-close-modal");

btnsCloseModal.forEach(button =>{
  button.addEventListener('click', ()=>{
    console.log(modalId)
    const modalId = button.getAttribute("data-modal");
    const modal = document.getElementById(modalId);
    modal.close();
  })
})