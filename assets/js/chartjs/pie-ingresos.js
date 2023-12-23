const ctx = document.getElementById('pie-hm');
  
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Hombres', 'Mujeres'],
      datasets: [{
        data: [60, 40],
        borderWidth:1,
        backgroundColor:[
            'rgb(240, 89, 65)',
            'rgb(142, 202, 230)',
        ],
      }]
    },
    options: {
      responsive: true,
      legend: {
        position: 'bottom'
      },
      plugins: {
        datalabels: {
            color: '#fff',
            anchor: 'end',
            align: 'start',
            offset: -20,
            borderWidth: 2,
            boderColor: '#fff',
            borderRadius: 25,
            backgroundColor: (context) =>{
                return context.dataset.backgroundColor;
            },
            font:{
                weight: 'bold',
                size: '15'
            },
            formatter: (value) =>{
                return value + ' %';
            }
        }
      }
    },
    plugins: [ChartDataLabels]
  });



  