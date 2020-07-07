 var name ='cart_currency';
var cookieArr = document.cookie.split(";");
    
    // Loop through the array elements
    for(var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        
        /* Removing whitespace at the beginning of the cookie name
        and compare it with the given string */
        if(name == cookiePair[0].trim()) {
            // Decode the cookie value and return
            document.getElementById("nselect").value =cookiePair[1];
             // alert(decodeURIComponent(cookiePair[1]));
        }
    }
function myFunction() {
  var value = document.getElementById("nselect").value;
  // document.getElementById("demo").innerHTML = "You selected: " + x;
  
  // set cookie
 var name ='cart_currency';
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = name + "=" + value + ";" + expires + ";path=/";
  // end set cookie
}
