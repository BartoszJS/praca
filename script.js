let loader=document.querySelector('.wrap');
function loading(){
    loader.style.display = "none";
};

//   window.addEventListener('load',function(){
//           loader.style.display = 'none';
//       });

 window.addEventListener('load',function(){
     setInterval(loading,400);
 });