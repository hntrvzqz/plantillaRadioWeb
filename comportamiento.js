// comportamiento del toggle


/* 

const boton = document.getElementById('botonJoropo');

function botoncito() {
    console.log("el boton pal toggle")
    }
    
boton.addEventListener('click', botoncito)
*/



const boton = document.getElementById('botonJoropo');
const contenedorToggle = document.getElementById('toggle1');


function alternarContenedor () {
    if (contenedorToggle.style.display === 'none') {
        contenedorToggle.style.display = 'block';       
    } else {
        contenedorToggle.style.display = 'none'
    }
}

boton.addEventListener('click', alternarContenedor);


boton.addEventListener('click', alternarContenedor)
contenedorToggle.addEventListener('click', alternarContenedor)

/** OBSERVACIONES: la implementacion de esta funcion fue todo un exito, gracias a DIOS, ahora, quiero agregar que ocurra con una transicion controlada, tambien quitar de las propiedades del toggle, en cuanto a la animacion, quiero que la pantalla del usuario este en todo el medio el toggle, y que se mueva de manera suave....
 * 
 * hay q tomar los iconos que funcionaran como botones y sacarlos de los estilos generales de la pagina, para adecuar, tamaño a gusto, tambien vamos a colocar los botones dentro del toggle, porque por fuera se ven muy desagradables.
 */