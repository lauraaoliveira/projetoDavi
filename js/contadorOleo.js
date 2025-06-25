let quantiade = 0;

function alterarQuantidade(valor){
  quantiade+= valor;

  if(quantiade< 0){
    quantiade = 0;
  }
  document.getElementById("contador").innerText = quantiade;
  document.getElementById("quantidade").value = quantiade;

}