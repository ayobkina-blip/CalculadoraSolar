const images = [
    "/images/fondo1.png",
    "/images/fondo2.png",
    "/images/fondo3.png",
    "/images/fondo4.png"
];

let currentIndex = 0;
const contenedorPadre = document.getElementById('contenedor-base');
const capaSuperior = document.getElementById('capa-fondo');

capaSuperior.style.backgroundImage = `url('${images[0]}')`;

function changeImage() {
    let nextIndex = (currentIndex + 1) % images.length;

    contenedorPadre.style.backgroundImage = `url('${images[nextIndex]}')`;

    capaSuperior.classList.add('fade-out');

    setTimeout(() => {
        capaSuperior.style.backgroundImage = `url('${images[nextIndex]}')`;
        
        capaSuperior.classList.remove('fade-out');
        
        currentIndex = nextIndex;
    }, 1200);
}

setInterval(changeImage, 3000);