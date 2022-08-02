var ProgressBar = {
    config: {
        countFields : 0,
        answeredFields : [],
        totalAnsweredFields : 0,
    
        containerId : '',
        counterId : '',
        containerWidth : 1, //percent
    },
 
    init: function (config) {
        this.config = config;
        return this;
    },

    updateWidth(direction) {
        var i = 0;
        if (i == 0) {
            i = 1;
            var elementContainer = document.getElementById(ProgressBar.config.containerId);
            var elementCounterContainer = document.getElementById(ProgressBar.config.counterId);
            var id = setInterval(frame, 25);
            
            function frame() {
                //stop condition
                if (direction == 'up' && ProgressBar.config.containerWidth >= Math.round((ProgressBar.config.totalAnsweredFields/ProgressBar.config.countFields*100)) || direction == 'down' && ProgressBar.config.containerWidth <= Math.round((ProgressBar.config.totalAnsweredFields/ProgressBar.config.countFields*100))) {
                    clearInterval(id);
                    i = 0;
                    elementContainer.style.width = ProgressBar.config.containerWidth + "%";
                    elementCounterContainer.innerHTML = ProgressBar.config.containerWidth + "%";
                } else {
                    switch(direction){
                        case 'up':
                            ProgressBar.config.containerWidth++;
                            break;
                        case 'down':
                            ProgressBar.config.containerWidth--;
                            break;
                        default:
                            break;
                    }
                    elementContainer.style.width = ProgressBar.config.containerWidth + "%";
                    elementCounterContainer.innerHTML = ProgressBar.config.containerWidth + "%";
                }
            }
        }
    },

    //onChange event in form input
    fieldChanged(key, value, type){  

        switch(type){
            case 'file':
                if(ProgressBar.config.answeredFields[key] != undefined){
                    ProgressBar.config.answeredFields[key] += value;
                }else{
                    ProgressBar.config.answeredFields[key] = 1;
                }
                break;
            case 'checkbox':
                if(ProgressBar.config.answeredFields[key]){
                    if(value == false){
                        ProgressBar.config.answeredFields[key]--;
                    }else{
                        ProgressBar.config.answeredFields[key]++;
                    }
                }else{
                    if(value == true){
                        ProgressBar.config.answeredFields[key] = 1;
                    }
                }
                break;
            case 'select':
                if(value != ''){
                    ProgressBar.config.answeredFields[key] = 1;
                }else{
                    ProgressBar.config.answeredFields[key] = 0;
                }
                break;
            default:
                if(value){
                    ProgressBar.config.answeredFields[key] = 1;
                }else{
                    ProgressBar.config.answeredFields[key] = 0;
                }
                break;
        }

        //recalculate total fields answered
        var computeTotalAnsweredFields  = 0;
        for(answeredField in ProgressBar.config.answeredFields){
            if(ProgressBar.config.answeredFields[answeredField]){
                computeTotalAnsweredFields ++;
            }
        }

        //if the total changes, call updateWidth function setting a direction
        if(computeTotalAnsweredFields > ProgressBar.config.totalAnsweredFields){
            ProgressBar.config.totalAnsweredFields = computeTotalAnsweredFields;
            this.updateWidth('up');
        }else if(computeTotalAnsweredFields < ProgressBar.config.totalAnsweredFields){
            ProgressBar.config.totalAnsweredFields = computeTotalAnsweredFields;
            this.updateWidth('down');
        }else{
            this.updateWidth('keep');
        }
    },
}

window.ProgressBar = ProgressBar;