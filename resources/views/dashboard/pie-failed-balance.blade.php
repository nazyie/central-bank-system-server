<div class="w-100 p-2">
    <div class="w-100 border rounded">
        <div class="text-center pt-2">
            <h5>Failed Transaction</h5>
        </div>
        <div>
            <canvas id="pie-current-balance"></canvas>
        </div>
    </div>
</div>

<script>
    const ccb = document.getElementById('pie-current-balance');

    new Chart(ccb, {
        type: 'doughnut',
        data: {
            labels: [
                'Rejected Transaction',
                'Pending Transaction',
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [30000, 10000],
                backgroundColor: [
                    'RGB(220, 53, 69)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 50
            }]
        }
    });
</script>
