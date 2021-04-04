var TellerController = {};

    TellerController.template = function(element){
        return `
            <div class="product--element">
                <div class="w-px-210 display-inline-block">${element.title}</div>
                <div class="w-px-210 display-inline-block">${element.price}</div>
                <div class="w-px-210 display-inline-block">${element.quantity}</div>
                    <div class="w-px-210 display-inline-block">
                    <a href="">Добави в количка</a>
               </div>
            </div>`;
            };
            
    TellerController.getData = function(templatePlaceholder){
          //send request
            Ajax.json('http://127.0.0.1/MyWebShopCMSApi/index.php/teller', function(responseObject){
                //var templatePlaceholder = document.getElementById("template-placeholder");
                 
                
                 var templateBilder = [];
                // var responseObject = JSON.parse(responseData);
                    
                    for(var i = 0; i<responseObject.length; i++){
                        var responseTemplate = TellerController.template(responseObject[i]);
                        //templatePlaceholder.innerHTML += responseTemplate;  zaema mnogo pamet - zatova s push
                          templateBilder.push(responseTemplate);
                    }
                    
                    templatePlaceholder.innerHTML = templateBilder.join('');
            });
      
    };
    
    TellerController.run = function(domElement){
        TellerController.getData(domElement);
    };
            
          