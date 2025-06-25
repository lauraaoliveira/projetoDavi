let quantiade = 1;

function alterarQuantidade(valor){
  quantiade+= valor;

  if(quantiade< 1){
    quantiade = 1;
  }
  document.getElementById("contador").innerText = quantiade;
  document.getElementById("quantidade").value = quantiade;

}

function resetarQuantidade() {
  quantiade = 1;
  document.getElementById("contador").innerText = quantiade;
  document.getElementById("quantidade").value = quantiade;
}