let dishes = window.myArray;
let Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1000,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.addEventListener('load', (e) =>{
    addEventListenerToSubmitButtons();
});

function addEventListenerToSubmitButtons(){
    dishes.forEach(dish => {
        document.getElementById('submit' + dish.id).addEventListener('click', (e) => {
            e.preventDefault();
            addCourseToOrderList(dish);
        });
    })
}

function addCourseToOrderList(dish){
    let dishid = dish.id;
    let orderList = JSON.parse(localStorage.getItem('orderList'));
    if(orderList){
        if(orderList['('+dishid+')']){
            let dish = orderList['('+dishid+')'];
            dish.amount += 1;
            orderList['('+dishid +')'] = dish;
        }else{
            orderList['('+dishid +')'] = {dishId: dishid, amount: 1};
        }
        localStorage.setItem('orderList', JSON.stringify(orderList));
    }else{
        orderList = {};
        orderList['('+dishid + ')'] = {dishId: dishid, amount: 1};
        localStorage.setItem('orderList', JSON.stringify(orderList))
    }
    Toast.fire({
        icon: 'success',
        title: dish.name +' toegevoegd'
    })
}
