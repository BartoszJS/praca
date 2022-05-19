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



 document.getElementById('button').addEventListener('click',
 function(){
    document.querySelector('.bg-modal').style.display = 'flex';
 });

 document.querySelector('.close').addEventListener('click',
 function(){
    document.querySelector('.bg-modal').style.display = "none";
 });