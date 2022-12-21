<!-- eslint-disable indent -->
<script setup>
import { useRouter } from 'vue-router';
import { inject, onMounted, ref, computed } from 'vue';
import { useUserStore } from '@/stores/user.js';

const router = useRouter();
const axios = inject('axios');
const serverBaseUrl = inject('serverBaseUrl');

const userStore = useUserStore();

const selectedUsers = ref([]);

const users = ref([]);

const showEditButton = (userId) => {
  return userId == userStore.user?.id || userStore.user?.type === 'EM';
};

const loadUsers = () => {
	axios.get('users')
		.then((response) => {
			users.value = response.data.data;
		})
		.catch((error) => {
			console.log(error);
		});
};

const editUser = (user) => {
	userStore.user = user;
	router.push({name: 'EditUser', params: { id: user.id }});
};

const deleteUser = () => {
    axios.delete('/users' + editUser.id).then(() => {
        console.log('SUCCESS!!');
        router.push({ name: 'ListUsers' });
    }).catch(() => {
        console.log('FAILURE!!');
    });
};

onMounted(() => {
	loadUsers();
});
</script>


<template>
    <table class="table">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id">
                <td class="align-middle">
                    <img :src="serverBaseUrl + '/storage/fotos/' + user.photo_url" width="64" height="64" />
                </td>
                <td class="align-middle">
                    <span>{{ user.name }}</span>
                </td>
                <td class="align-middle">
                    <span>
                        {{ user.email }}
                    </span>
                </td>
                <td class="align-middle">
                    <span>
                        {{ user.type }}
                    </span>
                </td>
                <td class="align-middle">
                    <button class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(user.id)" v-if="userStore.user?.type === 'EM'">
                        Delete
                    </button>
                    <button type="button" class="btn btn-info" @click="editUser(user)" v-if="showEditButton(user.id)"><span class="bi-pencil-square"></span></button></td>
            </tr>
        </tbody>
    </table>

    <div class="btn-group float-end" role="group">
        <!-- Botão para CANCELAR -->
        <!-- <button type="button" class="btn btn-secondary">
            <router-link class="nav-link" :to="{ name: 'Home' }">
                Cancel
            </router-link>
        </button> -->
        <!--For managers-->
        <button type="button" class="btn btn-info" v-if="userStore.user?.type === 'EM'">
            <router-link class="nav-link" :to="{ name: 'Home' }">
                Add User
            </router-link>
        </button>
    </div>

</template>

<style scoped>
button {
    margin-left: 3px;
    margin-right: 3px;
}
</style>
