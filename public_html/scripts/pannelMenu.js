//submit.js
(function() { 
  $(document).ready(function() {
    $('#simple-menu').sidr({
      source:"#menuContent",
      onClose:onSlidrClose,
      onOpen:onSlidrOpen
    });
  });
  var slidrOpen = false;
  function onSlidrOpen(){
    slidrOpen = true;
    console.log("open open");
    console.log($("sidr-open"));
    $(".page").click(function(){
      console.log("clicky clicky");
      $.sidr('close', 'sidr');
    });
  }
  function onSlidrClose(){
    slidrOpen =false;
    console.log("closy");
    $(".page").unbind("click");
  }
})();

//end submit.js