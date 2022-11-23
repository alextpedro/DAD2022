<script setup>
const items = [
    {
        id: 1,
        photo_url: 'https://via.placeholder.com/150',
        name: 'Francisco',
        email: 'email@email.com',
        type: 'EM',
        phoneNumber: '123456789',
        points: 12,
        nif: 350000
    },
    {
        id: 2,
        photo_url: 'https://via.placeholder.com/150',
        name: 'Francisco 2',
        email: 'email2@email.com',
        type: 'EM',
        phoneNumber: '123456789',
        points: 12,
        nif: 350000
    },
    {
        id: 3,
        photo_url: 'https://via.placeholder.com/150',
        name: 'Francisco 3',
        email: 'email3@email.com',
        type: 'EM',
        phoneNumber: '123456789',
        points: 12,
        nif: 350000
    }
];
</script>

<template>
    <table class="table">
        <thead>
            <tr>
                <th>Photo</th>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Phone Number</th>
                <th>Points</th>
                <th>Nif</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in items">
                <td>
                    <img :src="item.photo_url" />
                </td>
                <td>
                    <span>
                        {{ item.id }}
                    </span>
                </td>
                <td>
                    <span>{{ item.name }}</span>
                </td>
                <td>
                    <span>
                        {{ item.email }}
                    </span>
                </td>
                <td>
                    <span>
                        {{ item.type }}
                    </span>
                </td>
                <td>
                    <span>
                        {{ item.phoneNumber }}
                    </span>
                </td>
                <td>
                    <span>
                        {{ item.points }}
                    </span>
                </td>
                <td>
                    <span>
                        {{ item.nif }}
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
