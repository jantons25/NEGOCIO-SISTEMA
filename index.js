const menu = document.querySelector('.nav__cta');
const menuList = document.querySelector('.aside__bar');
const links = document.querySelectorAll('.aside__cta')

menu.addEventListener('click',function(){
    menuList.classList.toggle('aside__bar--show')
})

links.forEach(function(link){
    link.addEventListener('click',function(){
        menuList.classList.remove('aside__bar--show');
    })
})
