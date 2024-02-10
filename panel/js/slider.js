const slideButton = document.querySelector('.slide_button');
const header = document.querySelector('.menu');
const i = document.querySelectorAll('.menu ul a i');
const h2 = document.querySelectorAll('.menu ul h2');
const principal = document.querySelector('.principal');
slideButton.addEventListener('click', () => 
{
    // Cambiar las líneas para formar una X
    slideButton.classList.toggle('activado');
    validador();
});

function validador() {
    if (slideButton.classList.contains('activado')) 
    { 
        header.style.width = 'calc(20px + 6vh + 20px)';
        for (let count = 0; count < i.length; count++) 
        {
            i[count].style.marginRight = '7vh'; // Modifica cada elemento 'i' individualmente
        }
        for(let count = 0; count < h2.length; count++)
        {
            h2[count].style.margin = ' 20px 0 20px 9vh';
        }
        principal.style.paddingLeft = "calc(6vh + 40px)";
    } 
    else 
    {
        header.style.width = '270px';
        for (let count = 0; count < i.length; count++) 
        {
            i[count].style.marginRight = '5px'; // Modifica cada elemento 'i' individualmente
        }
        for(let count = 0; count < h2.length; count++)
        {
            h2[count].style.margin = ' 20px 0px 20px 0px';
        }
        if (window.innerWidth < 500) 
        {
            principal.style.paddingLeft = "calc(6vh + 40px)";
        }
        else
        {
            principal.style.paddingLeft = "270px";
        }
    }
}