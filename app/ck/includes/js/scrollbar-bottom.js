$( function() {
    $( ".draggable" ).draggable();
} );
   
$(document).ready(function(){
   var wrapper1 = document.getElementById('wrapper1');
   var myhtml = document.getElementById('myhtml');
   wrapper1.onscroll = function() {
      myhtml.scrollLeft = wrapper1.scrollLeft;
    };

    myhtml.onscroll = function() { alert(2);
        wrapper1.scrollLeft = myhtml.scrollLeft;
    };
});