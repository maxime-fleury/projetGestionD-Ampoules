function toggleEl(y){
    var x = document.getElementById(y);
    if (typeof(x) != 'undefined' && x != null)
    {
        x.style.display = x.style.display === 'none' ? '' : 'none';
    }
  
}

setTimeout(
    function(){toggleEl("success"); toggleEl("err");toggleEl("err2");},4000
);