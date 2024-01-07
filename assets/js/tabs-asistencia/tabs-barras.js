const asisMes = document.getElementById('ingreso-mes-año');
const asisDia= document.getElementById('ingreso-dia-mes');
const containerMes = document.getElementById('chart-barra-ingreso-dia-mes');
const containerDia = document.getElementById('chart-barra-ingreso-mes-año');

asisDia.addEventListener('click', () => {
    showTabMes();
    asisDia.classList.add('active');
    asisMes.classList.remove('active');
});

asisMes.addEventListener('click', () => {
    showTabHoy();
    asisMes.classList.add('active');
    asisDia.classList.remove('active');
});

const showTabMes = () => {
    containerMes.style.display = 'block';
    containerDia.style.display = 'none';
};

const showTabHoy = () => {
    containerDia.style.display = 'block';
    containerMes.style.display = 'none';
};
