
// core version + navigation, pagination modules:
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

document.addEventListener("DOMContentLoaded", function(){
    if(document.querySelector(".slider")){
        const opciones={
            slidesPerView:1,
            spaceBetween: 15,
            freeMode: true,
            navigation:{
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            breakpoints:{ //como media queris
                760:{ //pones la resolucion en px
                    slidesPerView:2,
                },
                1024:{ //pones la resolucion en px
                    slidesPerView:3,
                },
                1200:{ //pones la resolucion en px
                    slidesPerView:4,
                }
            }
        }
        Swiper.use([Navigation])
        new Swiper(".slider" , opciones)
    }
});