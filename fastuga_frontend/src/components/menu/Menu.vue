<script setup>
// A menu has items 
// const props = defineProps({
//     items: {
//         type: Array,
//         default: () => [],
//     }
// })

// Placeholder for development purposes
const items = [
    {
        id: 1,
        name: 'My amazing item',
        type: 'Hot dish?',
        description: 'The hottest dish to ever dish.',
        photo_url: 'https://via.placeholder.com/150',
        price: 350000
    }, {
        id: 2,
        name: 'Salad',
        type: 'Hot dish?',
        description: 'The hottest dish to ever dish.',
        photo_url: 'https://via.placeholder.com/150',
        price: 350000
    }, 
    {
        id: 3,
        name: 'My amazing item',
        type: 'Hot dish?',
        description: 'The hottest dish to ever dish.',
        photo_url: 'https://via.placeholder.com/150',
        price: 350000
    }, 
    {
        id: 4,
        name: 'My amazing item',
        type: 'Hot dish?',
        description: 'The hottest dish to ever dish.',
        photo_url: 'https://via.placeholder.com/150',
        price: 350000
    }];

</script>

<template>
    <table class="table">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Type</th>
                <th>Description</th>
                <th>Price</th>
                <th>Order?</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in items">
                <td>
                    <img :src="item.photo_url" />
                </td>
                <td>
                    <span>{{item.name}}</span>
                </td>
                <td>
                    <span>
                        {{item.type}}
                    </span>
                </td>
                <td>
                    <span>
                        {{item.description}}
                    </span>
                </td>
                <td>
                    <span>
                        {{item.price}}€
                    </span>
                </td>
                <td>
                    <input type="checkbox" value="Add to Order" />
                </td>
            </tr>
        </tbody>
    </table>
</template>
  
<style scoped>
button {
    margin-left: 3px;
    margin-right: 3px;
}
</style>