//templating.js
String.prototype.format = function(args) {
//var args = arguments;
  return this.replace(/{(\d+)}/g, function(match, number) { 
    return typeof args[number] != 'undefined'
      ? args[number]
      : match
    ;
  });
};

$.fn.render = function(params) {
  var html = this.html();
  return html.format(params);
};