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

    renderQuestionResult: function(questionId, question, replies) {
        const type = question.type;

        if (type == 'input') {
            this.renderQuestionResultTypedInput(questionId, question, replies);

        } else if (type == 'select') {
            this.renderQuestionResultTypedSelect(questionId, question, replies);
        }
    },

    renderNoRepliesYet: function() {
        return `<div class="text-gray-400 text-center pt-32 text-xl">
                   Nenhuma resposta ainda
               </div>`
    },

    getChartIdFromQuestionId: function(questionId) {
        if (!this.chartIds[questionId]) {
            this.chartIds[questionId] = 'chart-' + Math.random().toString(36).substring(7);
        }

        return this.chartIds[questionId];
    },  

    renderQuestionResultTypedInput: function(questionId, question, replies) {
        var id = this.getChartIdFromQuestionId(questionId);
        var selector = '#' + this.config.repliesContainerId;
        var rows = [];

        replies = replies || [];

        replies.map(function(reply) {
            rows.push('<div class="border h-10 p-2 chart-text-entry">' + reply + '</div>');
        })

        var rowsAsHtml = rows.join('');
        var chartExists = document.getElementById(id);

        if (chartExists) {
            $(`#${id} .chart-text-entries`).html(rowsAsHtml);
            $(`#${id} .chart-text-entry:last-child`).fadeOut().fadeIn();
            return;
        }

        $(selector).append(
            `<div id="${id}" class="mb-4 w-full">
                <p class="font-bold text-center mb-4">${question.text}</p>
                <div class="mb-4 w-full h-80 overflow-y-scroll chart-text-entries">` +
                    (rows.length == 0 ? this.renderNoRepliesYet() : rowsAsHtml) +
                `</div>
            </div>`
        );
    },

    renderQuestionResultTypedSelect: function(questionId, question, replies) {
        var answerLabels = Object.keys(replies);
        var answerValues = Object.values(replies);
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
                text: question.text,
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
        
        this.createChart(questionId, options);
    },

    createChart: function(questionId, options) {
        var id = this.getChartIdFromQuestionId(questionId);
        var selector = '#' + this.config.repliesContainerId;
        var chartExists = document.getElementById(id);

        if (chartExists) {
            this.charts[id].updateOptions(options);
            return;
        }

        $(selector).append('<div id="' + id + '" class="mb-4"></div>');
        
        var chart = new ApexCharts(document.querySelector('#' + id), options);
        chart.render();

        this.charts[id] = chart;
    },

    renderRepliesFromResult: function(result) {
        for(var id in result.questions) {
            this.renderQuestionResult(id, result.questions[id], result.replies[id]);
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
    },

};

window.PracticeForms = PracticeForms;