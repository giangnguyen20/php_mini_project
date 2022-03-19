function myInput(id){
    var retVal = confirm("Do you want to continue ?");
    if (retVal == true) {
         $.post('home.php', {
             'action': 'delete',
             'id': id
         }, function() {
             location.reload();
         });
     }
 }