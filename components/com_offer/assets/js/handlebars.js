Handlebars.registerHelper('each', function(context, options) {
    var ret = "";
    //console.log(context); console.log(options);

    for(var i=0, j=context.length; i<j; i++) {
        ret = ret + options.fn(context[i]);
    }

    return ret;
});

Handlebars.registerHelper('ifstring', function(conditional, options) {
    if(conditional != "") {
        return options.fn(this);
    }
});

Handlebars.registerHelper('ifnot', function(conditional, options) {
    if(parseInt(conditional) == 0) {
        return options.fn(this);
    }
});

Handlebars.registerHelper("ifvalue", function(conditional, options) {
    if (conditional == options.hash.equals) {
        return options.fn(this);
    } else {
        return options.inverse(this);
    }
});

Handlebars.registerHelper('ifCond', function(conditional, options) {
  if(conditional != 0) {
    return options.fn(this);
  }
  return options.inverse(this);
});

Handlebars.registerHelper('ifdate', function(conditional, options) {
    if((conditional != undefined)) {
        return options.fn(this);
    }
});
