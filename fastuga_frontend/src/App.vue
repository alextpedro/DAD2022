<script setup>
import { ref, inject } from 'vue';
import { useRouter, RouterLink, RouterView } from 'vue-router';
import { useUserStore } from './stores/user.js';

const userStore = useUserStore();
const router = useRouter();
const toast = inject('toast');

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
		router.push({ name: 'home' });
	} else {
		toast.error('There was a problem logging out of the application!');
	}
};

</script>

<template>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top flex-md-nowrap p-0 shadow">
		<div class="container-fluid">
			<router-link class="navbar-brand col-md-3 col-lg-2 me-0 px-3" :to="{ name: 'Home' }">
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
					<li class="nav-item">
						<router-link class="nav-link pr-3" to="/register">Register</router-link>
					</li>
					<li class="nav-item">
						<router-link class="nav-link" :class="{ active: $route.name === 'Login' }"
							:to="{ name: 'Login' }">
							<i class="bi bi-box-arrow-in-right"></i>
							Login
						</router-link>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
							data-bs-toggle="dropdown" aria-expanded="false">
							<img src="@/assets/avatar-exemplo-1.jpg" class="rounded-circle z-depth-0 avatar-img"
								alt="avatar image" />
							<span class="avatar-text">User Name</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end"
							aria-labelledby="navbarDropdownMenuLink">
							<!-- <li>
								<router-link class="dropdown-item"
									:class="{ active: $route.name == 'User' && $route.params.id == 1 }"
									:to="{ name: 'User', params: { id: 1 } }">
									<i class="bi bi-person-square"></i>Profile
								</router-link>
							</li>
							<li>
								<router-link class="dropdown-item" :class="{ active: $route.name === 'ChangePassword' }"
									:to="{ name: 'ChangePassword' }">
									<i class="bi bi-key-fill"></i>
									Change password
								</router-link>
							</li> -->
							<li>
								<hr class="dropdown-divider" />
							</li>
							<li>
								<a class="dropdown-item" @click.prevent="logout">
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
								:to="{ name: 'Menu' }">
								<i class="bi bi-book"></i>
								Menu
							</router-link>
						</li>
						<li class="nav-item">
							<!-- <router-link
                class="nav-link"
                :class="{ active: $route.name === 'CurrentTasks' }"
                :to="{ name: 'CurrentTasks' }"
              >
                <i class="bi bi-list-stars"></i>
                Current Tasks
              </router-link> -->
						</li>
						<li class="nav-item d-flex justify-content-between align-items-center pe-3">
							<!-- <router-link
                class="nav-link w-100 me-3"
                :class="{ active: $route.name === 'Tasks' }"
                :to="{ name: 'Tasks' }"
              >
                <i class="bi bi-list-check"></i>
                Tasks
              </router-link>
              <router-link class="link-secondary" :to="{ name: 'NewTask'}" aria-label="Add a new task">
                <i class="bi bi-xs bi-plus-circle"></i>
              </router-link> -->
						</li>
						<li class="nav-item">
							<!-- <router-link
                class="nav-link"
                :class="{ active: $route.name === 'Projects' }"
                :to="{ name: 'Projects' }"
              >
                <i class="bi bi-files"></i>
                Projects
              </router-link> -->
						</li>
						<!-- <li class="nav-item"> -->
							<!-- <router-link
                class="nav-link"
                :class="{ active: $route.name === 'Users' }"
                :to="{ name: 'Users' }"
              >
                <i class="bi bi-people"></i>
                Team Members
              </router-link> -->
						
						<li class="nav-item">
							<!-- <router-link class="nav-link bi bi-person" to="/register">Register</router-link> -->
							<router-link class="nav-link" :class="{ active: $route.name === 'listusers' }" :to="{ name: 'listusers' }">
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
						<li class="nav-item">
							<router-link class="nav-link w-100 me-3" :to="{ name: 'Plataformstatistics'}" aria-label="See platform statistics.">
								<i class="bi bi-bar-chart-line">Statistics</i>
							</router-link>
						</li>
						<!--<li class="nav-item" v-for="prj in workInProgressProjects" :key="prj.id">
							<router-link class="nav-link w-100 me-3" 
                :class="{active: $route.name == 'ProjectTasks' && $route.params.id == prj.id}"
                :to="{ name: 'ProjectTasks', params: { id: prj.id }}">
                <i class="bi bi-file-ruled"></i>
                {{ prj.name}}
              </router-link> 
						</li>-->
					</ul>

					<div class="d-block d-md-none">
						<h6
							class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
							<span>User</span>
						</h6>
						<ul class="nav flex-column mb-2">
							<li class="nav-item">
								<a class="nav-link" href="#"><i class="bi bi-person-check-fill"></i>
									Register
								</a>
							</li>
							<li class="nav-item">
								<router-link class="nav-link" :class="{ active: $route.name === 'Login' }"
									:to="{ name: 'Login' }">
									<i class="bi bi-box-arrow-in-right"></i>
									Login
								</router-link>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button"
									data-bs-toggle="dropdown" aria-expanded="false">
									<img src="@/assets/avatar-exemplo-1.jpg" class="rounded-circle z-depth-0 avatar-img"
										alt="avatar image" />
									<span class="avatar-text">User Name</span>
								</a>
								<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
									<li>
										<!-- <router-link
                      class="dropdown-item"
                      :class="{ active: $route.name == 'User' && $route.params.id == 1 }"
                      :to="{ name: 'User', params: { id: 1 } }"
                    >
                      <i class="bi bi-person-square"></i>Profile
                    </router-link> -->
									</li>
									<li>
										<!-- <router-link
                      class="dropdown-item"
                      :class="{ active: $route.name === 'ChangePassword' }"
                      :to="{ name: 'ChangePassword' }"
                    >
                      <i class="bi bi-key-fill"></i>
                      Change password
                    </router-link> -->
									</li>
									<li>
										<hr class="dropdown-divider" />
									</li>
									<li>
										<a class="dropdown-item" @click.prevent="logout">
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
