@extends('layouts.base')
@section('content')

<section>
    <div class="container">
        <header class="section-header">
        </header>

        <div class="row mb-8">
            <div class="row mb-3">
                <div class="col-12 text-right">
                    <p class="font-semibold text-md">Acesso para responder</p>
                </div>
            </div>
            <div class="row">
                <div class="col-4">

                </div>
                <div class="col-8 content-end text-right">
                    <img src="{{ asset('img/qrcode.svg') }}" class="w-24 float-right ml-4" title="">
                    <p class="text-md text-gray-500 mt-3">Para que outras pessoas possam responder, compartilhe o código QR ao lado ou o link baixo:</p>
                    <a href="{{ $reply_link }}" class="text-xl font-semibold text-blue-400" target="_blank">{{ $reply_link }}</a>
                </div>
            </div>
        </div>
        @livewire('form.edit', ['form' => $form])
    </div>
</section>
@endsection

@section('scripts')

<script>
    $(document).ready(function () {
        axios.get('{{ $result_json_url }}')
            .then(function (response) {
                var result = response.data;
                for(var text in result.replies) {
                    var entry = result.replies[text];
                    var answerLabels = Object.keys(entry);
                    var answerValues = Object.values(entry);

                    var options = {
                        series: [{
                            name: 'Inflation',
                            data: answerValues
                        }],
                        chart: {
                            height: 350,
                            type: 'bar',
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 10,
                                dataLabels: {
                                    position: 'top', // top, center, bottom
                                },
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function (val) {
                                return val + "%";
                            },
                            offsetY: -20,
                            style: {
                                fontSize: '12px',
                                colors: ["#304758"]
                            }
                        },
            
                        xaxis: {
                            categories: answerLabels,
                            position: 'top',
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            crosshairs: {
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        colorFrom: '#D8E3F0',
                                        colorTo: '#BED1E6',
                                        stops: [0, 100],
                                        opacityFrom: 0.4,
                                        opacityTo: 0.5,
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true,
                            }
                        },
                        yaxis: {
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false,
                            },
                            labels: {
                                show: false,
                                formatter: function (val) {
                                    return val + "%";
                                }
                            }
            
                        },
                        title: {
                            text: text,
                            floating: true,
                            offsetY: 330,
                            align: 'center',
                            style: {
                                color: '#444'
                            }
                        }
                    };
            
                    var id = 'chart-' + Math.random().toString(36).substring(7);
                    $('#replies').append('<div id="' + id + '" class="mb-4"></div>');
                    var chart = new ApexCharts(document.querySelector('#' + id), options);
                    chart.render();
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    });

    Echo.channel('forms.{{ $form->id }}').listen('FormReplied', (e) => {
        console.log(e.form);
    });
</script>

@endsection