let orderList;
let total;
let submitBtn;
let removeTn;
let trs = [];
let selectedDishes = {};
const formatter = new Intl.NumberFormat('nl-NL', {   style: 'currency',   currency: 'EUR' })

window.addEventListener('load', (e) => {
    orderList = document.getElementById('orderList');
    total = document.getElementById('totalPRICE');
    submitBtn = document.getElementById('submitBtn');
    removeBtn = document.getElementById('btnRemove');
    submitBtn.addEventListener('click',(e) => {
        e.preventDefault();
        if(Object.keys(selectedDishes).length !== 0) {
            submit();
        } else {
            swal.fire({
                title: 'Oops...',
                text: 'Er is nog geen gerecht toegevoegd aan de bestelling',
                icon: 'error',
            })
        }
     })
     removeBtn.addEventListener('click',(e) => {
        e.preventDefault();
        removeAll();
     });
     getSelectedDish();
});


function getSelectedDish() {
    $('.dish-button').click(function(event) {
        let dish = $(this).data('id');
        addDishToOrderList(dish)
    });
}

function addDishToOrderList(dish) {
    if(!checkIfDishExists(dish)) {
        let id = '('+dish.id+')';
        let tr = document.createElement('tr');
        let td1 = document.createElement('td')
        td1.innerHTML = dish.dishnumber ? dish.dishnumber : '' + dish.dish_addition ? dish.dish_addition : '';
        let td2 = document.createElement('td')
        td2.innerHTML = dish.name;
        let addRemarkInput = document.createElement('input');
        let td4 = document.createElement('td')
        addRemarkInput.id = 'remark'+id;
        addRemarkInput.name = 'opmerkingen[]';
        addRemarkInput.placeholder = 'Opmerkingen';
        addRemarkInput.className = 'form-control';
        td4.append(addRemarkInput);
        let td3 = document.createElement('td')
        td3.id = "price"+id;
        let td5 = document.createElement('td')
        const input = document.createElement('input');
        input.type = 'number';
        input.id = id;
        input.name = 'amounts[]';
        input.min = '0';
        input.value = 1;
        input.addEventListener('change', (e) => {
            e.preventDefault();
            if(selectedDishes[input.id].amount < parseInt(input.value)) {
                addToSelectedDishes(selectedDishes[input.id].dish, parseInt(input.value) - selectedDishes[input.id].amount);
                changeAmount(dish.id);
            } else {
                removeFromSelectedDishes(id, selectedDishes[input.id].amount-parseInt(input.value));
                changeAmount(dish.id);
                if(input.value === "0") {
                    tr.remove();
                }
            }
            updateTotalPrice();
        })
        td5.append(input);
        tr.append(td1, td2, td3, td4, td5);
        orderList.append(tr);
        trs.push(tr);
    } else {
        let amountInput = document.getElementById('('+dish.id+')');
        amountInput.value = parseInt(amountInput.value) + 1;
    }
    addToSelectedDishes(dish, 1);
}

function removeFromSelectedDishes(id, amount) {
    selectedDishes[id].amount -= amount;
    if(selectedDishes[id].amount === 0) {
        delete selectedDishes[id];
    }
    if(selectedDishes[id]) {
        updateDishTotalPrice(id);
    }
}


function checkIfDishExists(dish) {
    let checker = false;
    if(selectedDishes['('+dish.id+')']) {
        checker = true;
    }
    if(checker) {
        changeAmount(dish.id);
    }
    return checker;
}


function addToSelectedDishes(dish, amount) {
    let id = '('+dish.id+')';
    if(selectedDishes[id]) {
        selectedDishes[id].amount = amount;
    } else {
        selectedDishes[id] = {
            dish: dish,
            amount: amount,
            remark: null
        }
    }
    updateDishTotalPrice(id);
}

function updateDishTotalPrice(id) {
    let dishPrice = formatter.format(selectedDishes[id].dish.price * selectedDishes[id].amount);
    document.getElementById('price'+id).innerHTML = dishPrice;
}

function updateTotalPrice(){
    let totalPrice = 0;
    for (const [key, value] of Object.entries(selectedDishes)) {
        totalPrice += (parseFloat(value.dish.price) * value.amount);
    }
    total.innerHTML = formatter.format(totalPrice);
}

function changeAmount(id) {
    let amount = 0;
    for (const [key, value] of Object.entries(selectedDishes)) {
        if(value.dish.id === id) {
            amount += value.amount;
        }
    }
}

function removeAll(){
    for (const [key, value] of Object.entries(selectedDishes)) {
        selectedDishes[key].amount = 0;
        changeAmount(value.dish.id);
    }
    selectedDishes = {};
    trs.forEach(tr => {
        tr.remove();
    })
    updateTotalPrice()
}

function submit(){
    const form = document.getElementById('formOrdering');
    makeDishIdsInputs(form);
    makeRemarkInputs(form);
    form.submit();
}

function makeDishIdsInputs(form){
    for (const [key, value] of Object.entries(selectedDishes)) {
        let element = document.createElement('input');
        element.type = 'number';
        element.name = 'dishesId[]';
        element.value = value.dish.id;
        element.hidden = true;
        form.append(element);
    }
}

function makeRemarkInputs(form){
    for (const [key, value] of Object.entries(selectedDishes)) {
        let element = document.createElement('input');
        element.type = 'text';
        element.name = 'remarks[]';
        element.hidden = true;
        element.value = value.remark;
        form.append(element);
    };
}
