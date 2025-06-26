const btnsOpenModal = document.querySelectorAll(".btn-open-modal");

btnsOpenModal.forEach(button =>{
  button.addEventListener('click', ()=>{
    let modalId = button.getAttribute("data-modal");
    let modal = document.getElementById(modalId);
    modal.showModal();
  });
});

const btnsCloseModal = document.querySelectorAll(".btn-close-modal");

btnsCloseModal.forEach(button =>{
  button.addEventListener('click', (event) => {
    let modalId = event.currentTarget.getAttribute("data-modal");
    let modal = document.getElementById(modalId);
    modal.close();
  });
});