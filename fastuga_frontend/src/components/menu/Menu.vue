<script setup>
// A menu has items 
// const props = defineProps({
//     items: {
//         type: Array,
//         default: () => [],
//     }
// })

const items = [1, 2, 3, 4];

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
            <!-- For each item... -->
            <tr v-for="item in items">
                <td>
                    <img src="https://via.placeholder.com/150" />
                </td>
                <td>
                    <span>My amazing item</span>
                </td>
                <td>
                    <span>
                        Hot dish?
                    </span>
                </td>
                <td>
                    <span>
                        The hottest dish to ever dish.
                    </span>
                </td>
                <td>
                    <span>
                        350000€
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