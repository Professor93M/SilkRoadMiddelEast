import { createStore } from "vuex"

const store = createStore({
   state:{
        showAdmin: false,
        showProd: false,
        showCat: false,
        showSCat: false,
        showOrder: false,
        showCar: false,
        like: [],
        cart: [],
        price: [],
        search: null,
        icon: true,
   },
   mutations:{
       Admin(state){
           state.showAdmin = !state.showAdmin;
           state.showProd = false;
           state.showCat = false;
           state.showSCat = false;
           state.showOrder = false;
           state.showCar = false;
       },
       Prod(state){
           state.showProd = !state.showProd;
           state.showCat = false;
           state.showSCat = false;
           state.showOrder = false;
           state.showCar = false;
           state.showAdmin = false;
       },
       Cat(state){
           state.showCat = !state.showCat;
           state.showSCat = false;
           state.showProd = false;
           state.showOrder = false;
           state.showCar = false;
           state.showAdmin = false;
       },
       SCat(state){
           state.showSCat = !state.showSCat;
           state.showCat = false
           state.showProd = false;
           state.showOrder = false;
           state.showCar = false;
           state.showAdmin = false;
       },
       Order(state){
           state.showOrder = !state.showOrder;
           state.showCat = false;
           state.showSCat = false;
           state.showCar = false;
           state.showProd = false;
           state.showAdmin = false;
       },
       Car(state){
           state.showCar = !state.showCar
           state.showCat = false;
           state.showSCat = false;
           state.showProd = false;
           state.showOrder = false;
           state.showAdmin = false;
       },
   }
})

export default store
