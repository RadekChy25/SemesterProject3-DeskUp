<div class="bg-gray-200 p-8 rounded-md shadow-inner mb-11 text-center">
<h2 class="text-xl font-semibold mb-4">Time Spent Sitting vs. Standing</h2>
                <canvas id="sittingStandingChart" class="w-10 h-4"></canvas>
            </div>
            <script>
                const ctx = document.getElementById('sittingStandingChart').getContext('2d');
                const sittingStandingChart = new Chart(ctx, {
                    type: 'bar', 
                    data: {
                        labels: ['Sitting', 'Standing'], 
                        datasets: [{
                            label: 'Time (in minutes)',
                            @if(@isset($sittime)&&@isset($standtime))
                                data: [{{$sittime}}, {{$standtime}}],
                            @endif 
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',  
                                'rgba(255, 99, 132, 0.2)'   
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',   
                                'rgba(255, 99, 132, 1)'    
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            y: {
                                beginAtZero: true,  
                                title: {
                                    display: true,
                                    text: 'Time (Minutes)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        }
                    }
                });
            </script>