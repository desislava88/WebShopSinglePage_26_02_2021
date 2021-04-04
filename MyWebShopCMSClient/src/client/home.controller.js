var HomeController = {};

HomeController.template = function(){
    return '<h1>Добре дошли в моя магазин</h1>';
};
HomeController.run = function(domElement){
    domElement.innerHTML = HomeController.template();
};

