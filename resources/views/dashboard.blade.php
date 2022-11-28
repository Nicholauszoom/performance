@extends('layouts.master')

@section('content')
<!-- Quick stats boxes -->
<div class="row">

    @can('view-cargo-invoice')
    <div class="col-lg-3">
        <!-- Today's revenue -->
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">{{ number_format($invoice,2) }} TSHS</h3>
                </div>
                <div>Invoice Amount for the year <?php echo date('Y') ?></div>

            </div>
        </div>
    </div>
    <!-- /today's revenue -->

    <!-- Today's revenue -->
    <div class="col-lg-3">

        <div class="card bg-pink text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">{{ number_format($invoice - $due,2) }} TSHS</h3>
                </div>

                <div>Invoice Payments for the year <?php echo date('Y') ?></div>

            </div>
        </div>
    </div>
    <!-- /today's revenue -->
    @endcan

    @can('view-cargo-mileage')
    <!-- Members online -->
    <div class="col-lg-3">
        <div class="card bg-teal text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">{{ number_format($mileage,2) }} TSHS</h3>
                </div>

                <div>Total Mileage</div>

            </div>
        </div> <!-- /members online -->

    </div>
    @endcan

    @can('view-cargo-permit')
    <div class="col-lg-3">
        <!-- Current server load -->
        <div class="card bg-dark text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">{{ number_format($permit,2) }} TSHS</h3>
                </div>
                <div>Total Border Permit</div>
            </div>
        </div>
        <!-- /current server load -->
    </div>
    @endcan

    @can('view-deposit')
    <div class="col-lg-3">
        <!-- Today's revenue -->
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">{{ number_format($deposit,2) }} TSHS</h3>
                </div>
                <div>Total Deposit</div>

            </div>
        </div>
    </div>
    <!-- /today's revenue -->
    @endcan

    @can('view-expenses')
    <!-- Today's revenue -->
    <div class="col-lg-3">

        <div class="card bg-pink text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">{{ number_format($expense,2) }} TSHS</h3>
                </div>

                <div>Total Expenses</div>

            </div>
        </div>
    </div>
    <!-- /today's revenue -->
    @endcan

    @can('view-cargo-client-list')
    <!-- Members online -->
    <div class="col-lg-3">
        <div class="card bg-teal text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">{{ number_format($client) }}</h3>
                </div>

                <div>No of Clients</div>

            </div>
        </div>
        <!-- /members online -->
    </div>
    @endcan

    @can('view-truck')
    <div class="col-lg-3">
        <!-- Current server load -->
        <div class="card bg-dark text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">{{ number_format($truck) }}</h3>
                </div>
                <div>No of Trucks</div>
            </div>
        </div>
        <!-- /current server load -->
    </div>
    @endcan

    @can('manage-orders')
    <div class="col-lg-3">
        <!-- Today's revenue -->
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">{{ number_format($trips) }} </h3>
                </div>
                <div>No of Trips</div>

            </div>
        </div>
    </div>
    <!-- /today's revenue -->
    @endcan

    @can('view-fuel')
    <!-- Today's revenue -->
    <div class="col-lg-3">

        <div class="card bg-pink text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">{{ number_format($fuel,2) }} Litres</h3>
                </div>
                <div>Fuel Used</div>

            </div>
        </div>
    </div>
    <!-- /today's revenue -->
    @endcan

    @can('view-tyre_list')
    <!-- Members online -->
    <div class="col-lg-3">
        <div class="card bg-teal text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">{{ number_format($tire) }} </h3>
                </div>

                <div>No of Tires</div>

            </div>
        </div>
        <!-- /members online -->

    </div>
    @endcan

</div>

<!-- /quick stats boxes -->





<br>
<!-- Main charts -->
<div class="row">
    @can('manage-orders')
    <div class="col-xl-10 col-md-12">
        <!-- Traffic sources -->
        <div class="card">
            <div class="card-body">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="tracking"></div>
                </div>
            </div>
        </div>
        <!-- /traffic sources -->
    </div>
    @endcan


    @can('view-payroll_summary')
    <div class="col-xl-12">
        <!-- Traffic sources -->
        <div class="card">
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="payroll"></canvas>
                </div>
            </div>
        </div>
        <!-- /traffic sources -->
    </div>
    @endcan

</div>
<!-- /main charts -->

</div>
@endsection


@section('scripts')
<script type="text/javascript">
var bars_basic_element = document.getElementById('tracking');
if (bars_basic_element) {
    var bars_basic = echarts.init(bars_basic_element);
    bars_basic.setOption({

        // Setup grid
        grid: {
            left: 0,
            right: 0,
            top: 35,
            bottom: 0,
            containLabel: true
        },

        // Add legend
        legend: {
            data: ['Order In Queue', 'Collected', 'Loaded', 'OffLoaded', 'Delivered'],
            itemHeight: 8,
            itemGap: 20,
            textStyle: {
                padding: [0, 5]
            }
        },
        title: {
            text: 'Cargo Tracking',
            left: 'center',
            textStyle: {
                fontSize: 17,
                fontWeight: 500
            },
            subtextStyle: {
                fontSize: 12
            }
        },

        // Add tooltip
        tooltip: {
            trigger: 'axis',
            backgroundColor: 'rgba(0,0,0,0.75)',
            padding: [10, 15],
            textStyle: {
                fontSize: 13,
                fontFamily: 'Roboto, sans-serif'
            },
            axisPointer: {
                type: 'shadow',
                shadowStyle: {
                    color: 'rgba(0,0,0,0.025)'
                }
            }
        },

        // Vertical axis
        yAxis: [{
            type: 'value',
            boundaryGap: [0, 0.01],
            axisLabel: {
                color: '#333'
            },
            axisLine: {
                lineStyle: {
                    color: '#999'
                }
            },
            splitLine: {
                show: true,
                lineStyle: {
                    color: '#eee',
                    type: 'dashed'
                }
            }
        }],

        // Horizontal axis
        xAxis: [{
            type: 'category',
            data: ['Order In Queue', 'Collected', 'Loaded', 'OffLoaded', 'Delivered'],
            axisLabel: {
                color: '#333'
            },
            axisLine: {
                lineStyle: {
                    color: '#999'
                }
            },
            splitLine: {
                show: true,
                lineStyle: {
                    color: ['#eee']
                }
            },
            splitArea: {
                show: true,
                areaStyle: {
                    color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.015)']
                }
            }
        }],


        series: [{
            name: 'Cargo Tracking',
            type: 'bar',
            itemStyle: {
                normal: {
                    color: '#5470c6'
                }
            },
            data: [{
                    value: {
                        {
                            $collection
                        }
                    },
                    name: 'Order In Queue'
                },
                {
                    value: {
                        {
                            $loading
                        }
                    },
                    name: 'Collected'
                },
                {
                    value: {
                        {
                            $off
                        }
                    },
                    name: 'Loaded'
                },
                {
                    value: {
                        {
                            $del
                        }
                    },
                    name: 'OffLoaded'
                },
                {
                    value: {
                        {
                            $dest
                        }
                    },
                    name: 'Delivered'
                },
            ]
        }]


    });



}
</script>







<script>
// === include 'setup' then 'config' above ===
const labels = <?php echo isset($month)? json_encode($month):'' ?>;
const data = {
    labels: labels,
    datasets: [{
        label: 'Total Amount',
        data: <?php echo  isset($amount)? json_encode($amount):'' ?>,
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 205, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
        ],
        borderWidth: 1
    }]
};

const config = {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                display: false,
            },

            tooltips: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.yLabel;
                    }
                }
            },
            title: {
                display: true,
                text: 'Payroll Payments for the year <?php echo date('Y') ?>',
                font: {
                    size: 20
                }
            }
        }
    },
};
</script>

<script>
const myChart = new Chart(
    document.getElementById('payroll'),
    config
);
</script>

>
@endsection