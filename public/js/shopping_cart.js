let dishes = window.myArray[0];
let sales = window.myArray[1];

const formatter = new Intl.NumberFormat('nl-NL', {   style: 'currency',   currency: 'EUR' })

window.addEventListener('load', (e) => {
    let tempDishes = {};
    console.log(dishes);
    dishes.forEach(dish => {
        tempDishes[dish.id] = dish;
    });
    dishes = tempDishes;
    document.getElementById('orderBtn').addEventListener('click', (e) => {
        e.preventDefault();
        let orderList = JSON.parse(localStorage.getItem('orderList'));
        if(orderList && orderList.length === 0 || !orderList) {
            Swal.fire({
                icon: 'error',
                title: 'Oops er zijn nog geen gerechten toegevoegd aan de bestelling!',
            })
        } else {
            submit("POGGERS bestelling gelukt!");
        }
    });
    showShoppingCart();
});


function showShoppingCart() {
    let shoppingCart = document.getElementById('shopping_cart');
    let orderList = JSON.parse(localStorage.getItem('orderList'));
    if(orderList) {
        showDishes(orderList);
    } else {
        let h2 = document.createElement('h2');
        h2.innerHTML = 'Uw bestelling is nog leeg!';
        shoppingCart.appendChild(h2);
    }
}

function showDishes(orderList) {
    let shoppingCart = document.getElementById('shopping_cart');
    let table = document.createElement('table');
    table.className = 'w-100';
    for(const [index, orderLine] of Object.entries(orderList)) {
        let dish = dishes[orderLine.dishId];
        let dishNumber = dish.dishnumber ? dish.dishnumber : '' + dish.dish_addition ? dish.dish_addition : '';
        table.append(createTableRow('('+dish.id+')', orderLine.amount, dishNumber, dish.name , orderLine.remark, getPrice(dish), dish));
    }
    shoppingCart.appendChild(table);
    updateTotalPrice();
}

function createTableRow(id, amount, dishNumber, name, remark, price, dish) {
    let tr = document.createElement('tr');
    let td1 = document.createElement('td');
    const input = document.createElement('input');
    input.id = id;
    input.name = 'amounts[]';
    input.style.width = '50px';
    input.type = 'number';
    input.min = '0';
    input.value = amount;
    input.addEventListener('change', (e) => {
        e.preventDefault();
        let orderList = JSON.parse(localStorage.getItem('orderList'));
        let value = parseInt(input.value);
        if(orderList[id].amount < value) {
            addAmount(orderList, id, value-orderList[id].amount);
            updatePrice(id);
        } else {
            removeAmount(orderList, id, orderList[id].amount-value);
            if(input.value === "0") {
                tr.remove();
            } else {
                updatePrice(id);
            }
        }
        updateTotalPrice();
    })
    td1.append(input);
    let td2 = document.createElement('td');
    td2.innerHTML = dishNumber;
    let td3 = document.createElement('td');
    td3.innerHTML = name
    if(remark) {
        let inputRemark = document.createElement('input');
        inputRemark.id = id;
        inputRemark.name = 'remarks[]';
        inputRemark.type = 'text';
        inputRemark.value = remark;
        td3.append(inputRemark);
    } else {
        let inputRemark = document.createElement('input');
        inputRemark.id = id;
        inputRemark.name = 'remarks[]';
        inputRemark.type = 'text';
        inputRemark.placeholder = 'Plaats hier een opmerking';
        td3.append(inputRemark);
    }
    let td4 = document.createElement('td');
    td4.id = 'price'+id;
    let tempPrice =  parseFloat(dish.price);
    if(price !== tempPrice){
        td4.innerHTML = '<span class="sale-color strikethrough">'+formatter.format(tempPrice*amount)+'</span>' +
        '<span>'+formatter.format(price*amount)+'</span>';
    } else {
        td4.innerHTML = formatter.format(price*amount);
    }
    tr.append(td1, td2, td3, td4);
    return tr;
}

function getPrice(dish) {
    let price = 0;
    if(sales[dish.id]) {
        price = sales[dish.id];
    } else {
        price = parseFloat(dish.price);
    }
    return price;
}

function updatePrice(id) {
    let orderList = JSON.parse(localStorage.getItem('orderList'));
    let dish = dishes[orderList[id].dishId];
    let amount = orderList[id].amount;
    if(sales[dish.id]) {
        document.getElementById('price' + id).innerHTML = '<span class="sale-color strikethrough">'
        +formatter.format((parseFloat(dish.price))*amount)+'</span>';
    } else {
        let dishPrice = parseFloat(dish.price);
        document.getElementById('price' + id).innerHTML = formatter.format(dishPrice*amount);
    }
}

function updateTotalPrice() {
    let orderList = JSON.parse(localStorage.getItem('orderList'));
    let totalPrice = 0;
    for(const [index, value] of Object.entries(orderList)) {
        let dish = dishes[value.dishId];
        if(sales[dish.id]) {
            totalPrice += (parseFloat(sales[dish.id])) * value.amount;
        } else {
            totalPrice += (parseFloat(dishes[value.dishId].price)) * value.amount;
        }
    }
    document.getElementById('total_price').textContent = formatter.format(totalPrice);
}

function addAmount(orderList, id, amount) {
    orderList[id].amount += amount;
    localStorage.setItem('orderList', JSON.stringify(orderList));
}

function removeAmount(orderList, id, amount) {
    orderList[id].amount -= amount;
    if(orderList[id].amount === 0){
        delete orderList[id];
    }
    localStorage.setItem('orderList', JSON.stringify(orderList));
}

function submit(name){
    let orderList = JSON.parse(localStorage.getItem('orderList'));
    const form = document.getElementById('form');
    makeDishIdsInputs(orderList, form);
    makeRemarkInputs(orderList, form);
    localStorage.clear();
    form.submit();
}

function makeDishIdsInputs(orderList, form) {
    for (const [uniqueId, orderLine] of Object.entries(orderList)) {
        let element = document.createElement('input');
        element.type = 'number';
        element.name = 'dishIds[]';
        element.value = orderLine.dishId;
        element.hidden = true;
        form.append(element);
    }
}

function makeRemarkInputs(orderList, form){
    for (const [uniqueId, orderLine] of Object.entries(orderList)) {
        let element = document.createElement('input');
        element.type = 'text';
        element.name = 'remarks[]';
        element.hidden = true;
        element.value = orderLine.remark;
        form.append(element);
    };
}


