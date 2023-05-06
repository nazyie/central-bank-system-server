<div class="w-100 p-2">
    <div class="w-100 border rounded">
        <div class="text-center pt-2">
            <h5>Account Transaction</h5>
        </div>
        <div>
            <canvas id="pie-today-transaction"></canvas>
        </div>
    </div>
</div>

<script>
    const ctt = document.getElementById('pie-today-transaction');

    new Chart(ctt, {
        type: 'doughnut',
        data: {
            labels: [
                'Successful Transaction',
                'Pending Transaction',
                'Rejected Transaction',
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [30000, 10000, 2000],
                backgroundColor: [
                    'RGB(40, 167, 69)',
                    'RGB(255, 193, 7)',
                    'RGB(220, 53, 69)',
                ],
                hoverOffset: 50
            }]
        },
    });
</script>
