<div class="w-100 p-2">
    <div class="w-100 border rounded">
        <div class="text-center pt-2">
            <h5>Account Balance</h5>
        </div>
        <div>
            <canvas id="pie-overall-balance"></canvas>
        </div>
    </div>
</div>

<script>
    const cob = document.getElementById('pie-overall-balance');

    new Chart(cob, {
        type: 'doughnut',
        data: {
            labels: [
                'Available Balance',
                'Floating Balance',
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [30000, 10000],
                backgroundColor: [
                    'RGB(0, 123, 255)',
                    'RGB(108, 117, 125)',
                ],
                hoverOffset: 50
            }]
        }
    });
</script>
