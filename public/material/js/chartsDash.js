 // TEMPORAL
        function initDashboardPageCharts(nameChart,label, data, height, colorPrimary, colorHexa, numberCharts, idButtom, colorsCharts, dataArray, typeChart) {
            var ctxL = document.getElementById(nameChart).getContext('2d');
            var gradientStroke = ctxL.createLinearGradient(0, 230, 0, 170);
            gradientStroke.addColorStop(1.0, 'rgba('+colorHexa+',0.2)');
            gradientStroke.addColorStop(0.5, 'rgba('+colorHexa+',0.05)');
            gradientStroke.addColorStop(0.0, 'rgba('+colorHexa+',0.0)');  

        
            var config = {
                type: typeChart,
                data: {
                    labels: label,
                    datasets: [{
                        label: "Total de litros al mes",
                        //fillColor: gradientStroke,
                        backgroundColor: gradientStroke,
                        borderColor: colorPrimary,
                        fill: true,
                        tension: 0.5,
                        borderDashOffset: 0.0,
                        borderWidth: 2.5,
                        data:data,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio:false,
                    plugins: {
                        legend: {
                            display: false,
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                color: '#000'
                            },
                        },
                    },
                    interaction: {
                        intersect: false,
                    },
                    scales: {
                        x: {
                            grid: {
                                drawBorder: false,
                                color:  'transparent',
                            },
                            ticks: {
                                padding: 15,
                                color: "#235ea5",
                                format: Intl.NumberFormat().format(1000)
                            },
                            
                        },
                        y: {
                            min: 0,
                            grid: {
                                drawBorder: false,
                                color:  'rgba(200,200,200, 0.3)',
                            },
                            ticks: {
                                padding: 15,
                                color: "#235ea5",
                                //stepSize: 10
                            }
                        }
                    }
                },
            };

            var myChartDataL = new Chart(ctxL, config);

            myChartDataL.canvas.parentNode.style.height = height+'vh'; 
            myChartDataL.canvas.parentNode.style.width = '100%';

            if(numberCharts > 1){
                /*for (i = 0; i < numberCharts; i++){
                    console.log('#'+idButtom+i);
                }*/
                    $("#prod0").click(function() {
                        var gradientStroke = ctxL.createLinearGradient(0, 230, 0, 170);
                        gradientStroke.addColorStop(1.0, 'rgba('+colorHexa+',0.2)');
                        gradientStroke.addColorStop(0.5, 'rgba('+colorHexa+',0.05)');
                        gradientStroke.addColorStop(0.0, 'rgba('+colorHexa+',0.0)');   

                        var data = myChartDataL.config.data;
                        data.datasets[0].data = dataArray[0];
                        data.datasets[0].borderColor = colorsCharts[0];
                        //data.datasets[0].pointBackgroundColor = colorsCharts[0];
                        data.datasets[0].backgroundColor = gradientStroke;
                        //data.labels = chart_labels;
                        myChartDataL.update();
                    });

                    $("#prod1").click(function() {
                        var gradientStroke = ctxL.createLinearGradient(0, 230, 0, 170);
                        gradientStroke.addColorStop(0.5, `rgba(${hexToRgb(colorsCharts[1])},0.05)`);
                        gradientStroke.addColorStop(1.0, `rgba(${hexToRgb(colorsCharts[1])},0.2)`);
                        gradientStroke.addColorStop(0.0, `rgba(${hexToRgb(colorsCharts[1])},0.0)`); 

                        var data = myChartDataL.config.data;
                        data.datasets[0].data = dataArray[1];
                        data.datasets[0].borderColor = colorsCharts[1];
                        //data.datasets[0].pointBackgroundColor = colorsCharts[1];
                        data.datasets[0].backgroundColor = gradientStroke;
                        //data.labels = chart_labels;
                        myChartDataL.update();
                    });

                    $("#prod2").click(function() {
                        var gradientStroke = ctxL.createLinearGradient(0, 230, 0, 170);
                        gradientStroke.addColorStop(0.5, `rgba(${hexToRgb(colorsCharts[2])},0.05)`);
                        gradientStroke.addColorStop(1.0, `rgba(${hexToRgb(colorsCharts[2])},0.2)`);
                        gradientStroke.addColorStop(0.0, `rgba(${hexToRgb(colorsCharts[2])},0.0)`);  

                        var data = myChartDataL.config.data;
                        data.datasets[0].data = dataArray[2];
                        data.datasets[0].borderColor = colorsCharts[2];
                        //data.datasets[0].pointBackgroundColor = colorsCharts[2];
                        data.datasets[0].backgroundColor = gradientStroke;
                        //data.labels = chart_labels;
                        myChartDataL.update();
                    });
                }
            }

           
    

        let colorsCharts = ["#24a326", "#d90016","242121"];
        //litros vendidos por mes
         
        function chartProducts(opt, min, max,id, height, urlL) {
            const products = [];
            const Http = new XMLHttpRequest();
            //local
            //const url = urlL+'/monthsdaysproduct?days='+opt+'&min='+min+'&max='+max+'&id='+id;
            //server
            const url = urlL+'/monthsdaysproduct?days='+opt+'&min='+min+'&max='+max+'&id='+id;
            Http.open("GET", url);
            Http.send();

            Http.onreadystatechange = (e) => {
                if (Http.readyState == 4 && Http.status == 200) {
                    var status = JSON.parse(Http.responseText);
                    var el = document.getElementById('chartBigProducts');
                    el.remove(); 
                    products.push(status[0]);
                    products.push(status[1]);
                    products.push(status[2]);
                    $("#profile").append('<canvas id="chartBigProducts"></canvas>');
                    initDashboardPageCharts("chartBigProducts",status[3], status[0], height, '#24a326','36, 163, 38',3, 'prod', colorsCharts,products, 'line');
                    console.log(status);
                }
            }
        }

        function chartTransport(opt, min, max,urlL) {
           
            const Http = new XMLHttpRequest();
            const url = urlL+'/monthsdaysproduct?days='+opt+'&min='+min+'&max='+max;
            Http.open("GET", url);
            Http.send();

            Http.onreadystatechange = (e) => {
                if (Http.readyState == 4 && Http.status == 200) {
                    var status = JSON.parse(Http.responseText);
                    var el = document.getElementById('chartBigTransport');
                    el.remove(); 
                   
                    $("#profil").append('<canvas id="chartBigTransport"></canvas>');
                    initDashboardPageCharts("chartBigTransport",status[1], status[0], 50, '#235ea5','36, 163, 38',0, 'prod', colorsCharts,null,'bar');
                    //console.log(status);
                }
            }
        }

       

        function myFunction() {
            const Http = new XMLHttpRequest();
            const url = 'monthstothepresentliters';
            Http.open("GET", url);
            Http.send();

            Http.onreadystatechange = (e) => {
                if (Http.readyState == 4 && Http.status == 200) {
                    var status = JSON.parse(Http.responseText);
                    
                    initDashboardPageCharts("chartBig1L",status[1], status[0], 45, '#235ea5', '35, 94, 165', 1, '',colorsCharts,null, 'line');
                    //console.log(status);
                }
            }
        }


        // Metodo para convertir de HEX a RGB
        function hexToRgb(hex) {
            let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            if (result) {
                let color = [];
                color.push(parseInt(result[1], 16));
                color.push(parseInt(result[2], 16));
                color.push(parseInt(result[3], 16));
                return color;
            }
            return [0, 0, 0];
        }

        function sumarDias(fecha, dias){
            fecha.setDate(fecha.getDate() + dias);
            return fecha;
        }

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) 
                month = '0' + month;
            if (day.length < 2) 
                day = '0' + day;

            //return [year, month, day].join('-');
            return [ month, day,year].join('/');
        }

        var d = new Date();