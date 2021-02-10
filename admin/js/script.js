$(document).ready(function(){
    //alert('hello');
   $('#selectAllBoxes').click(function(event){
       if (this.checked) {
           $('.checkBoxes').each(function(){
                 this.checked = true;
           });
       } else {
            $('.checkBoxes').each(function(){
                 this.checked = false;
         });
       }                           
   }); 
});

//document.querySelector('#selectAllBoxes').addEventListener('change', function(e){
//    const postCheckboxes = document.querySelectorAll('.checkBoxes');
//    if (this.checked){
//        postCheckboxes.forEach(function(checkbox){
//            checkbox.checked = true;
//        })
//    } else {
//        postCheckboxes.forEach(function(checkbox){
//            checkbox.checked = false;
//        })        
//    }    
//})


//----------------------------------------------user online counter

function loadUsersOnline() {
    $.get("functions.php?onlineusers=result", function(data){
       $(".usersonline").text(data); 
        console.log(data);
    })
}

setInterval(function(){
    loadUsersOnline();
}, 500);
