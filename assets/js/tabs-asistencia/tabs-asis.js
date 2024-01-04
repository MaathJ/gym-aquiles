const asisMes = document.getElementById('regis-asis-mes');
const asisHoy = document.getElementById('regis-asis-hoy');
const containerMes = document.getElementById('collapseExample2');
const containerHoy = document.getElementById('collapseExample');
const contenidoPrincipal = document.getElementById('content-principal');

asisMes.addEventListener('click', () => {
  showTabMes();
  asisMes.classList.add('active');
  asisHoy.classList.remove('active');
  containerMes.style.display = 'block';
  containerHoy.style.display = 'none';
});

asisHoy.addEventListener('click', () => {
  showTabHoy();
  asisHoy.classList.add('active');
  asisMes.classList.remove('active');
  containerHoy.style.display = 'block';
  containerMes.style.display = 'none';
});

const showTabMes = () => {
  containerMes.style.display = 'block';
  containerHoy.style.display = 'none';
};

const showTabHoy = () => {
  containerHoy.style.display = 'block';
  containerMes.style.display = 'none';
};
