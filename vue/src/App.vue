<script setup>
import { ref, inject, onMounted } from 'vue';
import { useRouter, RouterLink, RouterView } from 'vue-router';
import { useUserStore } from './stores/user.js';
import { useOrderStore } from '@/stores/order.js';

const userStore = useUserStore();
const router = useRouter();
const toast = inject('toast');
const orderStore = useOrderStore();

const buttonSidebarExpand = ref(null);

const clickMenuOption = () => {
	if (window.getComputedStyle(buttonSidebarExpand.value).display !== 'none') {
		buttonSidebarExpand.value.click();
	}
};

const logout = async () => {
	if (await userStore.logout()) {
		toast.success('User has logged out of the application.');
		clickMenuOption();
		router.push({ name: 'Home' });
	} else {
		toast.error('There was a problem logging out of the application!');
	}
};

onMounted(() => {
	orderStore.initTickets();
});

</script>

<template>
	<!-- Upper nav bar -->
	<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top flex-md-nowrap p-0 shadow">
		<div class="container-fluid">
			<!-- App name -->
			<router-link class="navbar-brand col-md-3 col-lg-2 me-0 px-3" :to="{ name: 'Home' }" @click="clickMenuOption">
				<img src="@/assets/logo.svg" alt="" width="30" height="24" class="d-inline-block align-text-top" />
				FasTuga
			</router-link>
			<button id="buttonSidebarExpandId" ref="buttonSidebarExpand" class="navbar-toggler" type="button"
				data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
				aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse justify-content-end">
				<ul class="navbar-nav">
					<li class="nav-item" v-if="!userStore.user">
						<router-link class="nav-link pr-3" to="/register" @click="clickMenuOption">
							<i class="bi bi-person-check-fill"></i>
							Register
						</router-link>
					</li>
					<li class="nav-item" v-if="!userStore.user">
						<router-link class="nav-link" :class="{ active: $route.name === 'Login' }"
							:to="{ name: 'Login' }" @click="clickMenuOption">
							<i class="bi bi-box-arrow-in-right"></i>
							Login
						</router-link>
					</li>
					<li class="nav-item dropdown" v-show="userStore.user">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
							data-bs-toggle="dropdown" aria-expanded="false">
							<img
								:src="userStore.userPhotoUrl"
								class="rounded-circle z-depth-0 avatar-img"
								alt="avatar image" />
								<span class="avatar-text">{{ userStore.user?.name ?? "Anonymous" }}</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end"
							aria-labelledby="navbarDropdownMenuLink">
							<li>
								<router-link class="dropdown-item" 
									:class="{ active: $route.name == 'User'}"
									v-if="userStore.user"
									:to="{ name: 'EditUser', params: { id: userStore.user?.id } }" 
									@click="clickMenuOption">
									<i class="bi bi-person-square"></i>
									Profile
								</router-link>
							</li>
							<li>
								<router-link class="dropdown-item" :class="{ active: $route.name === 'ChangePassword' }"
									:to="{ name: 'Home' }" @click="clickMenuOption">
									<i class="bi bi-key-fill"></i>
									Change password
								</router-link>
							</li>
							<li>
								<hr class="dropdown-divider" />
							</li>
							<li>
								<a class="dropdown-item" @click.prevent="logout" @click="clickMenuOption">
									<i class="bi bi-arrow-right"></i>Logout
								</a>
							</li> 
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- SIDEBAR -->
	<div class="container-fluid">
		<div class="row">
			<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
				<div class="position-sticky pt-3">
					<ul class="nav flex-column">
						<li class="nav-item">
							<router-link class="nav-link" :class="{ active: $route.name === 'Menu' }"
								:to="{ name: 'Menu' }" @click="clickMenuOption">
								<i class="bi bi-book"></i>
								Menu
							</router-link>
						</li>
						
						<li class="nav-item">
							<router-link class="nav-link" :class="{ active: $route.name === 'ListUsers' }" :to="{ name: 'ListUsers' }" @click="clickMenuOption">
								<i class="bi bi-person"></i>
								Users
							</router-link>
						</li>
					</ul>

					<!-- API-DEPENDENT SIDEBAR -->
					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span>API Routes</span>
						
					</h6>
					<ul class="nav flex-column mb-2">
						<li class="nav-item" v-if="userStore.user?.type === 'EM'">
							<router-link class="nav-link w-100 me-3" :to="{ name: 'Plataformstatistics'}" aria-label="See platform statistics." @click="clickMenuOption">
								<i class="bi bi-bar-chart-line">Statistics</i>
							</router-link>
						</li>
						
						<li class="nav-item" v-if="userStore.user?.type === 'EC'">
							<router-link class="nav-link" :class="{ active: $route.name === 'Dishes' }"
								:to="{ name: 'Dishes' }" @click="clickMenuOption">
								<i class="bi bi-list-stars"></i>
								Available Dishes
							</router-link>
						</li>

						<li class="nav-item" v-if="userStore.user?.type === 'EC'">
							<router-link class="nav-link" :class="{ active: $route.name === 'Chefs' }"
								:to="{ name: 'Chefs' }" @click="clickMenuOption">
								<i class="bi bi-list-stars"></i>
								My Dishes
							</router-link>
						</li>

						<li class="nav-item" v-if="userStore.user">
							<router-link class="nav-link" :class="{ active: $route.name === 'MyOrders' }"
								:to="{ name: 'MyOrders' }" @click="clickMenuOption">
								<i class="bi bi-list-stars"></i>
								My Orders
							</router-link>
						</li>

						<li class="nav-item" v-if="userStore.user?.type === 'EC'">
							<router-link class="nav-link" :class="{ active: $route.name === 'AllDishes' }"
								:to="{ name: 'AllDishes' }" @click="clickMenuOption">
								<i class="bi bi-list-stars"></i>
								Dish History
							</router-link>
						</li>
					</ul>

					<!-- Dropdown Nav Bar -->
					<div class="d-block d-md-none">
						<h6
							class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
							<span>User</span>
						</h6>
						<ul class="nav flex-column mb-2">
							<li class="nav-item" v-if="!userStore.user">
								<a class="nav-link" href="#"><i class="bi bi-person-check-fill"></i>
									Register
								</a>
							</li>
							<li class="nav-item" v-if="!userStore.user">
								<router-link class="nav-link" :class="{ active: $route.name === 'Login' }"
									:to="{ name: 'Login' }" @click="clickMenuOption">
									<i class="bi bi-box-arrow-in-right"></i>
									Login
								</router-link>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button"
									data-bs-toggle="dropdown" aria-expanded="false">
									<img :src="userStore.userPhotoUrl" class="rounded-circle z-depth-0 avatar-img"
										alt="avatar image" />
									<span class="avatar-text">{{ userStore.user?.name ?? "Anonymous" }}</span>
								</a>
								<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
									<li>
										<router-link class="dropdown-item" 
											:class="{ active: $route.name == 'User'}"
											v-if="userStore.user"
											:to="{ name: 'EditUser', params: { id: userStore.user?.id } }" 
											@click="clickMenuOption">
											<i class="bi bi-person-square"></i>
											Profile
										</router-link>
									</li>
									<li>
										<router-link class="dropdown-item" :class="{ active: $route.name === 'ChangePassword' }"
											:to="{ name: 'Home' }" @click="clickMenuOption">
											<i class="bi bi-key-fill"></i>
											Change password
										</router-link>
									</li>
									<li>
										<hr class="dropdown-divider" />
									</li>
									<li>
										<a class="dropdown-item" @click.prevent="logout" @click="clickMenuOption">
											<i class="bi bi-arrow-right"></i>Logout
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>

			<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
				<router-view></router-view>
			</main>
		</div>
	</div>
</template>

<style>
@import "./assets/dashboard.css";

.avatar-img {
	margin: -1.2rem 0.8rem -2rem 0.8rem;
	width: 3.3rem;
	height: 3.3rem;
}

.avatar-text {
	line-height: 2.2rem;
	margin: 1rem 0.5rem -2rem 0;
	padding-top: 1rem;
}

.dropdown-item {
	font-size: 0.875rem;
}

.btn:focus {
	outline: none;
	box-shadow: none;
}

#sidebarMenu {
	overflow-y: auto;
}
</style>
