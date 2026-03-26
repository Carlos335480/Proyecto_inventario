// Esperamos a que todo el contenido de la página HTML se haya cargado
document.addEventListener('DOMContentLoaded', () => {

    // 1. Configuramos el "observador"
    const opcionesObservador = {
        root: null, // Usa la ventana completa del navegador
        rootMargin: '0px', // Sin margen adicional
        threshold: 0.15 // La animación se activa cuando se ve el 15% del elemento
    };

    // 2. Función que se ejecuta cuando un elemento entra en la pantalla
    const animarElementos = (entradas, observador) => {
        entradas.forEach((entrada) => {
            // Si el elemento ya es visible en la pantalla del usuario
            if (entrada.isIntersecting) {
                // Le agregamos la clase 'visible' (que en CSS hace que aparezca suavemente)
                entrada.target.classList.add('visible');
                
                // Dejamos de observarlo para que la animación solo ocurra la primera vez
                observador.unobserve(entrada.target);
            }
        });
    };

    // 3. Creamos el observador nativo de JS con las opciones anteriores
    const observadorScroll = new IntersectionObserver(animarElementos, opcionesObservador);

    // 4. Buscamos todos los elementos en el HTML que tengan estas clases
    const elementosAAnimar = document.querySelectorAll('.animar-fade-up, .animar-fade-in');

    // 5. Le decimos al observador que vigile cada uno de esos elementos
    elementosAAnimar.forEach((elemento) => {
        observadorScroll.observe(elemento);
    });

    // 6. Efecto extra: La página entera aparece suavemente al cargar
    document.body.style.opacity = "0";
    document.body.style.transition = "opacity 0.8s ease-in";
    setTimeout(() => {
        document.body.style.opacity = "1";
    }, 100);
});