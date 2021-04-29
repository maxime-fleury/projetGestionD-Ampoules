function toggleEl(y){
    var x = document.getElementById(y);
    if (typeof(x) != 'undefined' && x != null)//if exists
    {   //show
        x.className = "show";
        console.log(y + " showed");
        //hide in 3 sec
        h = setTimeout(function(){
            x.style.display = x.style.display === 'none' ? '' : 'none';
            x.className.replace("show", "");
        },3000);
        
    }
}
setTimeout(function(){toggleEl("success");toggleEl("err");toggleEl("err2");},500);
