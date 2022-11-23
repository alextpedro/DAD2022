<script setup>
const items = [
    {
        id: 1,
        lastYearOrders: 3500
    }
];
</script>

<template>
    <table class="table">
        <thead>
            <tr>
                <th>lastYearOrders</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in items">
                <td>
                    <span>
                        {{item.lastYearOrders}}
                    </span>
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