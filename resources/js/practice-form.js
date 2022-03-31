const { isSet } = require("lodash");

var PracticeForms = {
    config: {
        formId: null,
        resultUrl: null,
        repliesContainerId: null,
        repliesBadgeContainerId: null,
    },

    chartIds: {}, // dicionário questão -> id do elemento que contém o gráfico
    charts: {},   // dicionário id elemento -> objeto gráfico

    subscribeToEchoChannels: function() {
        var self = this;

        Echo.channel(`forms.${this.config.formId}`).listen('FormReplied', (e) => {
            self.loadResult();
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

    renderNoRepliesYet: function() {
        return `<div class="text-gray-400 text-center pt-4 pb-4 text-xl">
                   Nenhuma resposta ainda
               </div>`
    },

    getChartIdFromQuestionId: function(questionId) {
        if (!this.chartIds[questionId]) {
            this.chartIds[questionId] = 'chart-' + Math.random().toString(36).substring(7);
        }

        return this.chartIds[questionId];
    },  

    renderQuestionResultTypedInput: function(question, result) {
        var rows = [];
        var rowsAsHtml;
        
        var chartExists = $('#' + this.config.repliesContainerId + ' .no-replies-yet');
     
        rows.push('<div class="mb-4 w-full">');
        rows.push('<div class="font-bold text-center mb-4 mt-10">' + question + (result.questions[question] == undefined ? ' <p class="badge badge-pill badge-error p-2 pt-1 pb-1 border border-warning">Desativada</p>' : '') + '</div>');

        //percorre todas as respostas
        for(reply in result.replies[question]){
            rows.push('<div class="border h-10 p-2 chart-text-entry">' + result.replies[question][reply] + '</div>');
        }
        rows.push('</div>');

        rowsAsHtml = rows.join('');

        if (chartExists) {
            $(`#${this.config.repliesContainerId} .no-replies-yet`).append(rowsAsHtml);
            return;
        }
    },

    renderQuestionResultTypedSelect: function(question, result) {
        answerLabels = Object.keys(result.replies[question]);
        answerValues = Object.values(result.replies[question]);

        var answerValuesSum = answerValues.reduce(function(a, b) { return a + b; }, 0);

        var options = {
            series: [{
                name: 'Respostas',
                data: answerValues
            }],
            chart: {
                height: 450,
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
                    return val;
                },
                offsetY: -15,
                style: {
                    fontSize: '1.5em',
                    colors: ["#304758"],
                }
            },
            padding: {
                top: '20px',
                right: 0,
                bottom: 0,
                left: 0
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
                labels: {
                    offsetY: -10,
                    style: {
                        fontSize: '1.1em',
                        cssClass: 'text-gray-500 text-md',
                    }                    
                },
                tooltip: {
                    enabled: false,
                }
            },
            yaxis: {
                max: Math.max(...answerValues) * 1.1,
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    offsetY: 10,
                    formatter: function (val) {
                        var percent = (val/answerValuesSum * 100).toFixed(2);
                        return `${val} (${percent}%)`;
                    },
                }
            },
            title: {
                text: '',
                floating: true,
                margin: 70,
                align: 'center',
                style: {
                    fontSize:  '1.2em',
                    fontWeight:  '600',
                    fontFamily:  'Roboto',
                    color: '#444'
                }
            }
        };
        this.createChart(question, options, result);
    },

    createChart: function(questionId, options, result) {
        var id = this.getChartIdFromQuestionId(questionId);

        var selector = '#' + this.config.repliesContainerId;
        var chartExists = document.getElementById(id);

        if (chartExists) {
            this.charts[id].updateOptions(options);
            return;
        }

        var str = '<div class="font-bold text-center mt-10">' + questionId + (result.questions[questionId] == undefined ? ' <p class="badge badge-pill badge-error p-2 pt-1 pb-1 border border-warning">Desativada</p>' : '') + '</div>';

        $(selector).append(str + '<div id="' + id + '" class="mb-4"></div>');

        var chart = new ApexCharts(document.querySelector('#' + id), options);
        chart.render();

        this.charts[id] = chart;
    },

    renderRepliesFromResult: function(result) {

        //percorre todas as perguntas
        for(question in result.replies) {

            $type = result.replies[question]['type'];
            delete result.replies[question]['type'];

            switch ($type) {
                case 'select':
                    this.renderQuestionResultTypedSelect(question, result);
                    break;
                default:
                    this.renderQuestionResultTypedInput(question, result);
            }
        }

        //percorre todas as perguntas sem respostas
        for(question in result.questions) {
            if(result.replies[question] == undefined){
                this.renderQuestionNotReplied(question);
            }
        }
    },

     
    renderQuestionNotReplied: function(question) {
        var rows = [];
        var rowsAsHtml;
        
        var chartExists = $('#' + this.config.repliesContainerId + ' .no-replies-yet');
     
        rows.push('<div class="mb-4 w-full">');
        rows.push('<p class="font-bold text-center mb-4">' + question + '</p>');
        rows.push(this.renderNoRepliesYet());
        rows.push('</div>');

        rowsAsHtml = rows.join('');

        if (chartExists) {
            $(`#${this.config.repliesContainerId} .no-replies-yet`).append(rowsAsHtml);
            return;
        }


    },
 
    updateRepliesCountBadge: function(result) {
        var count = result.stats.repliesCount;
        var selector = '#' + this.config.repliesBadgeContainerId;
        $(selector).html(`
            <div class="badge badge-sm badge-primary badge-outline ml-2">
                ${count}
            </div>`).fadeOut().fadeIn();
    },

    onResultLoaded: function(result) {
        var noRepliesYetElement = $('#' + this.config.repliesContainerId + ' .no-replies-yet');

        if (result.stats.repliesCount == 0) {
            noRepliesYetElement.html(this.renderNoRepliesYet());
            return;
        }

        noRepliesYetElement.empty();

        this.renderRepliesFromResult(result);
        this.updateRepliesCountBadge(result);
    }

};

window.PracticeForms = PracticeForms;