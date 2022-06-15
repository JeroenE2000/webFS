<template>
    <div class="col-sm-3 mt-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="float-left fw-bold" v-html="dish['name']"></div>
                    <div class="dropdown-content">
                        <div v-if="allergens.length === 0" class="text-center">Geen allergenen</div>
                        <div v-for="allergen in allergens" :key="allergen.id" class="text-center">{{allergen.name}}</div>
                    </div>
                    <small>{{ '🌶️'.repeat(dish.spicness_scale) }}</small>
                    <div v-if="(dish['description'] && dish['description'].length > 45)" class="fst-italic" v-html="formatDescription(dish['description'])+'...'"></div>
                    <div v-else class="fst-italic" v-html="dish['description']"></div>
                    <div v-if="sales[dish['id']]">
                        <div class="mt-2">
                            <del>&euro; {{formatPrice(dish['price'])}}</del>
                        </div>
                        <span>&euro; {{formatPrice(sales[dish['id']])}}</span>
                    </div>
                    <div v-else>&euro; {{ formatPrice(dish['price'])}}</div>
                    <button :id = "'submit' + dish['id']" type="submit" class="btn btn-primary center">Toevoegen</button>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    props: ['sales','dish','allergens'],
    data() {
        return {
            sales: this.sales,
            dish: this.dish,
            allergens: this.allergens,
            route: window.location.href.split('/').pop()
        }
    },
    methods: {
        formatPrice(value) {
            let val = (value / 1).toFixed(2).replace('.', ',');
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        formatDescription(value) {
            let string = value.substring(0, 45);
            return string;
        }
    },
    computed: {
        console: () => this.sales,
    },
}
</script>
