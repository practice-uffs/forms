var PracticeForms = {
    config: {
        formId: null,
        resultUrl: null,
        containerId: null,
    },

    subscribeToEchoChannels: function() {
        Echo.channel(`forms.${this.config.formId}`).listen('FormReplied', (e) => {
            console.log(e.form);
        });      
    },

    init: function(config) {
        this.config = config;

        this.subscribeToEchoChannels();
        this.loadResult();

        return this;
    },

    loadResult: function() {
        var self = this;

        axios.get(this.config.resultUrl)
            .then(function (response) {
                self.onResultLoaded(response.data);
            })
            .catch(function (error) {
                self.onError(error);
            });
    },

    onError: function(error) {
        console.error(error);
    },

    renderQuestionResult: function(id, question, replies) {
        const type = question.type;

        if (type == 'input') {
            this.renderQuestionResultTypedInput(id, question, replies);

        } else if (type == 'select') {
            this.renderQuestionResultTypedSelect(id, question, replies);
        }
    },

    renderQuestionResultTypedInput: function(id, question) {
        console.log('TODO: renderQuestionResultTypedInput', id, question);
    },

    renderQuestionResultTypedSelect: function(id, question, replies) {
        var answerLabels = Object.keys(replies);
        var answerValues = Object.values(replies);

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
                text: question.text,
                floating: true,
                offsetY: 330,
                align: 'center',
                style: {
                    color: '#444'
                }
            }
        };
        
        this.createChart(options);
    },

    createChart: function(options) {
        var id = 'chart-' + Math.random().toString(36).substring(7);
        var selector = '#' + this.config.containerId;

        $(selector).append('<div id="' + id + '" class="mb-4"></div>');
        
        var chart = new ApexCharts(document.querySelector('#' + id), options);
        chart.render();
    },

    renderRepliesFromResult: function(result) {
        for(var id in result.questions) {
            this.renderQuestionResult(id, result.questions[id], result.replies[id]);
        }
    },

    onResultLoaded: function(result) {
        console.log(result);
        this.renderRepliesFromResult(result);
    },

};

window.PracticeForms = PracticeForms;