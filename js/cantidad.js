const Cantidad = document.getElementById('cantidad'); 

for(let i = 0; i < 30; i++){
    Cantidad.innerHTML += `
    <option  value="${i}" >${i}</option>
   
    `; 
    i++;   
}
